<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];


    public function paymentable()
    {
        return $this->morphTo();
    }

    public function typePayment()
    {
        return $this->belongsTo(TypePay::class, 'type_pay_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
