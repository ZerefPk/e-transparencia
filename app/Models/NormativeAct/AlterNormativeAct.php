<?php

namespace App\Models\NormativeAct;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlterNormativeAct extends Model
{
    use HasFactory;
    protected $table = 'alters_normatives_acts';

    protected $fillable = [
        'parent_id',
        'normative_act_id',
        'type'
    ];

    public function normativesActs(){
        return $this->hasOne(NormativeAct::class, 'id','normative_act_id');
    }
}
