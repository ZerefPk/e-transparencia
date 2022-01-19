<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ContractDocument extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'contract_documents';

    protected $fillable = [
        'name',
        'slug',
        'extension',
        'description',
        'path',
        'contract_id',

    ];

    protected $foreingkey = 'contract_id';

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

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    public function getRealPath()
    {
        return Storage::url('contract/'.$this->path.$this->slug.$this->extension);
    }
}
