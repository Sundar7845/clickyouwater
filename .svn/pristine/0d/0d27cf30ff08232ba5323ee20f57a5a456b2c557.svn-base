<?php 
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ForeignKeyExists implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $count = DB::table($this->table)
            ->where($this->column, $value)
            ->count();
        return $count > 0;
    }

    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}

?>