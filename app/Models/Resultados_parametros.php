<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Resultados_parametros
 *
 * @property int $id
 * @property string $descripcion
 * @property string $color
 * @property int $paga_resultado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Venta_cabecera[] $adicional_result
 * @property-read int|null $adicional_result_count
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resultados_parametros wherePagaResultado($value)
 * @mixin \Eloquent
 */
class Resultados_parametros extends Model
{
    use HasFactory;

    protected $table = 'resultados_parametros';
    protected $guarded = [];
    public $timestamps = false;


    public function adicional_result()
    {
        return $this->hasMany('App\Models\Venta_cabecera', 'adicional_ganador');
    }
}
