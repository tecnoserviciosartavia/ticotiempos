    <!-- BEGIN: Add Item Modal -->
    <div id="modal_restringidos" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id='titulo_card_venta'>Restrincciones de Sorteo</h2>
                </div>
                <div class="modal-body p-10 text-center">
                    <table class="table table-bordered table-hover" id="recibido_data">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap" style="text-align: center;">Sorteo</th>
                                <th class="whitespace-nowrap" style="text-align: center;">Numero</th>
                                <th class="whitespace-nowrap" style="text-align: center;">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venta_cabecera as $venta)
                                <tr>
                                    <td>{{ $venta->nombre}}</td>
                                    <td>{{ $venta->restrinccion_numero}}</td>
                                    <td>{{ $venta->restrinccion_monto}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary mr-1"><i class="w-4 h-4" data-lucide="x"></i>&nbsp; &nbsp;Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Add Item Modal -->
