<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'account_id',
        'beneficiary', 
        'beneficiary_name',
        'transaction_type',
        'amount',
        'status_from_user',
        'status_from_transaction',
        'status',
    ];
    
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function accounts()
    {
        return $this->belongsTo(Account::class);
    }

}
