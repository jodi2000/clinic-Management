<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\EloquentRepositoryInterface;

class UserRepository extends BaseRepository implements EloquentRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllUsers()
    {
        return User::all();
    }
}
