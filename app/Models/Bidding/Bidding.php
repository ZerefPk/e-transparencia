<?php

namespace App\Models\Bidding;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Bidding extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'biddings';

    protected $fillable = [

        'slug',
        'number',
        'object',
        'event_date',
        'event_time',
        'localization',
        'estimated_value',
        'contracted_value',
        'budget_information',
        'status',
        'year',
        'modality_id',
        'type_id',
        'situation_id',
        'finality_id',
    ];

    protected $foreingkey = ['year', 'modality_id',	 'type_id',	'situation_id',	'finality_id'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['year', 'number'])
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs(false)
            ->usingSeparator('-');

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
     * @return Category
    */
    public function modality()
    {

        return $this->belongsTo(Category::class, 'modality_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function type()
    {
        return $this->belongsTo(Category::class,  'type_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function situation()
    {
        return $this->belongsTo(Category::class,  'situation_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return Category
    */
    public function finality()
    {
        return $this->belongsTo(Category::class, 'finality_id', 'id');
    }
    /**
     * Get the route key for the model.
     *
     * @return BiddingDocument
    */
    public function documents()
    {
        return $this->hasMany(BiddingDocument::class, 'bidding_id', 'id');
    }
    public function biddingItens()
    {
        return $this
        ->hasMany(BiddingItem::class, 'bidding_id', 'id')->where('bidding_item_group_id', null);
    }
    public function additional()
    {
        return $this->hasOne(BiddingAdditional::class, 'bidding_id', 'id');
    }
}
