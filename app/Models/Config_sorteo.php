<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Config_sorteo
 *
 * @property int $id
 * @property int|null $restrinccion_numero
 * @property string|null $restrinccion_monto
 * @property \App\Models\Sorteos $sorteo
 * @property int $idsorteo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo whereIdsorteo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo whereRestrinccionMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo whereRestrinccionNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config_sorteo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Config_sorteo extends Model
{
    use HasFactory;
    protected $table = 'config_sorteo';
    protected $guarded = [];
}
