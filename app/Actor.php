<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    /**
     * Relation ->films n:n
     */
    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
}
