<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     */
    protected $description = 'Clear the contents of the laravel.log file without deleting it';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            File::put($logPath, '');
            $this->info('Log file not found, so a new empty one was created.');
            return;
        }

        try {
            File::put($logPath, '');
            $this->info('laravel.log has been cleared successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to clear log file: ' . $e->getMessage());
        }
    }
}
