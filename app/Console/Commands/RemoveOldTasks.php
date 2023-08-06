<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class RemoveOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete old soft-deleted tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oneMonthAgo = now()->subMonth();
        Task::onlyTrashed()->where('deleted_at', '<=', $oneMonthAgo)->forceDelete();
        $this->info('Old soft-deleted tasks have been permanently deleted.');
    }
}
