<?php

namespace Ertomy\Roles\Traits;

use Ertomy\Roles\Models\Role;

trait HasRole
{
    public function role()
    {
        return $this->belongsTo('Ertomy\Roles\Models\Role');
    }


    public function hasRole($roleNames)
    {
        if(!is_array($roleNames)){
            $roleNames = [$roleNames];
        }
        return in_array($this->role->name, $roleNames);
    }


}
