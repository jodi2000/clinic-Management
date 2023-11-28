<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_permissions');
    }
}
