<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'bpo_reference_no',
        'bpo_token_no',
        'bpo_payment_status',
        'bpo_payment_response',
        'is_active'
    ];
}
