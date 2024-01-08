<?php

namespace App\Repository\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use App\Models\file;
use App\Repository\FileRepositoryInterface;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{

    public function __construct(file $model)
    {
        parent::__construct($model);
    }


    public function getAllFiles()
    {
        return file::all();
    }
    public function deleteFile($model)
    {
        return $model->delete();
    }
}
