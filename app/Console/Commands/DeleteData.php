<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ComandosController;

class DeleteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:matchs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for delete data 6 months ago';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new ComandosController;
        $controller->startDelete();
    }
}
