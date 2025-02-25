<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    public $timestamps = false;
    protected $table = 'shelf';
    protected $fillable = [
        'name',
        'user_id'
    ];
}
