<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoBid extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'is_auto_bid'];

}
