<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait HandlesFileUploads
{
    protected function uploadFile(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        return $path;
    }

    protected function deleteFile(?string $path): bool
    {
        if (!$path) {
            return false;
        }
        return Storage::disk('public')->delete($path);
    }

    protected function replaceFile(UploadedFile $newFile, ?string $oldPath, string $directory): string
    {
        $this->deleteFile($oldPath);
        return $this->uploadFile($newFile, $directory);
    }
}
