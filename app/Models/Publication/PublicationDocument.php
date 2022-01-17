<?php

namespace App\Models\Publication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PublicationDocument extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'publications_documents';
    protected $fillable = [
        'type',
        'slug',
        'publication_date',
        'extension',
        'path',
        'description',
        'publication_template_id',
        'publication_type_id',
        'year'

    ];

    protected $primaryKey = 'id';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['year','publication_date'])
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(170);
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

    public function type()
    {
       return $this->belongsTo(PublicationType::class, 'publication_type_id','id');
    }
    public function getRealPath()
    {
        return Storage::url('publication/'.$this->path.$this->slug.$this->extension);
    }
}
