<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users')
            ->withPivot('role');
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'group_permissions');
    }
}
