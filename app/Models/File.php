<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'path',
        'name',
        'status_id',
        'user_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'status_id'
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
