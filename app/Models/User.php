<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Models\Role;

class User  extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'users_specialization','doctor_id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    } 

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isDoctor()
    {
        return $this->role->name === 'doctor';
    }
}
