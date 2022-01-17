<?php

namespace App\Models\Publication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PublicationTemplate extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'publications_templates';
    protected $fillable = [
        'title',
        'slug',
        'status',
        'description'
    ];

    protected $primaryKey = 'id';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
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

    public function publicationType()
    {
       return $this->hasMany(PublicationType::class, 'publication_template_id', 'id');
    }
    public function documents()
    {
        return $this->hasMany(PublicationDocument::class, 'publication_template_id', 'id');
    }
}
