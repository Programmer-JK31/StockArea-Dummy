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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shelfHasBook(){
        return $this->hasMany(shelfHasBook::class);
    }

    // public function book(){
    //     return $this->hasManyThrough(
    //         Book::class,
    //         shelfHasBook::class,
    //         'shelf_id', // 'project_id', // Foreign key on the environments table...
    //            // 'environment_id', // Foreign key on the deployments table...
    //         // 'id', // Local key on the projects table...
    //         // 'id' // Local key on the environments table...
    //     )
    // }
}
