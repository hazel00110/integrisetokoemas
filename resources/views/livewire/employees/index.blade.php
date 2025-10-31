<div>
    <div>
        <input type="text" placeholder="Search employees by name, position, or department"
            class="input input-bordered w-64 border rounded px-3 py-2 mb-4" wire:model="search" />
    </div>
    @foreach ($employees as $employee)
        <div>
            <h2 class="text-lg font-semibold mt-6">All Employees</h2>
            <h2>{{ $employee->name }}</h2>
            <p>Position: {{ $employee->position }}</p>
            <p>Department: {{ $employee->department }}</p>
            <p>Hire Date: {{ $employee->hire_date }}</p>
            <p>Status: {{ $employee->status }}</p>
        </div>
    @endforeach
    <div>
        <h1 class="text-lg font-semibold mt-6">
            Me
        </h1>
        @if (empty($employeeUser))
            <p>No user associated with this employee.</p>
        @else
            <p>Name: {{ $employeeUser->name }}</p>
            <p>Department: {{ $employeeUser->department }}</p>
            <p>Position: {{ $employeeUser->position }}</p>
            <p>Hire Date: {{ $employeeUser->hire_date }}</p>
            <p>Status: {{ $employeeUser->status }}</p>
        @endif
    </div>
</div>
