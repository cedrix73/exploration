<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Relation ->films 1:n
     */
    public function films()
    {
        return $this->hasMany(Film::class);
    }


}
