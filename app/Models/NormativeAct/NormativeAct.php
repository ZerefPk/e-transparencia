<?php

namespace App\Models\NormativeAct;

use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class NormativeAct extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'normatives_acts';

    protected $fillable = [

        'year',
        'type_id',
        'number',
        'description',
        'ementa',
        'publication_date',
        'status',
        'active',
        'altered',
        'revoked',
        'slug',
        'path_doc',
        'extencion_doc',
        'path_pdf',
        'extencion_pdf',

    ];

    protected $primaryKey = 'id';
    protected $foreingKey = ['year', 'type_id'];
    /**
     *
     *
     * @return Year
     */
    public function year(){
        return $this->belongsTo(Year::class, 'year', 'year');
    }
    /**
     *
     *
     * @return TypeNormativeAct
     */
    public function type(){
        return $this->belongsTo(TypeNormativeAct::class, 'type_id', 'id');
    }
    /**
    *
    *
    * @return string
    */
    public function  getRealNumber()
    {
        return "{$this->number}/{$this->year}";
    }
    /**
     * Get the options for generating the slug.
     */

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['number', 'year'])
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
     /**.
     *
     * @return string
     */
    public function getPathDoc()
    {
        return Storage::url('normativeact/'.$this->path_doc.$this->extencion_doc);
    }
     /**
     *
     * @return string
     */
    public function getPathPdf()
    {
        return Storage::url('normativeact/'.$this->path_pdf.$this->extencion_pdf);
    }
}
