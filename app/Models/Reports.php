<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Reports extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'message',
        'type',
    ];
    /**
     * Get the user that owns the Reports
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
