<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Provider extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'providers';

    protected $fillable = [
        'slug',
        'corporate_name',
        'fantasy_name',
        'legal_nature',
        'mei_company',
        'headquarters',
        'status',
        'type',
        'cpf',
        'cnpj'
    ];

    protected $primaryKey = 'id';
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['corporate_name','cnpj','cpf'])
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

}
