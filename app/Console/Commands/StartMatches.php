<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VentaController;

class StartMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:gamens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to execute the start of the draws every morning';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new VentaController;
        $controller->abrir();
    }
}
