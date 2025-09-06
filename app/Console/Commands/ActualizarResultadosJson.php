<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class ActualizarResultadosJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resultados:actualizar-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el script Node.js para actualizar resultados.txt desde el JSON externo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $process = new Process(['node', base_path('actualizar_resultados.js')]);
        $process->setTimeout(60);
        $process->run();

        if ($process->isSuccessful()) {
            $this->info('Script actualizar_resultados.js ejecutado correctamente.');
            Log::info('Script actualizar_resultados.js ejecutado correctamente.');
        } else {
            $this->error('Error al ejecutar el script Node.js: ' . $process->getErrorOutput());
            Log::error('Error al ejecutar el script Node.js: ' . $process->getErrorOutput());
        }
        return 0;
    }
}
