<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Streets extends Model
{
    protected $table = 'cities_streets';
    protected $fillable = ['*'];
}
