<!-- BEGIN: Super Large Modal Content -->
<div id="modal_edit_sorteos" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="#" id='editar_sorteo_form' autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Editar Sorteo</h2>
                <div class="dropdown sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                        <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                    </a>
                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-4 sm:col-span-4"></div>
                <div class="col-span-4 sm:col-span-4">
                    <div class="w-52 mx-auto xl:mr- xl:ml-6">
                        <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                            <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                <img class="rounded-md" alt="Tiempos Darwins" src="{{ asset('dist/images/logos/LOGODkk.png') }}" id='logo_sorteo_edit'>
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
                    <input id="modal-edit-form-1" type="text" class="form-control" placeholder="Nombre del Sorteo" name="nombre">
                    @include('alerts.feedback', ['field' => 'nombre'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-2" class="form-label">Hora</label>
                    <input id="modal-edit-form-2" type="time" class="form-control" placeholder="Hora del Sorteo" name="hora">
                    @include('alerts.feedback', ['field' => 'hora'])
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-3" class="form-label">Dias</label>

                    <select name="dias[]" id="dias_modal_edit" data-placeholder="Seleccionar los Dias de Juego" class="tom-select w-full" multiple value=''>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miercoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sabado</option>
                        <option value="7">Domingo</option>
                    </select>
                    @include('alerts.feedback', ['field' => 'dias'])

                    </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-4" class="form-label">Es Reventado?</label>
                    <select class="form-select form-select-lg sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="es_reventado" id="modal-edit-form-4">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                    @include('alerts.feedback', ['field' => 'es_reventado'])
                </div>
            </div>
            <input type="hidden" id="sorteo_id" name="sorteo_id" value="">

            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                <button type="Submit" class="btn btn-primary" id="submit"><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->
