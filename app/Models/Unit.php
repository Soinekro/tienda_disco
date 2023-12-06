<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // 'code' is the column name in the database table
        'name',
        'quantity',
        'status',
    ];

    public $incrementing = false; // 'code' is not an auto-incrementing column
    protected $keyType = 'string'; // 'code' is a string (not an integer)

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
