<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VentaController;

class CloseMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:gamens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to close all games on time';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new VentaController;
        $controller->cerrar();
    }
}
