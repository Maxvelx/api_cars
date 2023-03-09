<?php

namespace App\Console\Commands;

use App\Http\Controllers\DatabaseUpdate\Update\UpdateDatabases;
use Illuminate\Console\Command;

class UpdateDatabasesCommand extends Command
{
    protected $signature = 'update:vehicles';
    protected $description = 'Оновлення марок та моделей авто кожний місяць';

    public function handle()
    {
        $updater = new UpdateDatabases();
        $updater->update();
    }
}
