<?php

namespace App\Models\Bidding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingAdditional extends Model
{
    use HasFactory;

    protected $table = 'biddings_additional';

    protected $fillable = [
        'notice_number',
        'bid_opening_date',
        'bid_opening_hour',
        'bid_closing_date',
        'bid_closing_hour',	
        'description',	
        'bidding_id',
    ];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }
}
