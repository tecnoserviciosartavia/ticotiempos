<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_balance extends Model
{
    use HasFactory;
    protected $table = 'user_balances';
    protected $fillable = [
        'users_id', 'saldo_anterior', 'premios_del_dia', 'ventas_dia', 'comisiones_dia','saldo_final','fecha_diaria',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','users_id');
    }
    public function actualizarSaldoConPremio($idusuario, $monto_ganador)
    {
        //Actualizo Saldos Nuevo Update V2.0
        $users_balance = $this->where('users_id', $idusuario)
        ->where('fecha_diaria', '=', now()->format('Y-m-d'))
        ->first();
        $users_balance->premios_del_dia     += $monto_ganador;
        $users_balance->saldo_final          = $users_balance->saldo_final - $monto_ganador;
        $users_balance->save();
        return true;
    }

    public function actualizarSaldoConVentasyComisiones($idusuario, $monto_venta, $comision_usuario)
    {
        //Actualizo Saldos Nuevo Update V2.0
        $users_balance = $this->where('users_id', $idusuario)
        ->where('fecha_diaria', '=', now()->format('Y-m-d'))
        ->first();
        $users_balance->ventas_dia     += $monto_venta;
        $users_balance->comisiones_dia += $comision_usuario;
        $users_balance->saldo_final    += $monto_venta;
        $users_balance->save();
        return true;
    }

    public static function saldoActual($user_id)
    {
       return User_balance::where('users_id', $user_id)->where('fecha_diaria', '=', now()->format('Y-m-d'))->first();
    }

    public function checkearSaldoParaRetiro($usuario, $monto)
    {
        //Actualizo Saldos Nuevo Update V2.0
        $users_balance = $this->where('users_id', $usuario)
        ->where('fecha_diaria', '=', now()->format('Y-m-d'))
        ->first();

        if ($users_balance->saldo_anterior > $monto) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarSaldoRecalculoConPremio($idusuario, $monto_ganador)
    {
        //Actualizo Saldos Nuevo Update V2.0
        $users_balance = $this->where('users_id', $idusuario)
        ->where('fecha_diaria', '=', now()->format('Y-m-d'))
        ->first();
        $users_balance->premios_del_dia      = $users_balance->premios_del_dia - $monto_ganador;
        $users_balance->saldo_final          = $users_balance->saldo_final + $monto_ganador;
        $users_balance->save();
        return true;
    }
}
