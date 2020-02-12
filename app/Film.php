<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'year', 'description', 'category_id'];

    /**
     * Relation ->films n:1
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation ->actors n:n
     */
     public function actors()
     {

        return $this->belongsToMany(Actor::class);
     }
}
