<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    const TYPE = 'E';


    const PENDING = '1';
    const COMPLETED = '0';
    protected $fillable = [
        'date',
        'code',
        'total',
        'status',
        'user_id',
        'provider_id',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ShoppingDetail::class);
    }

    public function code(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
        );
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }
}
