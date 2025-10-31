<div class="space-y-6">
    <div>
        <input type="text" placeholder="Search orders" class="input input-bordered w-64 border rounded px-3 py-2"
            wire:model.live.debounce.300ms="search" />
    </div>
    <div class="overflow-x-auto rounded border bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Code</th>
                    <th class="px-3 py-2 text-left">Customer</th>
                    <th class="px-3 py-2 text-left">Date</th>
                    <th class="px-3 py-2 text-left">Items</th>
                    <th class="px-3 py-2 text-left">Total (IDR)</th>
                    <th class="px-3 py-2 text-left">Cashier</th>
                    <th class="px-3 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-3 py-2">{{ $order->code }}</td>
                        <td class="px-3 py-2">{{ $order->customer_name }}</td>
                        <td class="px-3 py-2">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-3 py-2">
                            <div>
                                {{ $order->items->count() }} items
                            </div>
                            <div>
                                expand
                            </div>
                        </td>
                        <td class="px-3 py-2">{{ $order->total }}</td>
                        <td class="px-3 py-2">{{ $order->customer_name }}</td>
                        <td class="px-3 py-2 text-right">
                            <button class="px-3 py-1.5 text-sm rounded border"
                                wire:click="openEdit({{ $order->id }})">Edit</button>
                            <button class="px-3 py-1.5 text-sm rounded border"
                                wire:click="openEdit({{ $order->id }})">Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $orders->links() }}
    </div>
</div>
