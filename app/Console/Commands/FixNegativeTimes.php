<?php

namespace App\Console\Commands;

use App\Models\Result;
use Illuminate\Console\Command;

class FixNegativeTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:negative-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix negative completion times in results table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing negative completion times...');

        $results = Result::where('completion_time', '<', 0)->get();
        $this->info("Found {$results->count()} results with negative times.");

        foreach ($results as $result) {
            $result->completion_time = abs($result->completion_time);
            $result->save();
            $this->line("Fixed Result #{$result->id}: {$result->completion_time} seconds");
        }

        $this->info("Done!");

        return Command::SUCCESS;
    }
}
