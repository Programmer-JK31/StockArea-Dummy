<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shelfHasBook extends Model
{
    public $timestamps = false;
    protected $table = 'shelf_has_books';
    protected $fillable = [
        'shelf_id',
        'book_id'
    ];

    public function shelf(){
        return $this->hasOne(Shelf::class);
    }

    public function book(){
        return $this->hasOne(Book::class, 'id', 'book_id');
    }
}
