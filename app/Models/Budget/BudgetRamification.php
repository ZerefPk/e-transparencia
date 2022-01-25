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
        'project_id',
        'status',

    ];
    protected $primaryKey = 'id';
    protected $foreignKey = 'project_id';

    /**
     * get types ramification
     * @return Array()
     */

    public static function types(){

        return [
            '1' => 'Projeto',
            '2' => 'SubProjeto',
            '3' => 'Ação',
            '4' => 'Modalidade',
        ];
    }
    /**
     * get types ramification
     * @return BudgetRamification()
     */
    public function subProject()
    {
        return $this->hasMany(BudgetRamification::class, 'project_id', 'id');
    }
    /**
     * get types ramification
     * @return BudgetRamification()
     */
    public function project()
    {
        return $this->belongsTo(BudgetRamification::class, 'project_id', 'id');
    }
    /**
     * get types ramification
     * @return string
     */
    public function getName()
    {
        return "{$this->cod} - {$this->description}";
    }
}
