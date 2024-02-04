<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function doctors()
    {
        return $this->belongsToMany(User::class, 'users_specialization','specialization_id','doctor_id');
    } 
    
}
