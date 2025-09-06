<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Resultados_parametros;
use App\Models\Venta_cabecera;
use Illuminate\Support\Facades\Log;
use App\Jobs\CalculateWinners;
use App\Models\Sorteos;

class NutrirResultado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $juego_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($idjuego)
    {
        $this->juego_id = $idjuego;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Juego en curso
        $juego = Venta_cabecera::find($this->juego_id);
        $rutaArchivo = base_path('resultados.txt');
        if (file_exists($rutaArchivo)) {
            $contenido = file_get_contents($rutaArchivo);
            $json = json_decode($contenido, true);
            $numero = null;
            $bolita = null;
            $hora = substr($juego->sorteos->hora, 0, 5); // Solo HH:MM
            // Buscar el resultado según la hora
            if ($json) {
                if ($hora == '12:55' && isset($json['manana'])) {
                    $numero = $json['manana']['numero'] ?? null;
                    $bolita = $json['manana']['colorBolita'] ?? null;
                } elseif ($hora == '16:30' && isset($json['mediaTarde'])) {
                    $numero = $json['mediaTarde']['numero'] ?? null;
                    $bolita = $json['mediaTarde']['colorBolita'] ?? null;
                } elseif ($hora == '19:30' && isset($json['tarde'])) {
                    $numero = $json['tarde']['numero'] ?? null;
                    $bolita = $json['tarde']['colorBolita'] ?? null;
                }
            }
            if ($numero !== null && $bolita !== null) {
                $letra = substr($bolita, 0,1);
                $consulta = Resultados_parametros::where('descripcion', '=', $letra)->first();
                //Actualizo la informacion
                Venta_cabecera::where('id', $this->juego_id)
                ->update([
                    'numero_ganador' => $numero,
                    'adicional_ganador' => $consulta ? $consulta->id : null,
                ]);
                CalculateWinners::dispatch($this->juego_id)->delay(now()->addMinutes(1));
            } else {
                Log::error('No se encontró resultado para la hora (HH:MM): ' . $hora);
            }
        } else {
            Log::error('No se encontró el archivo resultados.txt');
        }
    }
}
