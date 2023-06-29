<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ExpensesExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Expense::query();
    }
}
