<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractItem extends Model
{
    use HasFactory;
    protected $table = 'contract_itens';

    protected $fillable = [
        'item',
        'description',
        'unity',
        'quantity',
        'unity_value',
        'total_value',
        'contract_id',
    ];

    protected $foreingkey = 'contract_id';


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
