<?php

namespace App\Models\Outlay;

use App\Models\Budget\BudgetAccount;
use App\Models\Budget\BudgetRamification;
use App\Models\Contract\Contract;
use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Effort extends Model
{
    use HasFactory, HasSlug;
    protected $table = 'efforts';

    protected $fillable = [
        'year',
        'number',
        'date_effort',
        'type',
        'reservation_number',
        'description',
        'number_installments',
        'unitary_value',
        'total_value',
        'adjusted_value',
        'current_value',
        'executed_installments',
        'total_executed',
        'total_to_executed',
        'finished',
        'status',
        'complement',
        'process_number',
        'provider_id',
        'contract_id',
        'project_id',
        'subproject_id',
        'action_id',
        'budget_account_id',
        'modality_id',
    ];
    protected $primaryKey= 'id';

    protected $foreignKey = [
        'year',
        'provider_id',
        'contract_id',
        'project_id',
        'subproject_id',
        'action_id',
        'budget_account_id',
        'modality_id',
    ];
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['year', 'number'])
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(70);
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function types()
    {
        return [
            '1'=> 'Ordinário',
            '2'=> 'Estimado',
            '3'=> 'Global',
        ];
    }
    /**
     * Get the Provider.
     *
     * @return Provider
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }
    /**
     * Get the contract.
     *
     * @return Contract
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    /**
     * Get the project.
     *
     * @return BudgetRamification
     */
    public function project()
    {
        return $this->belongsTo(BudgetRamification::class, 'project_id', 'id');
    }
    /**
     * Get the subproject.
     *
     * @return BudgetRamification
     */
    public function subproject()
    {
        return $this->belongsTo(BudgetRamification::class, 'subproject_id', 'id');
    }
    /**
     * Get the action.
     *
     * @return BudgetRamification
     */
    public function action()
    {
        return $this->belongsTo(BudgetRamification::class, 'action_id', 'id');
    }
    /**
     * Get the account.
     *
     * @return BudgetAccount
     */
    public function account()
    {
        return $this->belongsTo(BudgetAccount::class, 'budget_account_id', 'id');
    }
    /**
     * Get the account.
     *
     * @return BudgetAccount
     */
    public function modality()
    {
        return $this->belongsTo(BudgetAccount::class, 'modality_id', 'id');
    }

    /**
     * Get the account.
     *
     * @return string
     */

     public function getRealNumber()
     {
        return "{$this->number}/{$this->year}";
     }
}
