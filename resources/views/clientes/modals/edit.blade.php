<!-- BEGIN: Super Large Modal Content -->
<div id="modal_edit_cliente" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Editar Cliente</h2>
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
                    <label for="modal-edit-form-1" class="form-label">Identificación</label>
                    <input id="modal-edit-form-1" type="number" class="form-control" placeholder="Identificacion del Usuario" name="num_id">
                    @include('alerts.feedback', ['field' => 'num_id'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-2" class="form-label">Nombre</label>
                    <input id="modal-edit-form-2" type="text" class="form-control" placeholder="Nombre del Usuario" name="nombre">
                    @include('alerts.feedback', ['field' => 'nombre'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-3" class="form-label">Teléfono</label>
                    <input id="modal-edit-form-3" type="text" class="form-control" placeholder="Teléfono del Usuario" name="telefono">
                    @include('alerts.feedback', ['field' => 'telefono'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-edit-form-4" class="form-label">Email</label>
                    <input id="modal-edit-form-4" type="email" class="form-control" placeholder="Email del Usuario" name="email">
                    @include('alerts.feedback', ['field' => 'email'])
                </div>
            </div>
            <input type="hidden" id="cliente_id" name="cliente_id" value="">

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
