<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    function permissions() {
        return $this->belongsToMany('App\Permission', 'permission_role');
    }
}
