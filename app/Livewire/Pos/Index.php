<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\StockMove;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public string $barcode = '';
    public string $customer = '';
    public string $note = '';
    public float $cartDiscount = 0.0;

    /**
     * Struktur cart item:
     * [
     *   [
     *     'product_id' => 1,
     *     'name' => 'Cincin ...',
     *     'sku' => 'PRD-xxx',
     *     'price_per_gram' => 1025000.00,
     *     'making_fee' => 150000.00,
     *     'qty_pcs' => 0,
     *     'qty_gram' => 0.000,
     *   ],
     *   ...
     * ]
     */
    public array $items = [];

    public function render()
    {
        /** Paginate 12 best sellers */
        $products = Product::query()
            ->orderBy('sell_price_per_gram', 'desc')
            ->paginate(12);

        return view('livewire.pos.index', [
            'products' => $products,
            'totals'   => $this->computeTotals(),
        ]);
    }

    /** Add via barcode */
    public function addByBarcode(string $barcode): void
    {
        $p = Product::query()->where('barcode', $barcode)->first();
        if (!$p) {
            $this->dispatch('toast', type: 'error', message: 'Barcode tidak ditemukan');
            return;
        }
        $this->addItem((int)$p->id);
        $this->barcode = '';
    }

    /** Add via product button */
    public function addItem(int $productId): void
    {
        $p = Product::find($productId);
        if (!$p) return;

        $idx = collect($this->items)->search(fn($it) => $it['product_id'] === $productId);

        if ($idx === false) {
            $this->items[] = [
                'product_id'     => $p->id,
                'name'           => $p->name,
                'sku'            => $p->sku,
                'price_per_gram' => (float)($p->sell_price_per_gram ?? 0),
                'making_fee'     => (float)($p->making_fee ?? 0),
                'qty_pcs'        => 1,
                'qty_gram'       => 0.000, // default 0 gram; kalau jual batangan bisa isi berat
            ];
        } else {
            $this->items[$idx]['qty_pcs'] += 1;
        }
    }

    public function updateQtyPcs(int $index, int $pcs): void
    {
        if (!isset($this->items[$index])) return;
        $this->items[$index]['qty_pcs'] = max(0, $pcs);
    }

    public function updateQtyGram(int $index, $gram): void
    {
        if (!isset($this->items[$index])) return;
        $g = (float)$gram;
        $this->items[$index]['qty_gram'] = max(0, round($g, 3));
    }

    public function removeItem(int $index): void
    {
        if (!isset($this->items[$index])) return;
        array_splice($this->items, $index, 1);
    }

    public function clearCart(): void
    {
        $this->items = [];
        $this->cartDiscount = 0;
        $this->note = '';
        $this->customer = '';
    }

    /** Hitung total cart */
    public function computeTotals(): array
    {
        $subtotal = 0.0;

        foreach ($this->items as $it) {
            $line = ($it['qty_gram'] * $it['price_per_gram']) + ($it['making_fee'] * $it['qty_pcs']);
            $subtotal += $line;
        }

        $discount = max(0, (float)$this->cartDiscount);
        $tax = 0.0; // kalau ada PPN/PPH, hitung di sini
        $total = max(0, $subtotal - $discount + $tax);

        return compact('subtotal', 'discount', 'tax', 'total');
    }

    /** Checkout: simpan order + items + stock moves */
    public function checkout(): void
    {
        $userId = Auth::id() ?? null;
        if (empty($this->items)) {
            $this->dispatch('toast', type: 'error', message: 'Cart masih kosong');
            return;
        }

        $tot = $this->computeTotals();

        DB::transaction(function () use ($tot, $userId) {

            $order = Order::create([
                'code'          => $this->generateCode(),
                'customer_name' => $this->customer ?: null,
                'user_id'      => $userId,
                'subtotal'      => $tot['subtotal'],
                'discount'      => $tot['discount'],
                'tax'           => $tot['tax'],
                'total'         => $tot['total'],
                'notes'         => $this->note ?: null,
                'status'        => 'paid',
            ]);

            foreach ($this->items as $it) {
                $line = ($it['qty_gram'] * $it['price_per_gram']) + ($it['making_fee'] * $it['qty_pcs']);

                $oi = OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $it['product_id'],
                    'qty_pcs'        => $it['qty_pcs'],
                    'qty_gram'       => $it['qty_gram'],
                    'price_per_gram' => $it['price_per_gram'],
                    'making_fee'     => $it['making_fee'],
                    'line_total'     => $line,
                    'notes'          => null,
                ]);

                // Stock Move (keluar)
                StockMove::create([
                    'store_id'         => 1,
                    'product_id'       => $it['product_id'],
                    'lot_id'           => null,
                    'ref_type'         => 'sale',
                    'ref_id'           => $order->id,
                    'qty_gram_change'  => 0 - (float)$it['qty_gram'],
                    'qty_pcs_change'   => 0 - (int)$it['qty_pcs'],
                    'note'             => 'POS sale ' . $order->code,
                    'created_at'       => now(),
                ]);
            }
        });

        $this->clearCart();
        $this->dispatch('toast', type: 'success', message: 'Payment captured. Order created.');
    }

    protected function generateCode(): string
    {
        $date = now()->format('Ymd');
        $seq  = str_pad((string) (Order::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);
        return "POS-{$date}-{$seq}";
    }
}
