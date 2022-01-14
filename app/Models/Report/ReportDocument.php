<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ReportDocument extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'report_documents';
    protected $fillable = [
        'type',
        'slug',
        'publication_date',
        'extension',
        'path',
        'description',
        'report_template_id',
        'report_type_id',
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
       return $this->belongsTo(ReportType::class, 'report_type_id','id');
    }

}
