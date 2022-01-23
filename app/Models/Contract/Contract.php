<?php

namespace App\Models\Contract;

use App\Models\Category;
use App\Models\Bidding\Bidding;
use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Contract extends Model
{
    use HasFactory, HasSlug;

    protected $table = "contracts";

    protected $fillable = [
        'slug',
        'number',
        'object',
        'process_number',
        'form_contract_id',
        'form_payment_id',
        'overall_contract_value',
        'signature_date',
        'start__validity',
        'end_term',
        'contract_tax',
        'contract_manager',
        'status',
        'subject_id',
        'situation_id',
        'year',
        'bidding_id',
        'provider_id',
    ];

    protected $primaryKey = "id";

    protected $foreignKey = ['form_of_contract_id', 'bidding_id','year' ,'provider_id', 'situation_id'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['year','number'])
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(254);
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
    /**
     * Get the route key for the model.
     *
     * @return string
    */
    public function getRealNumber()
    {
        return "{$this->year}/{$this->number}";
    }
    /**
     * Get the route key for the model.
     *
     * @return Provider
    */
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Bidding
    */
    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function formContract()
    {
        return $this->belongsTo(Category::class, 'form_contract_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function formPayment()
    {
        return $this->belongsTo(Category::class, 'form_payment_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function situation()
    {
        return $this->belongsTo(Category::class, 'situation_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function subject()
    {
        return $this->belongsTo(Category::class, 'subject_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return ContractDocument
    */
    public function documents()
    {
        return $this->hasMany(ContractDocument::class, 'contract_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return ContractItem
    */
    public function contractItens()
    {
        return $this->hasMany(ContractItem::class, 'contract_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return ContractAmendment
    */
    public function additives()
    {
        return $this->hasMany(ContractAmendment::class, 'contract_id', 'id');
    }
}
