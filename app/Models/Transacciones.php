<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transacciones
 *
 * @property int $id
 * @property string $monto
 * @property string $concepto
 * @property string $tipo_concepto
 * @property int $idusuario
 * @property string|null $json_dinamico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $usuarios
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereConcepto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereJsonDinamico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereTipoConcepto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transacciones whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Transacciones extends Model
{
    use HasFactory;
    protected $table = 'transacciones';
    protected $fillable = [
        'idusuario', 'monto', 'concepto', 'tipo_concepto', 'json_dinamico',
    ];

    public function usuarios()
    {
        return $this->belongsTo('App\Models\User','idusuario');
    }

    public function filtroPorUsuario($idusuario){

        if ($idusuario == 'all') {

            $transacciones = Transacciones::where('tipo_concepto', '=', 'premio')
            ->orderBy('created_at', 'desc')
            ->latest()
            ->take(5)
            ->get();
        } else {

            $transacciones = Transacciones::where('tipo_concepto', '=', 'premio')
            ->where('idusuario', '=', $idusuario)
            ->orderBy('created_at', 'desc')
            ->latest()
            ->take(5)
            ->get();
        }

        return $transacciones;
    }

    public function filtroPorFechaBetween($desde,$hasta,$concepto)
    {
        if ($concepto == 'all') {
            $transacciones = $this->whereBetween('created_at',[$desde,$hasta])
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $transacciones = $this->whereBetween('created_at',[$desde,$hasta])
            ->where('tipo_concepto', '=', $concepto)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $transacciones;
    }
    public function buscarPadre()
    {
        $json = json_decode($this->json_dinamico);
        if (isset($json->jugada->id)) {
            if ($json->jugada->jugada_padre == null) {
                return $json->jugada->id;
            } else {
                return $json->jugada->jugada_padre;
            }
        } else {
            if ($json[0]->jugada_padre == null) {
                return $json[0]->id;
            } else {
                return $json[0]->jugada_padre;
            }

        }
    }
}
