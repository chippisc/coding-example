<?php

namespace App\Console\Commands;

use App\Services\SynchronizeUsersService;
use Illuminate\Console\Command;

class FetchUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $syncronizeUsersService = new SynchronizeUsersService();
        $syncronizeUsersService->fromApi();
    }
}
