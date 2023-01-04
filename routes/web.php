<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\SorteosController;
use App\Http\Controllers\TransaccionesController;
use App\Http\Controllers\CuentasController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ResumenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::controller(AuthController::class)->middleware('loggedin')->group(function() {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
});

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(UsersController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('users', 'index')->name('user.index');
        //Crud de Usuarios Agregar Editar Guardar
        Route::get('users-add', 'create')->name('user.add');
        Route::post('users-store', 'store')->name('user.store');
        Route::get('users-{id}-edit', 'edit')->name('user.edit');
        Route::put('users-{id}-update', 'update')->name('user.update');
        Route::get('users-{id}-delete', 'destroy')->name('user.delete');

        // Ver el perfil del usuario y carga de la imagen del perfil
        Route::get('users-{id}-profile', 'profile')->name('user.profile');
        Route::get('users-{id}-updprofile', 'updprofile')->name('user.updprofile');

        // Ver editar y actualizar contraseñas para usuario del aplicativo igualmente envio de link para cambio de clave
        Route::get('change-{id}-password-page', 'changePassword')->name('change-password');
        Route::post('update-{id}-password-page', 'updatePassword')->name('password.update');

        //Home para usuarios normales
        Route::get('/', 'dashboardUsuarios')->name('dashboard.users');
        Route::get('/admin', 'dashboardAdministradores')->name('dashboard.admin');
        //Filtro para dashadmin
        Route::post('admin-filtro', 'filtrodashboardAdministradores')->name('dashadmin.filtro');

        Route::get('users-{id}-block', 'blockearUsuario')->name('user.block');
        Route::post('users-unlock', 'desblockearUsuario')->name('user.unlock');

        Route::post('users-{id}-generate', 'generarKeyUser')->name('user.key');

        Route::post('users-filtro', 'filterUsers')->name('user.filter');
        Route::get('users-{id}-activate', 'ActivarUsers')->name('user.activate');

    });

    Route::controller(ParameterController::class)->group(function() {

        //Ver parametros creeados para el usuario configuracion por sorteo
        Route::get('config-{id}-parameters', 'index')->name('parameter.index');
        Route::get('search-parameters', 'search_parameters')->name('search-parameters');

        //Crear parametro CRUD INICIO
        Route::post('parameter-store', 'store')->name('parameter.create');
        //Delete Parametro
        Route::get('parameter-{id}-delete', 'destroy')->name('parameter.delete');
        Route::get('parameter-{id}-edit', 'edit')->name('parameter.edit');
        Route::post('parameter-{id}-update', 'update')->name('parameter.update');

        // Ruta adicional para usuario final
        Route::get('users-{id}-parameters', 'usuario')->name('parameter.user');

    });

    Route::controller(SorteosController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('sorteos', 'index')->name('sorteos.index');
        //Crud de Sorteos Agregar Editar Guardar
        Route::post('sorteos-store', 'store')->name('sorteos.store');
        Route::get('sorteos-{id}-edit', 'edit')->name('sorteos.edit');
        Route::post('sorteos-{id}-update', 'update')->name('sorteos.update');
        Route::get('sorteos-{id}-delete', 'destroy')->name('sorteos.delete');

        Route::get('sorteos-{id}-restrinccion', 'search_restrinccion')->name('search-restrinccion');
        // Get config sorteo
        Route::get('sorteos-config-parameters', 'search_config_parameters')->name('search-config-parameters');

        // store
        Route::post('restrinccion-store', 'restrinccion')->name('sorteos.restrincciones');
        //update
        Route::post('sorteos-restrinccion-{id}-update', 'restrinccionUpd')->name('sorteos.updateRestrincciones');

    });

    Route::controller(CuentasController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('cuentas', 'index')->name('cuentas.index');
        //Crud de Sorteos Agregar Editar Guardar
        Route::post('cuentas-store', 'store')->name('cuentas.store');

        Route::get('cuentas-{id}-delete', 'destroy')->name('cuentas.delete');


    });

    Route::controller(ResultadosController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('resultados', 'index')->name('resultados.index');
        //Crud de Sorteos Agregar Editar Guardar
        Route::post('resultados-store', 'store')->name('resultados.store');
        Route::post('resultados-update', 'update')->name('resultados.update');

        Route::get('resultados-{id}-delete', 'destroy')->name('resultados.delete');

        Route::get('resultados-parameters', 'resultadosParametros')->name('resultados.parameters');
        Route::post('resultados-save-parameters', 'storeParametros')->name('resultados.store_config');

        Route::post('resultado-filtro', 'filtro_resultado')->name('resultado.filtro');

    });

    Route::controller(TransaccionesController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('transacciones', 'index')->name('transacciones.index');
        //Crud de Sorteos Agregar Editar Guardar
        Route::post('transacciones-store', 'store')->name('transacciones.store');

        Route::get('transacciones-{id}-delete', 'destroy')->name('transacciones.delete');

        Route::post('transacciones-filtro', 'filtro_transaccion')->name('transacciones.filtro');


    });

    Route::controller(ClientesController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('clientes', 'index')->name('clientes.index');
        //Crud de Sorteos Agregar Editar Guardar
        Route::post('clientes-store', 'store')->name('clientes.store');
        Route::get('clientes-{id}-edit', 'edit')->name('clientes.edit');

        Route::post('clientes-{id}-update', 'update')->name('clientes.update');
        Route::get('clientes-{id}-delete', 'destroy')->name('clientes.delete');


    });


    Route::controller(VentaController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('venta-sorteo-create', 'create')->name('venta_sorteo.create');
        Route::post('venta-sorteo-store', 'store')->name('venta_sorteo.store');

        Route::get('venta-sorteo-{id}-edit', 'edit')->name('venta_sorteo.edit');
        Route::post('venta-padre-{id}-edit', 'ventaPadre')->name('venta_sorteo.padre');
        Route::post('venta-padre-{id}-update', 'update')->name('venta_sorteo.update_padre');
        Route::post('venta-eliminar-{id}-detalle', 'deleteDetalle')->name('venta_detalle.delete');
        Route::get('venta-{id}-imprimir', 'imprimirTicket')->name('venta_detalle.imprimir');

        Route::get('json-{id}-imprimir', 'jsonimprimirTicket')->name('json.imprimir');

        // Para el administrador visualizar juegos etc
        Route::get('juegos-hoy', 'juegos')->name('juegos.index');
        // Abrir todos los juegos para el dia actual
        Route::get('abrir-juegos-hoy', 'abrir')->name('juegos.abrir');
        // Cerrar todos los juegos pendientes
        Route::get('cerrar-juegos-hoy', 'cerrar')->name('juegos.cerrar');

        Route::post('venta-cambiar-cliente', 'cambiarClienteVenta')->name('venta_sorteo.cliente');
        //Consultar ticket ganador
        Route::get('canjear-loteria', 'verCanjearTicket')->name('canjear.index');
        Route::post('canjear-filtro', 'filtroCanjearTicket')->name('canjear.filtro');

        Route::get('pagar-{id}-ticket', 'pagarTicketVenta')->name('pagar.ticket');
        Route::get('copiar-{id}-ticket', 'copiarTicket')->name('copiar.ticket');

    });

    Route::controller(ResumenController::class)->group(function() {
        //Ver todos los usuarios creados en el app
        Route::get('resumen', 'index')->name('resumen.index');
        Route::get('resumen-{id}-jugadas', 'jugadas')->name('resumen.jugadas');
        Route::get('resumen-{id}-ganadoras', 'ganadoras')->name('resumen.ganadoras');

        Route::post('resumen-filtro', 'filtro_resumen')->name('resumen.filtro');

        Route::get('resumen-reporteria', 'cobro')->name('resumen.reporteria');
        Route::post('cobro-filtro', 'filtro_cobro')->name('cobro.filtro');

        //Rutas para Historico
        Route::get('resumen-historico', 'historico')->name('resumen.historico');
        Route::post('resumen-historico-filtro', 'filtro_historico')->name('filtro.historico');

        Route::get('resumen-admin', 'resumenAdmin')->name('resumen.admin.index');
        Route::post('resumen-admin-filtro', 'filtroAdmin')->name('resumen.adminfiltro');

    });
});
