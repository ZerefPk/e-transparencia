<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetRamification extends Model
{
    use HasFactory;
    protected $table = 'budget_ramifications';

    protected $fillable = [
        'cod',
        'description',
        'type',
        'status',

    ];

    /**
     * get types ramification
     * @return Array()
     */

    public static function types(){

        return [
            '1' => 'Projeto',
            '2' => 'Ação',
            '3' => 'SubProjeto',
        ];
    }
}
