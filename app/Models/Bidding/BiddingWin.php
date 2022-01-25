<?php

namespace App\Models\Bidding;

use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingWin extends Model
{
    use HasFactory;
    protected $table = 'biddings_winrs';

    protected $fillable = [
        'bidding_item_id',
        'provider_id',
        'approved_value',
    ];
    protected $primaryKey = 'id';
    protected $foreingkey = ['bidding_item_id', 'provider_id'];


    public function itemBidding()
    {
        return $this->belongsTo(BiddingItem::class, 'bidding_item_id', 'id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }
}
