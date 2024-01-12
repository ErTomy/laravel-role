<?php

namespace Ertomy\Roles\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
