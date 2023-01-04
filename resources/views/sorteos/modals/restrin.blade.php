<!-- BEGIN: Super Large Modal Content -->
<div id="modal_restrincciones_sorteos" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('sorteos.restrincciones') }}">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Restrincciones para el Sorteo</h2>
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
                    <label for="restrinccion_numero" class="form-label">Numero</label>
                    <input id="restrinccion_numero" type="number" class="form-control" placeholder="Numero del Sorteo" name="restrinccion_numero" min='0' max='99'>
                    @include('alerts.feedback', ['field' => 'restrinccion_numero'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="restrinccion_monto" class="form-label">Monto</label>
                    <input id="restrinccion_monto" type="number" class="form-control" placeholder="Monto de la restrinccion para el Sorteo" name="restrinccion_monto">
                    @include('alerts.feedback', ['field' => 'restrinccion_monto'])
                </div>
                <input type="hidden" id="sorteo_id" name="sorteo_id" value="">
                <input type="hidden" id="config_id" name="config_id" value="">
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                <button type="Submit" class="btn btn-primary" id="submit_restrinccion"><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
        </form>
    </div>
</div>
<!-- END: Super Large Modal Content -->
