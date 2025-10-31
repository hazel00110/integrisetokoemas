<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div
            class="flex items-center h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h2 class="mx-auto">Stats Overview<span class="text-red-500 ml-4">not yet</span></h2>
        </div>
        <div class="grid auto-rows-min gap-4 grid-cols-2 md:grid-cols-3">
            <a wire:navigate href="{{ route('pos') }}"
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Kasir<span class="text-blue-500 ml-4">ongoing</span></h2>
            </a>
            <a wire:navigate href="{{ route('products') }}"
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Produk<span class="text-blue-500 ml-4">ongoing</span></h2>
            </a>
            <a
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Stock Opname<span class="text-red-500 ml-4">not yet</span></h2>
            </a>
            <a wire:navigate href="{{ route('employees') }}"
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">HR & Payroll<span class="text-red-500 ml-4">not yet</span></h2>
            </a>
            <a
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Statistik<span class="text-red-500 ml-4">not yet</span></h2>
            </a>
            <a wire:navigate href="{{ route('orders') }}"
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Orders<span class="text-red-500 ml-4">not yet</span></h2>
            </a>
        </div>
    </div>
</x-layouts.app>
