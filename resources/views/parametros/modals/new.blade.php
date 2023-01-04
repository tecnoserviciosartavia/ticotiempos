<!-- BEGIN: Super Large Modal Content -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="form" method="post" action="{{ route('parameter.create') }}">
        @csrf
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <i class="w-4 h-4" data-lucide="plus"></i>&nbsp; &nbsp;
                <h2 class="font-medium text-base mr-auto">Agregar Nuevo parametro</h2>
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
                    <label for="modal-edit-form-4" class="form-label">Seleccionar Sorteo</label>
                    <select class="form-select sm:mt-2 sm:mr-2" aria-label=".form-select-lg example" name="idsorteo" id="modal-edit-form-4">
                        <option value="0">-- Selecciona un Sorteo --</option>
                        @foreach($sorteos as $sorteo)
                            <option value="{{ $sorteo->id }}">{{ $sorteo->nombre }}</option>
                        @endforeach
                    </select>
                    @include('alerts.feedback', ['field' => 'idsorteo'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="idsuario" class="form-label">Usuario</label>
                    <select class="form-select sm:mt-2 sm:mr-2" name="idusuario" id="idusuario">
                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                    </select>
                    @include('alerts.feedback', ['field' => 'idusuario'])
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
                    <label for="modal-form-5" class="form-label">Devolucion</label>
                    <input id="modal-form-5" type="number" class="form-control" placeholder="Numerico" name="devolucion">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-6" class="form-label">Monto Limite por Numero</label>
                    <input id="modal-form-6" type="number" class="form-control" placeholder="Numerico" name="monto_arranque">
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
