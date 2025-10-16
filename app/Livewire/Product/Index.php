<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    /** UI state */
    public string $viewMode = 'grid';
    public string $search = '';
    public bool $showCreate = false;
    public bool $showEdit = false;

    /** editing context */
    public ?int $editingId = null;

    /** file upload (optional image) */
    public $image;

    /** form fields (create/edit) */
    public array $form = [
        'sku' => '',
        'barcode' => '',
        'name' => '',
        'type' => 'perhiasan', // perhiasan|batangan|lain
        'karat' => null,
        'buy_price_per_gram' => null,
        'sell_price_per_gram' => null,
        'making_fee' => 0,
        'notes' => '',
    ];

    protected string $paginationTheme = 'tailwind';

    /** Toggle view */
    public function setView(string $mode): void
    {
        $this->viewMode = in_array($mode, ['grid', 'table'], true) ? $mode : 'grid';
    }

    /** Re-run page 1 saat search berubah */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /** Validation rules dinamis (unique ignore saat edit) */
    protected function rules(): array
    {
        $id = $this->editingId;

        return [
            'form.sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($id),
            ],
            'form.barcode' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'barcode')->ignore($id),
            ],
            'form.name' => ['required', 'string', 'max:150'],
            'form.type' => ['required', Rule::in(['perhiasan', 'batangan', 'lain'])],
            'form.karat' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'form.buy_price_per_gram' => ['nullable', 'numeric', 'min:0'],
            'form.sell_price_per_gram' => ['nullable', 'numeric', 'min:0'],
            'form.making_fee' => ['nullable', 'numeric', 'min:0'],
            'form.notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB
        ];
    }

    /** Query utama (tetap sesuai style kamu) */
    protected function getProductsQuery(): Builder
    {
        return Product::query()
            ->when($this->search, function (Builder $query) {
                $s = "%{$this->search}%";
                $query->where(function (Builder $sub) use ($s) {
                    $sub->where('name', 'like', $s)
                        ->orWhere('sku', 'like', $s)
                        ->orWhere('barcode', 'like', $s);
                });
            })
            ->orderByDesc('created_at');
    }

    /** ---------- CREATE FLOW ---------- */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->showCreate = true;
    }

    public function save(): void
    {
        $this->validate();

        $payload = $this->form;

        if ($this->image) {
            // Simpan ke storage/app/public/products
            $path = $this->image->store('products', 'public');
            $payload['image_path'] = $path; // pastikan kolom ini ada (migration tambahan)
        }

        Product::create($payload);

        $this->showCreate = false;
        $this->resetForm();
        session()->flash('ok', 'Product created');
        $this->resetPage(); // biar item terbaru muncul di page 1
    }

    /** ---------- EDIT FLOW ---------- */
    public function openEdit(int $id): void
    {
        $p = Product::findOrFail($id);
        $this->editingId = $p->id;

        $this->form = [
            'sku' => $p->sku,
            'barcode' => $p->barcode,
            'name' => $p->name,
            'type' => $p->type,
            'karat' => $p->karat,
            'buy_price_per_gram' => $p->buy_price_per_gram,
            'sell_price_per_gram' => $p->sell_price_per_gram,
            'making_fee' => $p->making_fee,
            'notes' => $p->notes,
        ];

        $this->image = null;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->showEdit = true;
    }

    public function update(): void
    {
        $this->validate();

        $p = Product::findOrFail($this->editingId);
        $payload = $this->form;

        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $payload['image_path'] = $path;
        }

        $p->update($payload);

        $this->showEdit = false;
        $this->resetForm();
        session()->flash('ok', 'Product updated');
    }

    /** Reset form state ke default */
    public function resetForm(): void
    {
        $this->editingId = null;
        $this->form = [
            'sku' => '',
            'barcode' => '',
            'name' => '',
            'type' => 'perhiasan',
            'karat' => null,
            'buy_price_per_gram' => null,
            'sell_price_per_gram' => null,
            'making_fee' => 0,
            'notes' => '',
        ];
        $this->image = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    /** Render */
    public function render()
    {
        $products = $this->getProductsQuery()->paginate(12);

        return view('livewire.product.index', [
            'products' => $products,
        ]);
    }
}
