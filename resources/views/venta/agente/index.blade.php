@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Venta Sorteos</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Venta Sorteo Diaria</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_restringidos" class="btn btn-warning shadow-md mr-2">Restringidos</a>
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_cliente" class="btn btn-primary shadow-md mr-2">Nuevo Cliente</a>
        </div>
    </div>
    <div class="intro-y grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Item List -->
        <div class="intro-y col-span-12 lg:col-span-2">
            <div class="intro-y">
                <div class="relative">
                    <!-- BEGIN: Basic Select -->
                    <div>
                        <label>Cliente de Juego</label>
                        <div class="mt-2">
                            <select data-placeholder="Selecciona un Cliente" class="tom-select w-full" id="cliente_seleccionado">
                                @foreach ( $clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->num_id }} - {{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- END: Basic Select -->
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t">
                @foreach ($venta_cabecera as $venta)
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3" data-id="{{ $venta->id }}" data-reventado="{{ $venta->es_reventado }}" id="seleccion_sorteo">
                        <div class="box rounded-md p-3 relative zoom-in">
                            <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                <div class="absolute top-0 left-0 w-full h-full image-fit">
                                    <img class="rounded-full" alt="TicoTiempos" src="{{ $venta->sorteos->primera_foto }}">
                                </div>
                            </div>
                            <div class="block font-medium text-center truncate mt-3">{{ $venta->nombre }}</div>
                            <div class="block font-medium text-center truncate mt-3">{{ $venta->fecha }} - {{ $venta->hora }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <!-- END: Item List -->
        <!-- BEGIN: Ticket -->
        <div class="col-span-12 lg:col-span-4">
            <div class="intro-y pr-1">
                <div class="box p-2">
                    <ul class="nav nav-pills" role="tablist">
                        <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                            <button
                                class="nav-link w-full py-2 active"
                                data-tw-toggle="pill"
                                data-tw-target="#ticket"
                                type="button"
                                role="tab"
                                aria-controls="ticket"
                                aria-selected="true"
                            >
                                Ticket
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                    <div class="box p-2 mt-5">

                    </div>

                    <div class="box p-5 mt-5">

                        <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                            <div class="mr-auto font-medium text-base">Total Charge</div>
                            <div class="font-medium text-base">₡ 0.00000</div>
                        </div>
                    </div>
                    <div class="flex mt-5">
                    </div>
                </div>

            </div>
        </div>
        <!-- END: Ticket -->
    </div>

@include('venta.agente.modals.new')
@include('venta.agente.modals.new_cliente')
@include('venta.agente.modals.restrincciones')
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $(document).ready(function () {

        $('body').on('click', '#seleccion_sorteo', function (event) {

            event.preventDefault();
            var id = $(this).data('id');
            var reventado = $(this).data('reventado');

            var idcliente =  $('#cliente_seleccionado').val();
            $('#cabecera_id').val(id);
            $('#cliente_id').val(idcliente);
            if (reventado > 0) {
                $('#check_modal_reventado').attr("style", "display:block")
            } else {
                $('#check_modal_reventado').attr("style", "display:none")
            }

        });

        $(document).on("blur", "#modal-form-1" , function(event) {
            var id = $(this).val();
            var URL = 'https://apis.gometa.org/cedulas/' + id;
            $.ajax({
                type:'GET',
                url: URL,
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    if (typeof response =='object') {
                        $('#modal-form-2').val(response.nombre);
                        $('#form_action').val(0);
                    }
                },
                error:function(response){
                    alert('Identificación No Encontrada');
                    $('#modal-form-2').val('');
                }
            });
        });

        $('body').on('change', '#pos-form-6', function (event) {
            event.preventDefault();
            if ($(this).is(":checked")) {
                $('#monto_reventado_modal').attr("style", "display:block")
            } else {
                $('#monto_reventado_modal').attr("style", "display:none")
            }
        });

    });
    </script>
@endsection
@include('alerts.success')
@include('alerts.messages')
