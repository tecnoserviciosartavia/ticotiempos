<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venta_cabecera;
/**
 * App\Models\Venta_detalle
 *
 * @property int $id
 * @property int $numero
 * @property string $monto
 * @property int $reventado
 * @property string $monto_reventado
 * @property int|null $jugada_padre
 * @property string $estatus
 * @property int|null $es_ganador
 * @property string|null $monto_ganador
 * @property int $fue_pagado
 * @property int $idventa_cabecera
 * @property \App\Models\User $user
 * @property int $idusuario
 * @property \App\Models\Cliente $cliente
 * @property int $idcliente
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Venta_cabecera[] $cabecera
 * @property-read int|null $cabecera_count
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereEsGanador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereFuePagado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereIdcliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereIdventaCabecera($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereJugadaPadre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereMontoGanador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereMontoReventado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereReventado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_detalle whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Venta_detalle extends Model
{
    use HasFactory;
    protected $table = 'venta_detalle';
    protected $fillable = [
        'idventa_cabecera', 'idusuario', 'idcliente','numero','monto','es_ganador','monto_ganador','jugada_padre','estatus','monto_reventado','reventado','fue_pagado','impreso',
    ];


    public function cabecera() {
        return $this->hasMany(Venta_cabecera::class, 'idventa_cabecera');
    }

    public function buscarCabecera() {
        $cabecera = Venta_cabecera::find($this->idventa_cabecera);
        $cabecera_nueva = Venta_cabecera::where('idsorteo', $cabecera->idsorteo)->where('estatus', '=', 'abierto')->first();
        return $cabecera_nueva->id;
    }

    public function updateImpreso($estado) {
        $this->fill(['impreso' => $estado])->save();
    }

    public function detallePorUsuario($idusuario, $juego){

        if ($idusuario == 'all') {
            $detalle = $this->where('idventa_cabecera', '=', $juego)->get();
        } else {
            $detalle = $this->where('idventa_cabecera', '=', $juego)->where('idusuario', '=', $idusuario)->get();
        }
        return $detalle;
    }

    public function venta1Impresion($id)
    {
        return $this->select('venta_detalle.*', 'cliente.num_id', 'cliente.nombre as name_cliente', 'users.name as name_banca', 'users.photo')
        ->join('cliente', 'venta_detalle.idcliente', '=', 'cliente.id')
        ->join('users', 'venta_detalle.idusuario', '=', 'users.id')
        ->where('venta_detalle.id',$id)
        ->get();
    }

    public function traerJugadasHijas($id_padre)
    {
        return $this->select('venta_detalle.*', 'cliente.num_id', 'cliente.nombre as name_cliente')
        ->join('cliente', 'venta_detalle.idcliente', '=', 'cliente.id')
        ->join('users', 'venta_detalle.idusuario', '=', 'users.id')
        ->where('venta_detalle.jugada_padre',$id_padre)
        ->get();
    }

    public function traerMontoVentaPorCabeceraYUsuario($idventa_cabecera, $idusuario){
        if (!is_null($idusuario)) {
            $monto_reventado = $this->where('idventa_cabecera', $idventa_cabecera)->where('idusuario', $idusuario)->sum('monto_reventado');
            $monto_venta     = $this->where('idventa_cabecera', $idventa_cabecera)->where('idusuario', $idusuario)->sum('monto');
        } else {
            $monto_reventado = $this->where('idventa_cabecera', $idventa_cabecera)->sum('monto_reventado');
            $monto_venta     = $this->where('idventa_cabecera', $idventa_cabecera)->sum('monto');
        }
        return $monto_venta + $monto_reventado;
    }

    public function traerMontoPremioPorSorteo($idventa_cabecera, $idusuario){
        if (!is_null($idusuario)) {
            $monto = $this->where('idventa_cabecera', $idventa_cabecera)->where('idusuario', $idusuario)->where('es_ganador', 1)->where('estatus', 'ganadora')->sum('monto_ganador');
        } else {
            $monto = $this->where('idventa_cabecera', $idventa_cabecera)->where('es_ganador', 1)->where('estatus', 'ganadora')->sum('monto_ganador');
        }
        return $monto;
    }
}
