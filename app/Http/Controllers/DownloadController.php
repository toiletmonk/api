<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($fileId)
    {
        $file = File::findOrFail($fileId);

        return Storage::download($file->filepath, $file->filename);
    }
}
