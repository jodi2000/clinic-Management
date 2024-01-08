<?php

namespace App\Repository;

interface UserRepositopyInterface extends EloquentRepositoryInterface
{
    public function getAllUsers();
    public function deleteUser($model);

}
