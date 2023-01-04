    <!-- BEGIN: Add Item Modal -->
    <div id="generate-key-account" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form" method="post" action="{{ route('user.key', $users->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto" id='titulo_card_venta'>Ingrese su Codigo Unico</h2>
                    </div>
                    <div class="modal-body grid grid-cols-12">
                        <div class="col-span-12">
                            <label for="cod_unico" class="form-label">Codigo Unico para Desbloqueo</label>
                            <input id="cod_unico" type="password" name='cod_unico' class="form-control text-center" placeholder="Codigo Unico" require>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="w-4 h-4" data-lucide="save"></i>&nbsp; &nbsp;Generar Llave</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Add Item Modal -->
