<!-- BEGIN: Super Large Modal Content -->
<div id="modal_new_retiro" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('cuentas.store') }}">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Agregar Nuevo Retiro</h2>
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
                    <label for="modal-form-1" class="form-label">Concepto / Detalle</label>
                    <input id="modal-form-1" type="text" class="form-control" placeholder="Concepto / Detalle del retiro" name="concepto">
                    @include('alerts.feedback', ['field' => 'concepto'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">Monto</label>
                    <input id="modal-form-2" type="number" step='any' class="form-control" placeholder="Monto del Retiro" name="monto">
                    @include('alerts.feedback', ['field' => 'monto'])
                </div>
            </div>
            <input type="hidden" id="usuario_id" name="usuario_id" value="">

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
