<?php

namespace App\Commands;

use App\Core\Roots;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Capsule\Manager as Capsule;
use SQLite3;

class Table extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Make table";

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $tableArray = require Roots::DATABASE . '/tables.php';

        $tableName = $this->choice(
            'Choose a table name to create',
            array_keys($tableArray),
        );

        if (empty ($tableArray[$tableName])){
            $this->error('Table not found');
            exit();
        }
        if(Capsule::schema()->hasTable($tableName)){
            $this->error('Table exists');
            exit();
        }

        Capsule::schema()->create($tableName , $tableArray[$tableName]);

        $this->info("Table $tableName created successfully");

    }

}