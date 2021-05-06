<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopUp extends Model
{
    use HasFactory;
        protected $fillable = [
        'user_id',
        'transaction_id',
        'tx_ref',
        'flw_ref',
        'currency',
        'amount',
        'status'
        ]; 
        public function user()
        {
            return $this->belongsTo(User::class);
        }

}
