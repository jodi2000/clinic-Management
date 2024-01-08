<?php

namespace App\Repository;

interface GroupRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllGroups();
    public function deleteGroup($model);

}
