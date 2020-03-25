<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    /**
     * Relation ->films n:n
     */

     /**
     * Masque les colonnes de sortie jSon non désirées lors de l'appel à l'API
     */
    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at', 'slug', 'pivot'];


    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
}
