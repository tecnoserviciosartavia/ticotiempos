<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sorteos;
use App\Http\Controllers\SorteosController;

class ActualizarNumeroSorteoWebservice extends Command
{
    protected $signature = 'sorteos:actualizar-numero-webservice';
    protected $description = 'Actualiza el campo numero_sorteo_webservice de los sorteos que usan webservice';

    public function handle()
    {
        $controller = new SorteosController();
        $sorteos = Sorteos::where('usa_webservice', '>', 0)->get();
        foreach ($sorteos as $sorteo) {
            $numero = $controller->buscarNumeroWebservice($sorteo->url_webservice, $sorteo->hora);
            $this->info("Sorteo {$sorteo->id}: asignando número {$numero}");
            $sorteo->numero_sorteo_webservice = $numero ?? 0;
            $sorteo->save();
        }
        $this->info('Actualización completada.');
    }
}
