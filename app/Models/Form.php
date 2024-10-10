<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Form extends Model
{
    protected $fillable = ['name', 'slug'];

    public function elements(): HasMany
    {
        return $this->hasMany(Element::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => ucwords($value),
        );
    }
}
