<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SchedulesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setScheduleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'for Scheduling Commands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('setScheduleCommand', ['command' => 'app:get-conditions-command'])->everyMinute();
        return Command::SUCCESS;
    }
}
