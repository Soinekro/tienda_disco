<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Type;

class Sale extends Model
{
    use HasFactory;

    const TYPE = 'I';
    protected $fillable = [
        'user_id',
        'client_id',
        'code',
        'total',
        'status',
        'type_pay_id',
    ];
}
