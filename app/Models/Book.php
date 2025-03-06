<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;
    protected $table = 'books';
    protected $fillable = [
        'name'
    ];

    public function shelfHasBook(){
        return $this->hasMany(shelfHasBook::class);
    }
}
