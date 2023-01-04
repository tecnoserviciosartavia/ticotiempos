<!-- BEGIN: Super Large Modal Content -->
<div id="modal_new_cliente" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('clientes.store') }}">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Agregar Nuevo Cliente</h2>
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
                    <label for="modal-form-1" class="form-label">Identificación</label>
                    <input id="modal-form-1" type="number" class="form-control" placeholder="Identificacion del Usuario" name="num_id">
                    @include('alerts.feedback', ['field' => 'num_id'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">Nombre</label>
                    <input id="modal-form-2" type="text" class="form-control" placeholder="Nombre del Usuario" name="nombre">
                    @include('alerts.feedback', ['field' => 'nombre'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-3" class="form-label">Teléfono</label>
                    <input id="modal-form-3" type="text" class="form-control" placeholder="Teléfono del Usuario" name="telefono">
                    @include('alerts.feedback', ['field' => 'telefono'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-4" class="form-label">Email</label>
                    <input id="modal-form-4" type="email" class="form-control" placeholder="Email del Usuario" name="email">
                    @include('alerts.feedback', ['field' => 'email'])
                </div>
            </div>
            <input type="number" name="form_action" id="form_action"  value="" hidden>
            <input type="number" name="padre_id_edit_modal" id="padre_id_edit_modal"  value="" hidden>

            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
                <button type="Submit" class="btn btn-primary w-20">Guardar</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
        </form>
    </div>
</div>
<!-- END: Super Large Modal Content -->
