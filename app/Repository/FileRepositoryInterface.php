<?php

namespace App\Repository;

interface FileRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllFiles();
    public function deleteFile($model);
}
