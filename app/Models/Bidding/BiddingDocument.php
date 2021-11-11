<?php

namespace App\Models\Bidding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BiddingDocument extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'bidding_documents';

    protected $fillable = [
        'name',
        'slug',
        'extension',
        'description',	
        'path',
        'bidding_id',	
        
    ];

    protected $foreingkey = 'biddind_id';
    
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'description', 'path'])
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
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
    
    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'id', 'bidding_id');
    }
    public function getRealPath()
    {
        return Storage::url('bidding/'.$this->path.$this->slug.$this->extension);
    }
}
