<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    const TYPE = 'E';

    protected $fillable = [
        'date',
        'code',
        'total',
        'type_pay_id',
        'status',
        'user_id',
        'provider_id',
    ];
}
