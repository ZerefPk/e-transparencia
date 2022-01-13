<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ReportType extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'report_types';
    protected $fillable = [
        'type',
        'slug',
        'description',
        'status',
        'report_template_id',
    ];

    protected $primaryKey = 'id';
    protected $foreignKey = 'report_template_id';

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

    public function repostTemplate()
    {
        return $this->belongsTo(ReportTemplate::class, 'report_template_id', 'id');
    }
    
}
