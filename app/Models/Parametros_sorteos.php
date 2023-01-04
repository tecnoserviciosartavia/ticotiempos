<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Parametros_sorteos
 *
 * @property int $id
 * @property string $paga
 * @property string $comision
 * @property string $devolucion
 * @property string $monto_arranque
 * @property \App\Models\User $user
 * @property int $idusuario
 * @property \App\Models\Sorteos $sorteo
 * @property int $idsorteo
 * @property-read \App\Models\Sorteos|null $parametros_sorteos
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos whereComision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos whereDevolucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos whereIdsorteo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos whereIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos whereMontoArranque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametros_sorteos wherePaga($value)
 * @mixin \Eloquent
 */
class Parametros_sorteos extends Model
{
    use HasFactory;
    protected $table = 'parametros_sorteos';
    protected $guarded = [];
    public $timestamps = false;

    public function parametros_sorteos()
    {
        return $this->belongsTo('App\Models\Sorteos','idsorteo');
    }

    public function parametrosImpresion($idusuario, $idsorteo)
    {
        return $this->where(['idusuario' => $idusuario, 'idsorteo' => $idsorteo])->get();
    }
}
