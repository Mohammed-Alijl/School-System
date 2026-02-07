<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImageTrait
{
    /**
     * upload new image when store or update
     * @param $file
     * @param $folder
     * @return string
     */
    public function uploadImage($file, $folder): string
    {
        $path = $file->store($folder, 'public');

        return $path;
    }

    /**
     * delete old image when update or delete
     */
    public function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
