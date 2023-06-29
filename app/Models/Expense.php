<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_date',
        'expensegroup_id',
        'expense_type_id',
        'ledger_id',
        'company_ledger_id',
        'employee_user_id',
        'amount',
        'is_paid',
        'amount_paid',
        'expense_proof_path',
        'notes',
        'is_cancelled',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
