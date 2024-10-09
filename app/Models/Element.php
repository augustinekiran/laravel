<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Element extends Model
{
    protected $fillable = [
        'form_id',
        'type',
        'label',
        'required',
        'value',
        'sequence',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    protected function label(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => ucwords($value),
        );
    }
}
