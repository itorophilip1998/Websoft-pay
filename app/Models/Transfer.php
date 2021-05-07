<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'beneficiary',  
        'type',
        'amount', 
        'status',
        'tx_ref',
        'flw_ref',
        'transaction_id'
    ];
    
   
    public function user()
    {
        return $this->belongsTo(User::class);
    } 

}
