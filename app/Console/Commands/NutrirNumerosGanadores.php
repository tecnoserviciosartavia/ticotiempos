<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sorteos;
use App\Http\Controllers\SorteosController;
use Illuminate\Support\Facades\Log;

class NutrirNumerosGanadores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nutrir:numeros-ganadores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el campo numero_ganador de cada sorteo usando resultados.txt';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new SorteosController();
        $hoy = date('Y-m-d');
        $actualizados = 0;
        // Buscar todas las ventas cerradas del día actual que NO tengan numero_ganador y evitar fechas menores a hoy
        $ventas = \App\Models\Venta_cabecera::where('fecha', $hoy)
            ->where('estatus', 'cerrado')
            ->whereNull('numero_ganador')
            ->get();
        foreach ($ventas as $venta) {
            // Solo procesar si la fecha de la venta es igual a hoy
            if ($venta->fecha !== $hoy) {
                continue;
            }
            // Obtener la hora del sorteo relacionado
            $sorteo = \App\Models\Sorteos::find($venta->idsorteo);
            if ($sorteo) {
                // Leer resultados.txt y buscar el campo 'numero' correspondiente a la hora
                $file = base_path('resultados.txt');
                if (!file_exists($file)) continue;
                $json = file_get_contents($file);
                $data = json_decode($json, true);
                $hora_sorteo = substr($sorteo->hora, 0, 5);
                $numero_ganador = null;
                foreach (["manana", "mediaTarde", "tarde"] as $turno) {
                    if (!empty($data[$turno]) && isset($data[$turno]['fecha'])) {
                        $explode = explode('T', $data[$turno]['fecha']);
                        $hora_json = substr($explode[1], 0, 5);
                        if ($hora_json == $hora_sorteo && isset($data[$turno]['numero'])) {
                            $numero_ganador = $data[$turno]['numero'];
                            break;
                        }
                    }
                }
                if ($numero_ganador !== null) {
                    $venta->numero_ganador = $numero_ganador;
                    $venta->save();
                    $actualizados++;
                }
            }
        }
        $this->info("Ventas actualizadas: $actualizados");
        Log::info("Nutrición de números ganadores ejecutada. Ventas actualizadas: $actualizados");
        return 0;
    }
}
