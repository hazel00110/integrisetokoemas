<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Index extends Component
{
    public string $nameId = '';

    public function mount(): void
    {
        $this->nameId = Auth::user()->id;
    }
    public function render()
    {
        /** @var Employee[]  */
        $employees = Employee::all();
        $employeeUser = Employee::where('user_id', $this->nameId)->first();

        return view('livewire.employees.index', compact('employees', 'employeeUser'));
    }
}
