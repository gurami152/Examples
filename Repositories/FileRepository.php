<?php


namespace App\Repositories;

use Illuminate\Support\Facades\File;

class FileRepository
{
    public function imageSave($image, $directory)
    {
        $new_name = rand() . '.' . $image->extension();
        $image->move($directory, $new_name);
        return '/' . $directory . '/' . $new_name;
    }

    public function deleteFile($filename)
    {
        File::delete(public_path().$filename);
    }
}
