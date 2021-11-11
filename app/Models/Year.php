<?php

namespace App\Models;

use App\Models\Bidding\Bidding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $table = 'years';

    protected $fillable = [

        'year',
        'primary',
        'status',

    ];

    protected $primaryKey = 'year';

    public function biddings()
    {
        return $this->hasMany(Bidding::class, 'year', 'year');
    }

}
