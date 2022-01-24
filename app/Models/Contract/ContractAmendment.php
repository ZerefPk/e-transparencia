<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractAmendment extends Model
{
    use HasFactory;
    protected $table = 'contractual_amendments';

    protected $fillable = [
        'sequence',
        'description',
        'type_modification',
        'decrease_value',
        'addition_value',
        'termination_value',
        'total_value',
        'signature_date',
        'contract_id',
        'start_validity',
        'end_term',
    ];

    protected $foreingkey = 'contract_id';


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
