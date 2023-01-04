@extends('../layout/' . $layout)

@section('subhead')
    <title>Edicion Sorteo - Sistema de Tiempos</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Editar Sorteo del Sistema</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-3"></div>
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="intro-y box">
            <!-- BEGIN: HTML Table Data -->
            <div class="intro-y box p-5 mt-5">
                <div class="intro-y col-span-12 lg:col-span-6">
                    <form class="form" method="post" action="{{ route('sorteos.update', $sorteo->id) }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="col-span-4 sm:col-span-4"></div>
                        <div class="col-span-4 sm:col-span-4">
                            <div class="w-52 mx-auto xl:mr- xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        @if (is_null($sorteo->logo))

                                            <img class="rounded-md" alt="TicoTiempos" src="{{ asset('dist/images/logos/LOGODkk.png') }}" id='logo_sorteo_edit'>
                                        @else

                                            <img class="rounded-md" alt="TicoTiempos" src="{{ asset('dist/images/sorteos/'.$sorteo->logo) }}" id='logo_sorteo_edit'>
                                        @endif
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="btn btn-primary w-full"><i data-lucide="image" class="w-4 h-4 mr-2"></i>Cargar Logo</button>
                                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="logo" id='logo_form_edit_modal'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-4 sm:col-span-4"></div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-edit-form-1" class="form-label">Nombre</label>
                            <input id="modal-edit-form-1" type="text" class="form-control" placeholder="Nombre del Sorteo" name="nombre" value="{{ $sorteo->nombre }}">
                            @include('alerts.feedback', ['field' => 'nombre'])
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-edit-form-2" class="form-label">Hora</label>
                            <input id="modal-edit-form-2" type="time" class="form-control" placeholder="Hora del Sorteo" name="hora" value="{{ $sorteo->hora }}">
                            @include('alerts.feedback', ['field' => 'hora'])
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-edit-form-3" class="form-label">Dias</label>
                            <select name="dias[]" id="dias_modal_edit" data-placeholder="Seleccionar los Dias de Juego" class="tom-select w-full" multiple value=''>
                                    <option value="1" {{ (in_array("1", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Lunes</option>
                                    <option value="2" {{ (in_array("2", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Martes</option>
                                    <option value="3" {{ (in_array("3", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Miercoles</option>
                                    <option value="4" {{ (in_array("4", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Jueves</option>
                                    <option value="5" {{ (in_array("5", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Viernes</option>
                                    <option value="6" {{ (in_array("6", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Sabado</option>
                                    <option value="7" {{ (in_array("7", json_decode($sorteo->dias, true)) == TRUE ? 'selected="selected"' : '') }}>Domingo</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'dias'])

                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="es_reventado" class="form-label">¿Es Reventado?</label>
                            <select class="form-select form-select-lg sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="es_reventado" id="es_reventado">
                                <option value="0"  {{ ($sorteo->es_reventado == '0' ? 'selected="selected"' : '') }}>No</option>
                                <option value="1"  {{ ($sorteo->es_reventado == '1' ? 'selected="selected"' : '') }}>Si</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'es_reventado'])
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-edit-form-4" class="form-label">Estatus</label>
                            <select class="form-select form-select-lg sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="estatus" id="modal-edit-form-4">
                                <option value="0"  {{ ($sorteo->estatus == '0' ? 'selected="selected"' : '') }}>Inactivo</option>
                                <option value="1"  {{ ($sorteo->estatus == '1' ? 'selected="selected"' : '') }}>Activo</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'estatus'])
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="usa_webservice" class="form-label">¿Usa Webservice?</label>
                            <select class="form-select form-select-lg sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="usa_webservice" id="usa_webservice">
                                <option value="0"  {{ ($sorteo->usa_webservice == '0' ? 'selected="selected"' : '') }}>No</option>
                                <option value="1"  {{ ($sorteo->usa_webservice == '1' ? 'selected="selected"' : '') }}>Si</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'usa_webservice'])
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="url_webservice" class="form-label">Seleccione un Webservice</label>
                            <select class="form-select form-select-lg sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="url_webservice" id="url_webservice">
                                <option value="0"  {{ ($sorteo->url_webservice == '0' ? 'selected="selected"' : '') }}>-- Sin Webservices --</option>
                                <option value="https://integration.jps.go.cr//api/App/nuevostiempos/"  {{ ($sorteo->url_webservice == 'https://integration.jps.go.cr//api/App/nuevostiempos/' ? 'selected="selected"' : '') }}>La Junta - Loteria Tica</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'url_webservice'])
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="numero_sorteo_webservice" class="form-label">Numero de Sorteo WebService</label>
                            <input id="numero_sorteo_webservice" type="number" class="form-control" placeholder="Numero de Sorteo WebService" name="numero_sorteo_webservice" value="{{ $sorteo->numero_sorteo_webservice }}" readonly>
                            @include('alerts.feedback', ['field' => 'numero_sorteo_webservice'])
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="monto_limite_numero" class="form-label">Monto Limite por Numero</label>
                            <input id="monto_limite_numero" type="number" class="form-control" placeholder="Monto Limite por Numero" name="monto_limite_numero" value="{{ $sorteo->monto_limite_numero }}">
                            @include('alerts.feedback', ['field' => 'monto_limite_numero'])
                        </div>
                        <div class="sm:ml-20 sm:pl-5 mt-5">
                            <button type="Submit" class="btn btn-primary" id="submit"><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('alerts.success')
@include('alerts.messages')
