<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venta_detalle;
use App\Models\User;
/**
 * App\Models\Venta_cabecera
 *
 * @property int $id
 * @property mixed $fecha
 * @property mixed $hora
 * @property string $estatus
 * @property int $cierra_antes
 * @property string $monto_venta
 * @property int|null $numero_ganador
 * @property string|null $adicional_ganador
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Venta_detalle|null $detalle
 * @property-read \App\Models\Resultados_parametros|null $parameter_res
 * @property-read \App\Models\Sorteos|null $sorteos
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera query()
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereAdicionalGanador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereCierraAntes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereIdconfigsorteo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereIdsorteo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereMontoVenta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereNumeroGanador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venta_cabecera whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Venta_cabecera extends Model
{
    use HasFactory;
    protected $table = 'venta_cabecera';
    protected $fillable = [
        'idsorteo', 'idconfigsorteo', 'fecha','hora','estatus','cierra_antes','monto_venta','numero_ganador','adicional_ganador',
    ];

    public function sorteos()
    {
        return $this->belongsTo('App\Models\Sorteos','idsorteo');
    }

    public function parameter_res()
    {
        return $this->belongsTo('App\Models\Resultados_parametros','adicional_ganador');
    }


    public function detalle() {
        return $this->belongsTo(Venta_detalle::class);
    }

    public function traerJugadas($idusuario){
        return Venta_detalle::where('idventa_cabecera', $this->attributes['id'])
        ->where('estatus', '=', 'apostada')
        ->where('idusuario', '=',  $idusuario)
        ->orderBy('created_at', 'asc')->get();
    }

    public function traerMasivas($idusuario){
        $usuario = User::findOrFail($idusuario);
        if ($usuario->es_administrador > 0) {

            $apuestas = Venta_detalle::where([
                ['idventa_cabecera', '=', $this->attributes['id']],
                ['estatus', '!=', 'en proceso']
            ])->get();

        } else {

            $apuestas = Venta_detalle::where([
                ['idusuario', '=', $idusuario],
                ['idventa_cabecera', '=', $this->attributes['id']],
                ['estatus', '!=', 'en proceso']
            ])->get();
        }

        $callback = [];
        foreach ($apuestas as  $apuesta) {

            if (array_key_exists($apuesta->numero, $callback)) {

                $callback[$apuesta->numero] += $apuesta->monto;
            } else {
                $callback[$apuesta->numero] = $apuesta->monto;
            }
        }

        return $callback;
    }
    public function traerGanadoras(){
        return Venta_detalle::where('idventa_cabecera', $this->attributes['id'])->where('es_ganador', 1)
        ->orderBy('created_at', 'asc')->get();
    }

    public function filtrarPorSorteosUltimasCinco($sorteo, $usuario){

        if ($sorteo == 'all') {

            if ($usuario == 'all') {

                $ultimas_ventas = $this->Join('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
                ->select('venta_cabecera.*', 'venta_detalle.numero', 'venta_detalle.monto','venta_detalle.monto_reventado', 'venta_detalle.estatus as estatus_detalle')
                ->where('venta_cabecera.fecha', '=', date('Y-m-d'))
                ->latest()
                ->take(5)
                ->get();
            } else {

                $ultimas_ventas = $this->Join('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
                ->select('venta_cabecera.*', 'venta_detalle.numero', 'venta_detalle.monto','venta_detalle.monto_reventado', 'venta_detalle.estatus as estatus_detalle')
                ->where('venta_cabecera.fecha', '=', date('Y-m-d'))
                ->where('venta_detalle.idusuario', '=', $usuario)
                ->latest()
                ->take(5)
                ->get();
            }

        } else {

            if ($usuario == 'all') {

                $ultimas_ventas = $this->Join('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
                ->select('venta_cabecera.*', 'venta_detalle.numero', 'venta_detalle.monto','venta_detalle.monto_reventado', 'venta_detalle.estatus as estatus_detalle')
                ->where('venta_cabecera.idsorteo', '=', $sorteo)
                ->where('venta_cabecera.fecha', '=', date('Y-m-d'))
                ->latest()
                ->take(5)
                ->get();
            } else {

                $ultimas_ventas = $this->Join('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
                ->select('venta_cabecera.*', 'venta_detalle.numero', 'venta_detalle.monto','venta_detalle.monto_reventado', 'venta_detalle.estatus as estatus_detalle')
                ->where('venta_cabecera.idsorteo', '=', $sorteo)
                ->where('venta_cabecera.fecha', '=', date('Y-m-d'))
                ->where('venta_detalle.idusuario', '=', $usuario)
                ->latest()
                ->take(5)
                ->get();
            }
        }
        return $ultimas_ventas;
    }

    public function filtrarPorSorteoyFechaIgual($fecha, $idsorteo){
        if ($idsorteo == 'all') {
            $data = $this->where('venta_cabecera.fecha', '=', $fecha)->get();
        } else {
            $data = $this->where('venta_cabecera.fecha', '=', $fecha)
            ->where('idsorteo', '=', $idsorteo)->get();
        }
        return $data;
    }

    public function ventaCabeceraImpresion($id)
    {
        return $this->join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')
        ->join('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
        ->where([
            ['venta_cabecera.id', '=', $id]
        ])->get(['venta_cabecera.*', 'sorteos.nombre', 'sorteos.es_reventado','sorteos.logo', 'config_sorteo.restrinccion_numero', 'config_sorteo.restrinccion_monto']);
    }

    public function traerCabeceraParaResumen($desde,$hasta){
        return Venta_cabecera::where([
            ['venta_cabecera.monto_venta', '>', 0],
        ])
        ->whereBetween('venta_cabecera.fecha', [$desde, $hasta])
        ->groupBy('venta_cabecera.id')
        ->get('venta_cabecera.*');
    }
}
