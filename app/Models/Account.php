<?php

namespace App\Models;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'user_id',
        'wallet_id',
        'account_type',
        'account_number',
        'account_name', 
        'account_balance',
        'account_status',
        'transaction_pin',
        'bank_name',
        'bank_code',
        'phone',
    ];
    
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
