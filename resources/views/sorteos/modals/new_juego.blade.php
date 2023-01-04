<!-- BEGIN: Super Large Modal Content -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('parameter.create') }}">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <i class="w-4 h-4" data-lucide="plus"></i>&nbsp; &nbsp;
                <h2 class="font-medium text-base mr-auto">Agregar Nuevo Juego</h2>
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
                    <label for="modal-form-1" class="form-label">Nombre</label>
                    <input id="modal-form-1" type="text" class="form-control" placeholder="3 PM o 4 PM" name="detalle">
                    @include('alerts.feedback', ['field' => 'detalle'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-2" class="form-label">hora</label>
                    <input id="modal-form-2" type="time" class="form-control" placeholder="3:00 pm" name="hora" require>
                    @include('alerts.feedback', ['field' => 'hora'])

                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-3" class="form-label">Paga</label>
                    <input id="modal-form-3" type="number" class="form-control" placeholder="1 - 100" min='0' max='99' name="paga" require>
                    @include('alerts.feedback', ['field' => 'paga'])

                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-4" class="form-label">Comision</label>
                    <input id="modal-form-4" type="number" class="form-control" placeholder="1.00 - 99.00" name="comision" require>
                    @include('alerts.feedback', ['field' => 'comision'])

                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-5" class="form-label">Restrinccion Numero</label>
                    <input id="modal-form-5" type="number" class="form-control" placeholder="Numerico" name="restrinccion_numero" min='0' max='99'>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-6" class="form-label">Restrinccion Monto</label>
                    <input id="modal-form-6" type="number" class="form-control" placeholder="Numerico" name="restrinccion_monto">
                </div>

            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                <button type="Submit" class="btn btn-primary"><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
            </div>
            <input id="idusuario_modal" type="number" class="form-control" name="idusuario" hidden>
            <input id="idsorteo_modal" type="number" class="form-control" name="idsorteo" hidden>

            <!-- END: Modal Footer -->
        </div>
        </form>
    </div>
</div>
<!-- END: Super Large Modal Content -->
