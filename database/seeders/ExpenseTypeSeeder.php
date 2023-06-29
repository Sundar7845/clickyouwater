<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['expense_type' => 'General Expense'],
            ['expense_type' => 'Employee Expense']
        ];
        
        ExpenseType::insert($data);
    }
}
