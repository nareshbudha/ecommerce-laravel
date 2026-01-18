<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{

    public static function upload(UploadedFile $file, string $folder, string $customFilename = null): string
    {
        $filename = $customFilename ?? $file->getClientOriginalName();
        $path = $file->storeAs($folder, $filename, 'public');
        return $path;
    }


    public static function url(string $path): string
    {
        return asset('storage/' . ltrim($path, '/'));
    }


    public static function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

 
    public static function deleteImage(string $path): void
    {
        self::delete($path);
    }
}
