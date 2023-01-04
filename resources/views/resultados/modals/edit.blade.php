<!-- BEGIN: Super Large Modal Content -->

<div id="modal_edit_resultado" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Editar Resultado</h2>
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
                    <label for="numero_ganador_edit" class="form-label">Numero Ganador</label>
                    <input id="numero_ganador_edit" type="number" class="form-control" placeholder="Numero Ganador" name="numero_ganador_edit">
                    @include('alerts.feedback', ['field' => 'numero_ganador_edit'])
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="adicional_ganador_edit" class="form-label">Adicional</label>
                    <select id="adicional_ganador_edit" data-search="true" class="form-select form-select-lg" name="adicional_ganador_edit">
                        @foreach ($resultados_parametros as $parametros)
                            <option value="{{ $parametros->id }}" style="background-color: <?php echo $parametros->color; ?>;">
                                {{ $parametros->descripcion }} - Paga: {{ $parametros->paga_resultado }}
                            </option>
                        @endforeach
                    </select>
                    @include('alerts.feedback', ['field' => 'adicional_ganador_edit'])
                </div>
            </div>
            <input id="idventacabecera_edit_modal" type="number" class="form-control" name="idventacabecera_edit_modal" hidden>

            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                <button type="Submit" class="btn btn-primary" id='updateResult'><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
        </form>
    </div>
</div>

<!-- END: Super Large Modal Content -->
