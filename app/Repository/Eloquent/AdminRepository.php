<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\EloquentRepositoryInterface;

class AdminRepository extends BaseRepository implements EloquentRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
