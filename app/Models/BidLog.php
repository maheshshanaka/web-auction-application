<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidLog extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'item_id', 'user_id', 'is_auto_bid'];
    protected $dates = ['created_at' ];


    /**
     * Get the post that owns the comment.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }


    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
