<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetAccount extends Model
{
    use HasFactory;

    protected $table = 'budget_accounts';

    protected $fillable = [
        'reduced_account',
        'ledger_account',
        'description',
        'status',

    ];

    protected $primaryKey = 'id';
   /**
     * get types ramification
     * @return string
     */
    public function getName()
    {
        return "{$this->ledger_account} - {$this->description}";
    }
}
