<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\GanisPKBQuizSeeder;

class SeedGanisPKB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:ganis-pkb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with Ganis PKB Quiz and Questions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding Ganis PKB Quiz...');

        $this->call('db:seed', [
            '--class' => GanisPKBQuizSeeder::class,
        ]);

        $this->info('Ganis PKB Quiz seeded successfully!');
    }
}
