{{-- resources/views/livewire/product/index.blade.php --}}
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <h1 class="text-2xl font-semibold">Products</h1>

        <div class="flex items-center gap-2">
            <input type="text" placeholder="Search by name or SKU"
                class="input input-bordered w-64 border rounded px-3 py-2" wire:model.debounce.300ms="search" />

            <div class="inline-flex rounded border overflow-hidden">
                <button class="px-3 py-2 text-sm {{ $viewMode === 'grid' ? 'bg-gray-900 text-white' : 'bg-white' }}"
                    wire:click="$set('viewMode','grid')">Grid</button>
                <button class="px-3 py-2 text-sm {{ $viewMode === 'table' ? 'bg-gray-900 text-white' : 'bg-white' }}"
                    wire:click="$set('viewMode','table')">Table</button>
            </div>

            <button class="px-4 py-2 rounded bg-indigo-600 text-white" wire:click="openCreate">Create Product</button>
        </div>
    </div>

    {{-- Flash --}}
    @if (session('ok'))
        <div class="p-3 rounded bg-emerald-50 text-emerald-800 text-sm">{{ session('ok') }}</div>
    @endif

    {{-- BODY: Grid/Table --}}
    @if ($viewMode === 'grid')
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($products as $product)
                <div class="rounded-lg border bg-white p-4 shadow-sm flex flex-col h-full">
                    <div class="aspect-[4/3] bg-gray-100 rounded flex items-center justify-center overflow-hidden">
                        @if ($product->image_path)
                            <img class="w-full h-full object-cover" src="{{ Storage::url($product->image_path) }}"
                                alt="{{ $product->name }}">
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <div class="font-semibold text-sm">{{ $product->name }}</div>
                        <div class="mt-1 text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                        <div class="text-xs text-gray-500">Type: {{ ucfirst($product->type) }}</div>
                        @if ($product->notes)
                            <p class="mt-2 text-xs text-gray-500">
                                {{ \Illuminate\Support\Str::limit($product->notes, 80) }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-auto flex justify-end pt-3">
                        <button class="px-3 py-1.5 text-sm rounded border"
                            wire:click="openEdit({{ $product->id }})">Edit</button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="overflow-x-auto rounded border bg-white">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left">Image</th>
                        <th class="px-3 py-2 text-left">Name</th>
                        <th class="px-3 py-2 text-left">SKU</th>
                        <th class="px-3 py-2 text-left">Type</th>
                        <th class="px-3 py-2 text-left">Karat</th>
                        <th class="px-3 py-2 text-left">Sell/gr</th>
                        <th class="px-3 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($products as $p)
                        <tr>
                            <td class="px-3 py-2">
                                <div
                                    class="w-16 h-12 rounded bg-gray-100 overflow-hidden flex items-center justify-center">
                                    @if ($p->image_path)
                                        <img class="w-full h-full object-cover"
                                            src="{{ Storage::url($p->image_path) }}">
                                    @else
                                        <span class="text-[10px] text-gray-400">No Image</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-2">{{ $p->name }}</td>
                            <td class="px-3 py-2">{{ $p->sku }}</td>
                            <td class="px-3 py-2">{{ ucfirst($p->type) }}</td>
                            <td class="px-3 py-2">{{ $p->karat }}</td>
                            <td class="px-3 py-2">{{ $p->sell_price_per_gram }}</td>
                            <td class="px-3 py-2 text-right">
                                <button class="px-3 py-1.5 text-sm rounded border"
                                    wire:click="openEdit({{ $p->id }})">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div>
        {{ $products->links() }}
    </div>

    {{-- CREATE MODAL --}}
    <x-modal wire:model="showCreate" title="Create Product">
        <form wire:submit.prevent="save" class="space-y-3">
            @include('livewire.product.partials.form-fields')

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" class="px-3 py-2 rounded border"
                    wire:click="$set('showCreate', false)">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">Save</button>
            </div>
        </form>
    </x-modal>

    {{-- EDIT MODAL --}}
    <x-modal wire:model="showEdit" title="Edit Product">
        <form wire:submit.prevent="update" class="space-y-3">
            @include('livewire.product.partials.form-fields')

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" class="px-3 py-2 rounded border"
                    wire:click="$set('showEdit', false)">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">Update</button>
            </div>
        </form>
    </x-modal>
</div>

{{-- Modal primitive (fallback) --}}
@once
    @push('styles')
        <style>
            dialog.modal {
                border: none;
                border-radius: 0.75rem;
                padding: 0;
                width: 640px;
                max-width: 95vw;
            }

            dialog::backdrop {
                background: rgba(0, 0, 0, .4);
            }
        </style>
    @endpush

    @push('components')
        @verbatim
            <script>
                // optional small helper if needed
            </script>
        @endverbatim
    @endpush
@endonce

{{-- Component: <x-modal> --}}
@props(['title' => ''])
@aware(['wire:model' => $model ?? null])
@php $model = $attributes->wire('model')->value(); @endphp
@if ($model)
    <dialog x-data x-on:close="$wire.set('{{ $model }}', false)" x-init="$watch('$wire.{{ $model }}', v => v ? $el.showModal() : $el.close())" class="modal">
        <div class="p-5 bg-white rounded-lg">
            <div class="text-lg font-semibold mb-3">{{ $title }}</div>
            {{ $slot }}
        </div>
    </dialog>
@endif
