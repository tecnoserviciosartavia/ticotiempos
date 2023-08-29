@extends('../layout/' . $layout)

@section('subhead')
    <title>Interfaz de Usuario - Sistema de Tiempos</title>
@endsection

@section('subcontent')
@if(isset($users))
<div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Editar el Usuario</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Validation -->
            <div class="intro-y box">
                <div id="form-validation" class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <form method="post" action="{{ route('user.update', $users->id) }}" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    Nombre <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido, al menos 2 caracteres</span>
                                </label>
                                <input id="validation-form-1" type="text" name="name" class="form-control" placeholder="John Legend" minlength="2" required value="{{ $users->name }}">
                            </div>
                            <div class="input-form mt-3">
                                <label for="validation-form-4" class="form-label w-full flex flex-col sm:flex-row">
                                    ¿Es Administrador? <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <select name="es_administrador" id="es_administrador" class="tom-select w-full tomselected">
                                    <option value="0" {{ ($users->es_administrador == 0 ? 'selected="selected"' : '') }}>No</option>
                                    <option value="1" {{ ($users->es_administrador == 1 ? 'selected="selected"' : '') }}>Si</option>
                                </select>
                            </div>
                            <div class="input-form mt-3">
                                <label for="validation-form-4" class="form-label w-full flex flex-col sm:flex-row">
                                Género  <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <select name="gender" id="gender" class="tom-select w-full tomselected">
                                    <option value="male" {{ ($users->gender == 'male' ? 'selected="selected"' : '') }}>Hombre</option>
                                    <option value="female" {{ ($users->gender == 'female' ? 'selected="selected"' : '') }}>Mujer</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-5 text-center"><i class="w-4 h-4" data-lucide="save"></i> &nbsp; &nbsp;Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- END: Form Validation -->
        </div>
    </div>
@else
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Registro de nuevo Usuario</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Validation -->
            <div class="intro-y box">
                <div id="form-validation" class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <form method="post" action="{{ route('user.store') }}" autocomplete="off">
                            @csrf
                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    Nombre <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido, al menos 2 caracteres</span>
                                </label>
                                <input id="validation-form-1" type="text" name="name" class="form-control" placeholder="John Legend" minlength="2" required>
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="input-form mt-3">
                                <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row">
                                    Correo Electronico <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido, formato de Correo</span>
                                </label>
                                <input id="validation-form-2" type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="input-form mt-3">
                                <label for="validation-form-3" class="form-label w-full flex flex-col sm:flex-row">
                                    Contraseña <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido, al menos 6 caracteres</span>
                                </label>
                                <input id="validation-form-3" type="password" name="password" class="form-control" placeholder="secret" minlength="6" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="input-form mt-3">
                                <label for="validation-form-4" class="form-label w-full flex flex-col sm:flex-row">
                                    ¿Es Administrador? <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <select name="es_administrador" id="es_administrador" class="tom-select w-full tomselected">
                                    <option value="0" selected>No</option>
                                    <option value="1">Si</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'es_administrador'])
                            </div>
                            <div class="input-form mt-3">
                                <label for="validation-form-4" class="form-label w-full flex flex-col sm:flex-row">
                                Género  <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <select name="gender" id="gender" class="tom-select w-full tomselected">
                                    <option value="male" selected>Hombre</option>
                                    <option value="female">Mujer</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'gender'])

                            </div>
                            <div class="input-form">
                                <label for="comision" class="form-label w-full flex flex-col sm:flex-row">
                                    Comisión <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <input id="comision" type="number" class="form-control" placeholder="1.00 - 99.00" name="comision" require>
                                @include('alerts.feedback', ['field' => 'comision'])
                            </div>
                            <div class="input-form">
                                <label for="paga" class="form-label w-full flex flex-col sm:flex-row">
                                    Paga <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <input id="paga" type="number" class="form-control" placeholder="1 - 100" min='0' max='99' name="paga" require>
                                @include('alerts.feedback', ['field' => 'paga'])
                            </div>
                            <div class="input-form">
                                <label for="monto_limite_numero" class="form-label w-full flex flex-col sm:flex-row">
                                    Monto Limite por Numero <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Requerido</span>
                                </label>
                                <input id="monto_limite_numero" type="number" name="monto_limite_numero" class="form-control" placeholder="Monto por numero por sorteo" required>
                                @include('alerts.feedback', ['field' => 'monto_limite_numero'])
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-5 text-center"><i class="w-4 h-4" data-lucide="save"></i> &nbsp; &nbsp;Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- END: Form Validation -->
        </div>
    </div>
@endif


@endsection
@include('alerts.success')
@include('alerts.messages')
