<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'name' => 'Test Employee',
                'user_id' => 1,
                'position' => 'Staff',
                'department' => 'Sales',
                'hire_date' => now(),
                'status' => 'active'
            ]
        ]);
    }
}
