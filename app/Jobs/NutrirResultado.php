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
        //valido que este usando webservice
        if (!is_null($juego->sorteos->url_webservice)) {

            // Valido el numero del sorteo
            if ($juego->sorteos->numero_sorteo_webservice > 0) {

                $nuevo_valor = intval($juego->sorteos->numero_sorteo_webservice) + 3;
                $conectar = $this->conectarWebservice($juego->sorteos->url_webservice.''.$nuevo_valor);
                $data = json_decode($conectar,true);
                switch ($juego->sorteos->hora) {
                    case '12:55:00':
                        $numero  = $data['manana']['numero'];
                        $bolita  = $data['manana']['colorBolita'];
                    break;
                    case '16:30:00':
                        $numero  = $data['mediaTarde']['numero'];
                        $bolita  = $data['mediaTarde']['colorBolita'];
                    break;
                    case '19:30:00':
                        $numero  = $data['tarde']['numero'];
                        $bolita  = $data['tarde']['colorBolita'];
                    break;
                }
                $letra = substr($bolita, 0,1);
                $consulta = Resultados_parametros::where('descripcion', '=', $letra)->first();
                //Actualizo la informacion
                Venta_cabecera::where('id', $this->juego_id)
                ->update([
                    'numero_ganador' => $numero,
                    'adicional_ganador' => $consulta->id,
                    ]);
                CalculateWinners::dispatch($this->juego_id)->delay(now()->addMinutes(1));
                Sorteos::where('id', $juego->sorteos->id)
                ->update([
                    'numero_sorteo_webservice' => $nuevo_valor
                ]);
            } else {

                Log::error('El numero de Sorteo debe ser mayor a 0');
            }
        } else {

            Log::error('No posee URL el sorteo para Webservices o se encuentra en NULL');
        }
    }

    public function conectarWebservice($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
