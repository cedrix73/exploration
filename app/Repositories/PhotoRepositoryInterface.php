<?php

namespace App\Repositories;

use Illuminate\Http\UploadedFile;

interface PhotoRepositoryInterface
{
public function save(UploadedFile $image);
}
