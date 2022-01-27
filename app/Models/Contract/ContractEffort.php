<?php

namespace App\Models\Contract;

use App\Models\Outlay\Effort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ContractEffort extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'contracts_efforts';

    protected $fillable = [
        'number_effort',
        'slug_file',
        'extension',
        'path',
        'effort_id',
        'contract_id',

    ];

    protected $foreingkey = 'contract_id';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['number_effort'])
            ->saveSlugsTo('slug_file')
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
        return 'slug_file';
    }
    /**
     * Get the contract.
     *
     * @return Contract
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    /**
     * Get the contract.
     *
     * @return Effort
     */
    public function effort()
    {
        return $this->belongsTo(Effort::class, 'effort_id', 'id');
    }
    public function getRealPath()
    {
        return Storage::url('contract/'.$this->path.$this->slug.$this->extension);
    }

}
