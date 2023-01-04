<!-- BEGIN: Super Large Modal Content -->
<div id="modal_new_config_resultado" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('resultados.store_config') }}" autocomplete="off">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Agregar Nueva Configuracion de Resultado</h2>
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
                    <label for="letra_adicional_ganador" class="form-label">Letra Adicional Ganador</label>
                    <input id="letra_adicional_ganador" type="text" class="form-control" placeholder="Letra Adicional Ganador Ganador" name="descripcion" maxlength="1" require>
                    @include('alerts.feedback', ['field' => 'letra_adicional_ganador'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="adicional_ganador" class="form-label">Color Adicional Ganador</label>
                    <div class="form-item"><label for="color">Color:</label><input type="text" id="color" name="color" value="#ffffff" /></div><div id="picker"></div>
                    @include('alerts.feedback', ['field' => 'adicional_ganador'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="paga_resultado_modal" class="form-label">Paga Resultado</label>
                    <input id="paga_resultado_modal" type="number" class="form-control" placeholder="Letra Adicional Ganador Ganador" name="paga_resultado" require>
                    @include('alerts.feedback', ['field' => 'paga_resultado'])
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
