<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int|null $es_administrador
 * @property int $active
 * @property int|null $saldo_actual
 * @property int $block_user
 * @property string $cod_unico
 * @property string $cod_unico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $photo
 * @property string $gender
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property-read mixed $photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transacciones[] $transacciones
 * @property-read int|null $transacciones_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlockUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodUnico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEsAdministrador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSaldoActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','es_administrador', 'gender', 'active','saldo_actual','block_user','cod_unico',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
    protected $appends = ['photo'];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo !== null) {
            return url('dist/images/profile/' . $this->id . '/' . $this->photo);
        }
        return url('dist/images/profile-' .rand(1,15) . '.jpg');

    }

    public function transacciones()
    {
        return $this->hasMany('App\Models\Transacciones', 'idusuario');
    }

    public function balance()
    {
        return $this->hasMany('App\Models\User_balance', 'users_id');
    }
    public function actualizarSaldoUsuario($idusuario, $monto)
    {
        $usuario = $this->find($idusuario);
        $this->where('id', $idusuario)->update(['saldo_actual' => $usuario->saldo_actual - $monto]);
    }

    public function actualizarSaldoAdministrador($monto, $simbolo)
    {
        if ($simbolo == 'suma') {
            $saldo_actualizado = \Auth::user()->saldo_actual + $monto;
            $this->where('es_administrador', 1)->update(['saldo_actual' => $saldo_actualizado]);
        } else {
            $saldo_actualizado = \Auth::user()->saldo_actual - $monto;
            $this->where('es_administrador', 1)->update(['saldo_actual' => $saldo_actualizado]);
        }
    }
}
