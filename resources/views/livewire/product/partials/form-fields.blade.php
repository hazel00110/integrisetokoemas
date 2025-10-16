{{-- resources/views/livewire/product/partials/form-fields.blade.php --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
    <div>
        <label class="block text-xs text-gray-600 mb-1">SKU *</label>
        <input type="text" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.sku">
        @error('form.sku') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Barcode</label>
        <input type="text" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.barcode">
        @error('form.barcode') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-xs text-gray-600 mb-1">Name *</label>
        <input type="text" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.name">
        @error('form.name') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Type *</label>
        <select class="w-full border rounded px-3 py-2" wire:model.defer="form.type">
            <option value="perhiasan">Perhiasan</option>
            <option value="batangan">Batangan</option>
            <option value="lain">Lain</option>
        </select>
        @error('form.type') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Karat</label>
        <input type="number" step="0.01" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.karat">
        @error('form.karat') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Buy Price / gram</label>
        <input type="number" step="0.01" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.buy_price_per_gram">
        @error('form.buy_price_per_gram') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Sell Price / gram</label>
        <input type="number" step="0.01" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.sell_price_per_gram">
        @error('form.sell_price_per_gram') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Making Fee</label>
        <input type="number" step="0.01" class="w-full border rounded px-3 py-2"
            wire:model.defer="form.making_fee">
        @error('form.making_fee') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-xs text-gray-600 mb-1">Notes</label>
        <textarea class="w-full border rounded px-3 py-2" rows="3"
            wire:model.defer="form.notes"></textarea>
        @error('form.notes') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-xs text-gray-600 mb-1">Image (optional)</label>
        <input type="file" class="w-full" wire:model="image" accept="image/*">
        @error('image') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror

        <div wire:loading wire:target="image" class="text-xs text-gray-500 mt-1">Uploading...</div>

        @if ($image)
        <div class="mt-2 w-40 h-28 bg-gray-100 rounded overflow-hidden">
            <img class="w-full h-full object-cover" src="{{ $image->temporaryUrl() }}">
        </div>
        @endif
    </div>
</div>