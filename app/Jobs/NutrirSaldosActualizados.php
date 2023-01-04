<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\User_balance;

class NutrirSaldosActualizados implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $usuarios = User::where('active', 1)->get();
        foreach ($usuarios as $user) {
            $balance = User_balance::where('users_id', $user->id)
            ->where('fecha_diaria', '=', now()->format('Y-m-d'))
            ->first();

            if (!isset($balance)) {
                User_balance::create([
                    'users_id'         => $user->id,
                    'saldo_anterior'   => $user->saldo_actual,
                    'premios_del_dia'  => 0.000,
                    'ventas_dia'       => 0.000,
                    'comisiones_dia'   => 0.000,
                    'saldo_final'      => $user->saldo_actual,
                    'fecha_diaria'     => now()->format('Y-m-d'),
                    'created_at'       => now()->format('Y-m-d'),
                ]);
            }
        }
    }
}
