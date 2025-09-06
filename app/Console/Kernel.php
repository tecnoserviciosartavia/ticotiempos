<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\StartMatches::class,
        Commands\CloseMatches::class,
        Commands\NutrirNumerosGanadores::class, // Registro del comando personalizado
        Commands\ActualizarResultadosJson::class, // Nuevo comando para actualizar el JSON
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    $schedule->command('start:gamens')->everyFiveMinutes();
    $schedule->command('close:gamens')->everyTenMinutes();
    $schedule->command('optimize:clear')->hourly();
    $schedule->command('start:balance')->dailyAt('06:00');
    // Ejecuta el comando 10 minutos después del sorteo para asegurar que el resultado esté disponible
    // Ejecuta el comando tres veces al día después de los sorteos
    $schedule->command('nutrir:numeros-ganadores')->dailyAt('13:10');
    $schedule->command('nutrir:numeros-ganadores')->dailyAt('16:40');
    $schedule->command('nutrir:numeros-ganadores')->dailyAt('19:40');
    // Ejecuta el script Node.js solo en los horarios requeridos
    $schedule->command('resultados:actualizar-json')->dailyAt('13:00');
    $schedule->command('resultados:actualizar-json')->dailyAt('16:40');
    $schedule->command('resultados:actualizar-json')->dailyAt('19:40');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
