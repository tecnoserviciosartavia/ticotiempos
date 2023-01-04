<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Sorteos
 *
 * @property int $id
 * @property int $estatus
 * @property string $nombre
 * @property string|null $logo
 * @property string $hora
 * @property string $dias
 * @property int $es_reventado
 * @property int $monto_limite_numero
 * @property int $usa_webservice
 * @property int $numero_sorteo_webservice
 * @property string|null $url_webservice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $primera_foto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Venta_cabecera[] $juegos
 * @property-read int|null $juegos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Parametros_sorteos[] $sorteo_parameter
 * @property-read int|null $sorteo_parameter_count
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereDias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereEsReventado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sorteos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sorteos extends Model
{
    use HasFactory;
    protected $table = 'sorteos';
    protected $guarded = [];

    public function juegos()
    {
        return $this->hasMany('App\Models\Venta_cabecera', 'idsorteo');
    }

    public function sorteo_parameter()
    {
        return $this->hasMany('App\Models\Parametros_sorteos', 'idsorteo');
    }

    public function getPrimeraFotoAttribute()
    {
        //buscar el primer foto que tenga imagen
        if ($this->logo) {
            return url('dist/images/sorteos/'.$this->logo);

        }
        return  url('dist/images/logos/LOGODkk.png');
    }

}
