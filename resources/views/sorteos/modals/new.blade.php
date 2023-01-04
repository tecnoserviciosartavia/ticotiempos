<!-- BEGIN: Super Large Modal Content -->
<div id="modal_new_sorteo" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('sorteos.store') }}" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Agregar Nuevo Sorteo</h2>
                <div class="dropdown sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                        <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                    </a>
                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-4 sm:col-span-4">
                    <div class="w-52 mx-auto xl:mr- xl:ml-6">
                        <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                            <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                <img class="rounded-md" alt="Tiempos Darwins" src="{{ asset('dist/images/logos/LOGODkk.png') }}">
                            </div>
                            <div class="mx-auto cursor-pointer relative mt-5">
                                <button type="button" class="btn btn-primary w-full"><i data-lucide="image" class="w-4 h-4 mr-2"></i>Cargar Logo</button>
                                <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="logo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-4 sm:col-span-4">
                    <label for="modal-form-1" class="form-label">Nombre</label>
                    <input id="modal-form-1" type="text" class="form-control" placeholder="Nombre del Sorteo" name="nombre">
                    @include('alerts.feedback', ['field' => 'nombre'])
                    <label for="modal-form-3" class="form-label" style="margin-top: 10px;">Dias</label>
                    <select data-placeholder="Select your favorite actors" class="tom-select w-full" multiple id="modal-form-3" name="dias[]">
                        <option value="1" selected>Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="7">Domingo</option>
                    </select>
                    @include('alerts.feedback', ['field' => 'dias'])

                    <label for="comision" class="form-label" style="margin-top: 10px;">Comision (Defecto)</label>
                    <input id="comision" type="number" class="form-control" placeholder="1.00 - 99.00" name="comision">
                    @include('alerts.feedback', ['field' => 'comision'])

                    <label for="usa_webservice" class="form-label" style="margin-top: 10px;">¿Usa Webservice?</label>
                    <select class="tom-select" id="usa_webservice" name="usa_webservice">
                        <option value="0">No</option>
                        <option value="1">Si</option>

                    </select>
                    @include('alerts.feedback', ['field' => 'usa_webservice'])
                    <label for="monto_limite_numero" class="form-label">Monto Limite por Numero</label>
                    <input id="monto_limite_numero" type="number" class="form-control" placeholder="Monto Limite por Numero" name="monto_limite_numero">
                    @include('alerts.feedback', ['field' => 'monto_limite_numero'])
                </div>
                <div class="col-span-4 sm:col-span-4">
                    <label for="modal-form-2" class="form-label">Hora</label>
                    <input id="modal-form-2" type="time" class="form-control" placeholder="Hora del Sorteo" name="hora">
                    @include('alerts.feedback', ['field' => 'hora'])

                    <label for="es_reventado" class="form-label" style="margin-top: 10px;">¿Es Reventado?</label>
                    <select class="tom-select" id="es_reventado" name="es_reventado">
                        <option value="0">No</option>
                        <option value="1">Si</option>

                    </select>
                    @include('alerts.feedback', ['field' => 'es_reventado'])

                    <label for="paga" class="form-label"  style="margin-top: 10px;">Paga (Defecto)</label>
                    <input id="paga" type="number" class="form-control" placeholder="1 - 100" min='0' max='99' name="paga">
                    @include('alerts.feedback', ['field' => 'paga'])

                        <label for="url_webservice" class="form-label" style="margin-top: 10px;">Seleccione un Webservice</label>
                        <select class="tom-select" id="url_webservice" name="url_webservice">
                            <option value="0"> -- Sin Webservices -- </option>
                            <option value="https://integration.jps.go.cr//api/App/nuevostiempos/">La Junta - Loteria Tica</option>
                        </select>

                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                <button type="Submit" class="btn btn-primary"><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
        </form>
    </div>
</div>
<!-- END: Super Large Modal Content -->
