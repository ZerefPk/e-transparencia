<?php

namespace App\Models\Bidding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingItem extends Model
{
    use HasFactory;

    protected $table = 'bidding_itens';

    protected $fillable = [
        'item',
        'description',
        'catmat',
        'unity',
        'quantity',
        'estimated_total_value',
        'bidding_item_group_id',
        'bidding_id',
    ];

    protected $foreingkey = ['bidding_id', 'bidding_item_group_id'];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }

}
