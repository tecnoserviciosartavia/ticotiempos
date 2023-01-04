<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Clientes
 *
 * @property int $num_id
 * @property string $nombre
 * @property string $telefono
 * @property string|null $telefono
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereNumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clientes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Clientes extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = [
        'num_id', 'nombre', 'telefono','email',
    ];
}
