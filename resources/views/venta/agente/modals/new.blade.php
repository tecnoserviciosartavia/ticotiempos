    <!-- BEGIN: Add Item Modal -->
    <div id="add-item-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form" method="post" action="{{ route('venta_sorteo.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto" id='titulo_card_venta'>Informacion de Jugada</h2>
                    </div>
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12">
                            <label for="pos-form-5" class="form-label" style="margin-right: 11px;">Monto</label>
                            <input id="pos-form-5" name='monto' type="number" class="form-control w-60 ml-6 text-center" placeholder="Monto" value="" require>
                        </div>
                        <div class="col-span-12">
                            <label for="pos-form-4" class="form-label">Numero</label>
                            <input id="pos-form-4" type="text" name='numero' class="form-control w-60 ml-6 text-center" placeholder="Numero" value="" min='0' max='99' require>
                        </div>
                        <div class="col-span-12" id='monto_reventado_modal' style="display: none;">
                            <label for="pos-form-7" class="form-label">Monto Reventado</label>
                            <input id="pos-form-7" name='monto_reventado' type="number" class="form-control w-60 ml-6 text-center" placeholder="Monto Reventado" value="">
                        </div>
                        <div class="col-span-12" id='check_modal_reventado'  style="display: none;">
                            <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                                <div class="flex items-center mr-auto">
                                    <label for="pos-form-6" class="form-label">¿Es Reventado?</label><br>
                                    <input id="pos-form-6" type="checkbox" class="form-check-input w-8 ml-6 text-center" name='reventado'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="cabecera_id" name="cabecera_id" value="">
                    <input type="hidden" id="cliente_id" name="cliente_id" value="">

                    <div class="modal-footer text-right">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                        <button type="submit" class="btn btn-primary" id='agregarJugada'><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Add Item Modal -->
