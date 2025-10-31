<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;

class Index extends Component
{
    public string $search = '';

    public function getOrdersQuery()
    {
        $query = Order::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function getUsername($userId)
    {
        $user = \App\Models\User::find($userId);
        return $user ? $user->name : 'Unknown';
    }

    public function render()
    {
        $orders = $this->getOrdersQuery()->paginate(10);

        return view('livewire.order.index', [
            'orders' => $orders,
        ]);
    }
}
