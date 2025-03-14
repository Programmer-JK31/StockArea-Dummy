<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function shelf(){
        return $this->hasMany(Shelf::class);
    }
}
