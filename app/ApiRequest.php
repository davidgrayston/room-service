<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    protected $fillable = ['endpoint', 'input', 'output'];
}
