<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at', 'slug', 'pivot'];


}
