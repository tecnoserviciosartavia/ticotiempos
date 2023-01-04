<!-- BEGIN: Super Large Modal Content -->
<div id="modal_new_transaccion" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('transacciones.store') }}">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Agregar Nueva Transaccion</h2>
                <div class="dropdown sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                        <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                    </a>
                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-6 sm:col-span-6">
                    <label for="idusuario_modal" class="form-label" style="margin-top: 10px;">Usuario para la Transaccion</label>
                    <select class="form-select" aria-label=".form-select-lg example" name="idusuario" id="idusuario_modal" require>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                    @include('alerts.feedback', ['field' => 'idusuario'])

                    <label for="concepto_modal" class="form-label" style="margin-top: 10px;">Concepto</label>
                    <input id="concepto_modal" type="text" class="form-control" placeholder="Concepto" name="concepto" require>
                    @include('alerts.feedback', ['field' => 'concepto'])

                </div>

                <div class="col-span-6 sm:col-span-6">
                    <label for="tipo_concepto" class="form-label" style="margin-top: 10px;">Tipo de Concepto</label>
                    <select class="form-select" aria-label=".form-select-lg example" name="tipo_concepto" id="tipo_concepto_modal" require>
                        <option value="premio">Pago por Premio</option>
                        <option value="retiro">Retiro</option>
                        <option value="otro">Otro</option>
                    </select>


                    <label for="monto_modal" class="form-label" style="margin-top: 10px;">Monto transacción</label>
                    <input id="monto_modal" type="number" class="form-control" name="monto" placeholder="Monto transacción" require>
                    @include('alerts.feedback', ['field' => 'monto'])
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
