<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Option extends Model
{
    protected $fillable = [
        'element_id',
        'label',
        'value',
        'sequence'
    ];

    protected function label(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => ucwords($value),
        );
    }
}
