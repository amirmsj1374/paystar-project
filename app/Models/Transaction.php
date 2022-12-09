<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // 'user_id',
        'order_id',
        'ref_num',
        'gateway',
        'status',
        'card_number',
        'tracking_code',
        'transaction_id'
    ];
}
