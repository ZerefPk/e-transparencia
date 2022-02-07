<?php

namespace App\Models\NormativeAct;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TypeNormativeAct extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'types_normatives_acts';

    protected $fillable = [

        'slug',
        'type',
        'plural',
        'status',
        'journaling',
        'can_altered',
        'can_revoked',

    ];

    protected $primaryKey = 'id';



    /**
     * @return array
     */
    public function getCanAltered()
    {
        $ids = (isset($this->can_altered)) ? explode('|', $this->can_altered) : [];
        $canAltereds = [];
        foreach ($ids as $id){
            $temp = TypeNormativeAct::find($id);
            array_push($canAltereds, $temp);
        }
        return $canAltereds;

    }

    /**
     * @return array
     */
    public function getCanRevoked()
    {

        $ids = (isset($this->can_revoked)) ? explode('|', $this->can_revoked) : [];
        $can_revokeds = [];
        foreach ($ids as $id){
            $temp = TypeNormativeAct::find($id);
            array_push($can_revokeds, $temp);
        }
        return $can_revokeds;

    }
    /**
     * @return NormativeAct
     */
    public function noramtivesActs(){
        return $this->hasMany(NormativeAct::class, 'type_id', 'id');
    }
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('plural')
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
