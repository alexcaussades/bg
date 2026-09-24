<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class DatabaseBackupController extends Controller
{
    public function copy()
    {
        $source = database_path('database.sqlite');
        $backupDirectory = database_path('backup');

        if (! File::isDirectory($backupDirectory)) {
            File::makeDirectory($backupDirectory, 0750, true);
        }

        $date = now()->format('d-m-Y-H-i');
        $destination = $backupDirectory . DIRECTORY_SEPARATOR . 'database_' . $date . '.sqlite';

        if (! File::copy($source, $destination)) {
            return response()->json(['message' => 'Failed to copy database'], 500);
        }

        return response()->json(['message' => 'Database copied successfully']);
    }
}
