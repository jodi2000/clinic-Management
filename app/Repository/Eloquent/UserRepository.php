<?php

namespace App\Repository\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Repository\UserRepositopyInterface;

class UserRepository extends BaseRepository implements UserRepositopyInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllUsers()
    {
        
    }
    public function deleteUser($model)
    {
        
    }
}
