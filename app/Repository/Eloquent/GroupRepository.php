<?php

namespace App\Repository\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use App\Models\file;
use App\Models\group;
use App\Repository\GroupRepositoryInterface;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{

    public function __construct(group $model)
    {
        parent::__construct($model);
    }

    public function getAllGroups()
    {
        return group::all();
    }
    public function deleteGroup($model)
    {
        return $model->delete();
    }
}
