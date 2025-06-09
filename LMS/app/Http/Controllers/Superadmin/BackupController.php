<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\BackupDestination\BackupDestination;
use Illuminate\Support\Facades\{
    Artisan,
    File,
    Storage,
    };

use Spatie\Backup\Tasks\Monitor\BackupDestinationStatus;
class BackupController extends Controller
{
    

    public function index()
{
    $backupFiles = [];
    $backupPath = storage_path('app/private/LMS'); // Updated path

    if (File::exists($backupPath)) {
        $backupFiles = collect(File::files($backupPath))
            ->filter(function ($file) {
                return in_array(pathinfo($file, PATHINFO_EXTENSION), ['zip', 'sql']);
            })
            ->map(function ($file) {
                return [
                    'filename' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $this->formatBytes($file->getSize()),
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            })
            ->sortByDesc('date')
            ->values()
            ->toArray();
    }

    return view('superadmin.backups.index', compact('backupFiles'));
}
public function create()
{
    try {
        Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true
        ]);

        // Verify file creation
        $backupPath = storage_path('app/backups');
        $backups = collect(File::files($backupPath))
            ->filter(function ($file) {
                return in_array(pathinfo($file, PATHINFO_EXTENSION), ['zip', 'sql']);
            });

        if ($backups->count() > 0) {
            $latest = $backups->last();
            return back()->with('success', "Backup created: {$latest->getFilename()}");
        }

        return back()->with('error', 'Backup command ran but no file was created in app/backups');

    } catch (\Exception $e) {
        return back()->with('error', 'Backup failed: '.$e->getMessage());
    }
}
public function download($filename)
{
    // Validate filename format
    if (!preg_match('/^[\w\-\.]+\.zip$/', $filename)) {
        abort(400, 'Invalid filename');
    }

    $backupPath = storage_path('app/private/LMS/'.$filename);
    
    if (!file_exists($backupPath)) {
        // Log missing files for debugging
        \Log::error("Backup file not found: {$filename}", [
            'search_path' => $backupPath,
            'existing_files' => File::files(storage_path('app/private/LMS'))
        ]);
        abort(404, "Backup file {$filename} not found");
    }

    return response()->download($backupPath);
}
    public function destroy($filename)
{
    $filePath = storage_path('app/'.config('backup.backup.name').'/'.$filename);
    
    if (File::exists($filePath)) {
        File::delete($filePath);
        return back()->with('success', 'Backup deleted successfully');
    }

    return back()->with('error', 'Backup file not found');
}

public function restore(Request $request)
{
    $request->validate(['filename' => 'required|string']);
    
    $filePath = storage_path('app/'.config('backup.backup.name').'/'.$request->filename);
    
    if (!File::exists($filePath)) {
        return back()->with('error', 'Backup file not found');
    }

    try {
        Artisan::call('backup:restore', [
            '--backup' => $request->filename,
            '--force' => true
        ]);
        
        return back()->with('success', 'Restore process initiated successfully');
    } catch (\Exception $e) {
        return back()->with('error', 'Restore failed: '.$e->getMessage());
    }
}

// Add to your BackupController
private function formatBytes($bytes, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    // Convert to number if string
    if (is_string($bytes)) {
        $bytes = (float)$bytes;
    }
    
    $bytes = max($bytes, 0);
    $pow = $bytes > 0 ? floor(log($bytes) / log(1024)) : 0;
    $pow = min($pow, count($units) - 1);
    
    return round($bytes / (1024 ** $pow), $precision) . ' ' . $units[$pow];
}

}