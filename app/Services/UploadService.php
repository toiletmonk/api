<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function uploadFile(UploadedFile $file): File
    {
        $path = $file->store('uploads', 'public');

        return File::create([
            'filename'=>$file->getClientOriginalName(),
            'filetype'=>$file->getClientMimeType(),
            'filepath'=>$path
        ]);

    }

    public function deleteFile(File $file): bool
    {
        if(Storage::disk('public')->exists($file->filepath)) {
            Storage::disk('public')->delete($file->filepath);
        }

        return $file->delete();
    }
}
