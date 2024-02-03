<?php

namespace App\Models;

use App\Observers\AppointmentObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'status_id',
        'scheduled_date'
    ];

    public static function boot()
    {
        Appointment::observe(AppointmentObserver::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    public function doctor()
    {
        return $this->belongsTo(User::class);
    } 
    public function status()
    {
        return $this->belongsTo(Status::class);
    } 
    public function statusScope(Builder $query, $name)
    {
        return $query->whereHas('status', function ($q) use ($name) {
            return $q->where('name','like',"%{$name}%");
        });
    }

    public function userScope(Builder $query, $name)
    {
        return $query->whereHas('user', function ($q) use ($name) {
            return $q->where('name','like',"%{$name}%");
        });
    }
    public function doctorScope(Builder $query, $name)
    {
        return $query->whereHas('doctor', function ($q) use ($name) {
            return $q->where('name','like',"%{$name}%");
        });
    }
    public function specializationScope(Builder $query, $name)
    {
        return $query->whereHas('doctor.specializations', function ($q) use ($name) {
            return $q->where('name','like',"%{$name}%");
        });
    }
}
