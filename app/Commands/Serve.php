<?php

namespace App\Commands;

use Illuminate\Console\Command;

class Serve extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Serve the application on the PHP development server";

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->checkPhpVersion();

        $this->info('Kirby development server started on http://localhost:8000');

        $command =  PHP_BINARY . ' -S localhost:8000 -t public kirby/router.php';

        passthru($command);
    }

    /**
     * Check the current PHP version is >= 7.4.
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function checkPhpVersion()
    {
        if (version_compare(PHP_VERSION, '7.4.0', '<')) {
            throw new \Exception('This PHP binary is not version 7.4 or greater.');
        }
    }
}
