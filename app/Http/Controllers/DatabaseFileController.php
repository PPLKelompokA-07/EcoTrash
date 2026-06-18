<?php

namespace App\Http\Controllers;

use App\Models\DatabaseFile;
use Illuminate\Http\Request;

class DatabaseFileController extends Controller
{
    public function show($filename)
    {
        $file = DatabaseFile::where('filename', $filename)->firstOrFail();
        
        return response($file->data)
            ->header('Content-Type', $file->mime_type)
            ->header('Cache-Control', 'public, max-age=86400'); // Cache for 1 day
    }
}
