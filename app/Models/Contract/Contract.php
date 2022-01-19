<?php

namespace App\Models\Contract;

use App\Http\Livewire\Dashboard\Publication\Category;
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
        'year',
        'bidding_id',
        'provider_id',
    ];

    protected $primaryKey = "id";

    protected $foreignKey = ['form_of_contract_id', 'bidding_id','year' ,'provider_id'];

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

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }
    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }
    public function formOfContract()
    {
        return $this->belongsTo(Category::class, 'form_of_contract_id', 'id');
    }
}
