<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ReportTemplate extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'report_templates';
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

    public function repostType()
    {
       return $this->hasMany(ReportType::class, 'report_template_id', 'id');
    }
}
