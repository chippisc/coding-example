<?php

namespace App\Console\Commands;

use App\Services\SynchronizeUsersService;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class FetchSchulcampusUsers extends Command
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
        try {
            $syncronizeUsersService->fromApi();
        } catch (ValidationException $e) {
            // Implement error handling here
            throw ($e);
        }
    }
}
