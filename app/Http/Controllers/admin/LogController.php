<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{

     // Display Log List
     public function index(Request $request)
     {
         $logFiles = File::files(storage_path('logs')); // Fetch all log files
         $logs = [];

         foreach ($logFiles as $file) {
            $fileName = $file->getFilename();
            $fileDate = substr($fileName, 8, 10); // Extract the date from file name, starting after 'laravel-'

            $filePath = $file->getRealPath();

             $counts = $this->getLogCounts($filePath);

             $logs[] = [
                 'date' => $fileDate,
                 'file' => $fileName,
                 'counts' => $counts,
             ];
         }

         return view('admin.logs.index', compact('logs'));
     }

     // Helper to Count Log Levels
     private function getLogCounts($filePath)
     {
         $levels = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];
         $counts = array_fill_keys($levels, 0);

         $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

         foreach ($lines as $line) {
             foreach ($levels as $level) {
                 if (str_contains(strtolower($line), '.' . $level)) {
                     $counts[$level]++;
                 }
             }
         }

         return $counts;
     }

     // View Specific Log File
     public function view($file)
     {
         $filePath = storage_path("logs/{$file}");

         if (!File::exists($filePath)) {
             abort(404, "Log file not found");
         }

         // Fetch lines from the log file
         $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
         $logEntries = [];

         // Regular Expression to parse log details
         $pattern = '/^\[(?<datetime>.+?)\] (?<env>\w+)\.(?<level>\w+): (?<message>.*)$/';

         foreach ($lines as $line) {
             if (preg_match($pattern, $line, $matches)) {
                 $logEntries[] = [
                     'datetime' => $matches['datetime'],
                     'env' => $matches['env'],
                     'level' => $matches['level'],
                     'message' => $matches['message'],
                 ];
             }
         }

         return view('admin.logs.show', [
            'logEntries' => $logEntries,
            'file' => $file,
            'size' => File::size($filePath),
            'created_at' => date("Y-m-d H:i:s", filectime($filePath)), // Use native filectime()
            'updated_at' => date("Y-m-d H:i:s", File::lastModified($filePath)), // Use lastModified() for updated time
        ]);
     }

     // Download Log File
     public function download($file)
     {
         $filePath = storage_path("logs/{$file}");

         if (!File::exists($filePath)) {
             abort(404, "Log file not found");
         }

         return response()->download($filePath);
     }

     // Delete Log File
     public function delete($file)
     {
         $filePath = storage_path("logs/{$file}");

         if (File::exists($filePath)) {
             File::delete($filePath);
             return redirect()->back()->with('success', 'Log file deleted successfully');
         }

         return redirect()->back()->with('error', 'Log file not found');
     }


}
