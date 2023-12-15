<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Type;

class Sale extends Model
{
    use HasFactory;

    const GENERATE = '1';
    const CANCEL = '0';
    const PAID = '2';

    const TYPE = 'I';

    protected $fillable = [
        'user_id',
        'client_id',
        'serie',
        'correlative',
        'total',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
