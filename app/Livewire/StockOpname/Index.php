<?php

namespace App\Livewire\StockOpname;

use App\Models\StockOpname;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    public function render()
    {
        return '<div>Stock Opname Index</div>';
    }
}
