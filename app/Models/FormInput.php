<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormInput extends Model
{
    protected $fillable = [
        'form_submission_id',
        'element_id',
        'value'
    ];
}
