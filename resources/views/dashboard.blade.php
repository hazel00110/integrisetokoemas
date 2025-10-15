<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div
            class="flex items-center h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h2 class="mx-auto">Stats Overview</h2>
        </div>
        <div class="grid auto-rows-min gap-4 grid-cols-2 md:grid-cols-3">
            <a href=""
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Kasir</h2>
            </a>
            <div
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Produk</h2>
            </div>
            <div
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Stock Opname</h2>
            </div>
            <div
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">HR & Payroll</h2>
            </div>
            <div
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Statistik</h2>
            </div>
            <div
                class="flex items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h2 class="mx-auto">Pengaturan Toko</h2>
            </div>
        </div>
    </div>
</x-layouts.app>
