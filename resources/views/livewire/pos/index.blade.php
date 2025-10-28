{{-- resources/views/livewire/pos/index.blade.php --}}
<div class="grid md:grid-cols-3 gap-6">
    {{-- LEFT: Product quick-add + barcode --}}
    <section class="md:col-span-2 gap-4">
        <div class="sticky top-0 bg-white/70 backdrop-blur z-10 p-3 rounded border flex items-center gap-2">
            <input wire:model="barcode" wire:keydown.enter.prevent="addByBarcode(barcode)" type="text"
                placeholder="Scan / type barcode" class="w-full bg-gray-50 shadow-sm rounded px-3 py-2" />
            <button wire:click="addByBarcode(barcode)" class="px-3 py-2 bg-slate-900 text-white rounded">Add</button>
        </div>

        {{-- Quick picks --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach ($products as $p)
                <button wire:click="addItem({{ (int) $p->id }})"
                    class="bg-gray-50 shadow-sm rounded-lg p-3 text-left hover:shadow focus:outline-none">
                    <div class="aspect-[4/3] rounded bg-gray-100 overflow-hidden flex items-center justify-center">
                        @if ($p->image_path)
                            <img class="w-full h-full object-cover" src="{{ Storage::url($p->image_path) }}"
                                alt="{{ $p->name }}">
                        @else
                            <span class="text-xs text-gray-400">No Image</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <div class="font-semibold text-sm">{{ $p->name }}</div>
                        <div class="text-xs text-gray-500">SKU: {{ $p->sku }}</div>
                        <div class="text-xs text-gray-500">Sell/gr:
                            {{ number_format($p->sell_price_per_gram ?? 0, 0, ',', '.') }}</div>
                    </div>
                </button>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div>
            {{ $products->links() }}
        </div>
    </section>

    {{-- RIGHT: Cart --}}
    <aside class="bg-white rounded-lg border shadow-sm p-4 h-fit sticky top-0">
        <h2 class="font-semibold">Cart</h2>

        @if (empty($items))
            <p class="text-sm text-gray-500 mt-2">No items yet.</p>
        @else
            <div class="mt-3 space-y-3">
                @foreach ($items as $i => $it)
                    <div class="border rounded p-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <div class="font-medium">{{ $it['name'] }}</div>
                                <div class="text-xs text-gray-500">SKU: {{ $it['sku'] }}</div>
                            </div>
                            <button class="text-xs text-red-600"
                                wire:click="removeItem({{ $i }})">Remove</button>
                        </div>

                        <div class="mt-2 grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-[11px] text-gray-500">PCS</label>
                                <input type="number" min="0" class="w-full border rounded px-2 py-1"
                                    wire:change="updateQtyPcs({{ $i }}, $event.target.value)"
                                    value="{{ $it['qty_pcs'] }}">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500">Gram</label>
                                <input type="number" step="0.001" min="0"
                                    class="w-full border rounded px-2 py-1"
                                    wire:change="updateQtyGram({{ $i }}, $event.target.value)"
                                    value="{{ $it['qty_gram'] }}">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500">Making Fee</label>
                                <input type="number" step="0.01" min="0"
                                    class="w-full border rounded px-2 py-1"
                                    wire:model.lazy="items.{{ $i }}.making_fee">
                            </div>
                        </div>

                        <div class="mt-2 text-xs text-gray-500">
                            Sell/gr: {{ number_format($it['price_per_gram'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Discount + note --}}
        <div class="mt-4 space-y-2">
            <div>
                <label class="block text-xs text-gray-600">Discount (IDR)</label>
                <input type="number" step="0.01" min="0" class="w-full border rounded px-2 py-1"
                    wire:model.lazy="cartDiscount">
            </div>
            <div>
                <label class="block text-xs text-gray-600">Customer</label>
                <input type="text" class="w-full border rounded px-2 py-1" wire:model.lazy="customer">
            </div>
            <div>
                <label class="block text-xs text-gray-600">Note</label>
                <textarea rows="2" class="w-full border rounded px-2 py-1" wire:model.lazy="note"></textarea>
            </div>
        </div>

        {{-- Totals --}}
        @php $t = $totals; @endphp
        <div class="mt-4 text-sm border-t pt-3 space-y-1">
            <div class="flex justify-between">
                <span>Subtotal</span><span>{{ number_format($t['subtotal'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Discount</span><span>-{{ number_format($t['discount'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between"><span>Tax</span><span>{{ number_format($t['tax'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-semibold text-lg pt-1">
                <span>Total</span><span>{{ number_format($t['total'], 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-4 flex items-center gap-2">
            <button class="px-3 py-2 rounded border" wire:click="clearCart">Clear</button>
            <button class="flex-1 px-4 py-2 rounded bg-emerald-600 text-white" wire:click="checkout">Checkout</button>
        </div>
    </aside>
</div>
