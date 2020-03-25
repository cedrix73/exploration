<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Relation ->films 1:n
     */



    protected $hidden = ['id'];

    protected $visible = ['name'];

    public function films()
    {
        return $this->hasMany(Film::class);
    }


}
