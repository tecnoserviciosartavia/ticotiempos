<!-- BEGIN: Super Large Modal Content -->
<div id="modal_edit_parametro" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Editar Parametro</h2>
                <div class="dropdown sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                        <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                    </a>
                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-1" class="form-label">Paga</label>
                    <input id="modal-edit-form-1" type="number" class="form-control" placeholder="1 - 100" min='0' max='99' name="paga" require>
                    @include('alerts.feedback', ['field' => 'paga'])

                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-2" class="form-label">Comision</label>
                    <input id="modal-edit-form-2" type="number" class="form-control" placeholder="1.00 - 99.00" name="comision" require>
                    @include('alerts.feedback', ['field' => 'comision'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-3" class="form-label">Devolucion</label>
                    <input id="modal-edit-form-3" type="number" class="form-control" placeholder="Numerico" name="devolucion">
                    @include('alerts.feedback', ['field' => 'devolucion'])

                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-4" class="form-label">Monto Limite por Numero</label>
                    <input id="modal-edit-form-4" type="number" class="form-control" placeholder="Numerico" name="monto_arranque">
                    @include('alerts.feedback', ['field' => 'monto_arranque'])

                </div>
            </div>
            <input type="hidden" id="parametros_id" name="parametros_id" value="">

            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
                <button type="submit" class="btn btn-primary w-20" id="submit">Guardar</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->
