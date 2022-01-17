<?php

namespace App\Models\Publication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PublicationType extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'publications_types';
    protected $fillable = [
        'type',
        'slug',
        'status',
        'publication_template_id',
    ];

    protected $primaryKey = 'id';
    protected $foreignKey = 'publication_template_id';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('type')
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

    public function repostTemplate()
    {
        return $this->belongsTo(PublicationTemplate::class, 'publication_template_id', 'id');
    }

}
