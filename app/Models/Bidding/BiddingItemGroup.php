<?php

namespace App\Models\Bidding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingItemGroup extends Model
{
    use HasFactory;

    protected $table = 'bidding_item_groups';

    protected $fillable = [
        'number_group',
        'group_name',
        'bidding_id',
    ];

    protected $foreingkey = 'bidding_id';

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }

    public function biddindItens()
    {
        return $this->hasMany(BiddingItem::class,'bidding_item_group_id','id' );
    }
}
