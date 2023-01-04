@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Venta Sorteos</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Venta Sorteo Diaria</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @if ($venta_cabecera[0]->traerJugadas(Auth::user()->id)->count() > 0)
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_jugadas" class="btn btn-success shadow-md mr-2">Jugadas</a>
            @endif
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
                        <div class="mt-2 mb-6">
                            <select data-placeholder="Selecciona un Cliente" class="tom-select w-full" id="cliente_seleccionado">
                                @foreach ( $clientes as $cliente)
                                    <option value="{{ $cliente->id }}"  {{ ($cliente->id == $venta_detalle[0]->idcliente ? 'selected="selected"' : '') }}>{{ $cliente->num_id }} - {{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- END: Basic Select -->
                </div>
            </div>
        </div>

        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t">
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#edit-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3" data-id="{{ $venta_cabecera[0]->id }}" data-detalle="{{ $venta_detalle[0]->id }}" data-reventado="{{ $venta_cabecera[0]->es_reventado }}" id="seleccion_sorteo">
                        <div class="box rounded-md p-3 relative zoom-in">
                            <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                <div class="absolute top-0 left-0 w-full h-full image-fit">
                                    @if (is_null($venta_cabecera[0]->logo))
                                        <img class="rounded-full" alt="Tiempos Darwins" src="{{ asset('dist/images/logos/LOGODkk.png') }}">
                                    @else
                                        <img class="rounded-full" alt="Tiempos Darwins" src="{{ asset('dist/images/sorteos/'.$venta_cabecera[0]->logo) }}">

                                    @endif
                                </div>
                            </div>
                            <div class="block font-medium text-center truncate mt-3">{{ $venta_cabecera[0]->nombre }}</div>
                            <div class="block font-medium text-center truncate mt-3">{{ $venta_cabecera[0]->fecha }} - {{ $venta_cabecera[0]->hora }}</div>
                        </div>
                    </a>
            </div>
        </div>
        <!-- END: Item List -->
        <!-- BEGIN: Ticket -->
        <?php
            $date = \Carbon\Carbon::now()->addMinutes(10);
            $hour_date = \Carbon\Carbon::parse($venta_cabecera[0]->hora);
        ?>
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
                            >Cierra en: <div class="counter" style='color: white;'>
                                    <span class='e-m-days' style="display: none;">0</span>
                                    <span class='e-m-hours'>0</span> Hr |
                                    <span class='e-m-minutes'><?php echo $date->diffInMinutes($hour_date); ?></span> Min |
                                    <span class='e-m-seconds'>59</span> Seg
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                    <div class="box p-2 mt-5">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Numero</th>
                                    <th style="text-align: center;">Monto</th>
                                    <th style="text-align: center;">Monto Reventado</th>
                                    <th style="text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                                <?php $total = 0; ?>
                            <tbody>
                                @foreach ($venta_detalle as $detalle)
                                    <tr>
                                        <td>{{ str_pad($detalle->numero, 2, "0", STR_PAD_LEFT) }}</td>
                                        <td>₡ {{ $detalle->monto}}</td>
                                        <td>₡ {{ $detalle->monto_reventado}}</td>
                                        <td>
                                            <a href="javascript:;" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md" id="eliminarDetalle" data-id="{{ $detalle->id }}">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $total += $detalle->monto + $detalle->monto_reventado; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="box p-5 mt-5">
                        <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                            <div class="mr-auto font-medium text-base">Total</div>
                            <div class="font-medium text-base">₡ <?php echo $total; ?></div>
                        </div>
                    </div>
                    <div class="flex mt-5">
                        <button class="btn btn-primary w-32 shadow-md ml-auto" id="guardarImprimir"><i class="w-4 h-4" data-lucide="printer"></i>&nbsp; &nbsp;Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Ticket -->
    </div>

@include('venta.agente.modals.edit')
@include('venta.agente.modals.new_cliente')
@include('venta.agente.modals.restrincciones')
@include('venta.agente.modals.jugadas')

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="{{ asset('dist/js/countdown.jquery.js') }}"></script>

    <script type="text/javascript">

    $(document).ready(function () {

        $('body').on('click', '#seleccion_sorteo', function (event) {

            event.preventDefault();
            var id = $(this).data('id');
            var padre_id = $(this).data('detalle');
            var reventado = $(this).data('reventado');

            var idcliente =  $('#cliente_seleccionado').val();
            $('#cabecera_id').val(id);
            $('#cliente_id').val(idcliente);
            $('#padre_id').val(padre_id);

            if (reventado > 0) {
                $('#check_modal_reventado').attr("style", "display:block")
            } else {
                $('#check_modal_reventado').attr("style", "display:none")
            }

        });

        $('body').on('click', '#agregarJugadaedit', function (event) {
            event.preventDefault();

            var cabecera_id = $("#cabecera_id").val();
            var padre_id = $("#padre_id").val();
            var cliente_id = $("#cliente_id").val();
            var numero = $("#pos-edit-form-4").val();
            var monto = $("#pos-edit-form-5").val();
            var reventado = $("#pos-form-6").val();
            var monto_reventado = $("#pos-form-7").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'venta-padre-'+ padre_id+ '-edit',
                type: "POST",
                data: {
                    cabecera_id: cabecera_id,
                    cliente_id: cliente_id,
                    numero: numero,
                    monto: monto,
                    reventado: reventado,
                    monto_reventado: monto_reventado,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    window.location.reload(true);
                }
            });
        });

        $('body').on('click', '#guardarImprimir', function (event) {
            event.preventDefault();
            var jsvar = {!! json_encode($venta_detalle) !!};

            var id = jsvar[0].id;
            var idcliente = $('#cliente_seleccionado').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'venta-padre-'+ id+ '-update',
                type: "POST",
                data: {
                    cliente_id: idcliente,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    if (data['success'] == true) {
                        //window.location.reload(true);
                        window.location = data.redirect;

                    }
                }
            });
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
                        $('#form_action').val(1);
                        var venta_detalle_js = {!! json_encode($venta_detalle) !!};
                        var padre_id = venta_detalle_js[0].id;
                        $('#padre_id_edit_modal').val(padre_id);
                    }
                },
                error:function(response){
                    alert('Identificación No Encontrada');
                    $('#modal-form-2').val('');
                    $('#form_action').val('');

                }
            });
        });

        $('body').on('change', '#cliente_seleccionado', function (event) {
            event.preventDefault();
            var id = $(this).val();
            var venta_detalle_js = {!! json_encode($venta_detalle) !!};
            var padre_id = venta_detalle_js[0].id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'venta-cambiar-cliente',
                type: "POST",
                data: {
                    cliente_id: id,
                    padre_id: padre_id,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    if (data['success'] == true) {
                        window.location.reload(true);
                    }
                }
            });
        });
        $('body').on('click', '#eliminarDetalle', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'venta-eliminar-'+ id+ '-detalle',
                type: "POST",
                data: {
                    iddetalle: id,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    if (data['success'] == true) {

                        if (data['delete_father'] == true) {

                            window.location = data.redirect;
                        } else {

                            window.location.reload(true);
                        }
                    }
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
    $(function() {
        function getCounterData(obj) {
            var days = parseInt($('.e-m-days', obj).text());
            var hours = parseInt($('.e-m-hours', obj).text());
            var minutes = parseInt($('.e-m-minutes', obj).text());
            var seconds = parseInt($('.e-m-seconds', obj).text());
            return seconds + (minutes * 60) + (hours * 3600) + (days * 3600 * 24);
        }

        function setCounterData(s, obj) {
            var days = Math.floor(s / (3600 * 24));
            var hours = Math.floor((s % (60 * 60 * 24)) / (3600));
            var minutes = Math.floor((s % (60 * 60)) / 60);
            var seconds = Math.floor(s % 60);

            //console.log(days, hours, minutes, seconds);

            $('.e-m-days', obj).html(days);
            $('.e-m-hours', obj).html(hours);
            $('.e-m-minutes', obj).html(minutes);
            $('.e-m-seconds', obj).html(seconds);
        }

        function cerrarJuego(){
            $.get('cerrar-juegos-hoy', function (data) {
                //console.log(data)
                window.location.href = "{{ route('venta_sorteo.create')}}";
            })
        }
        var count = getCounterData($(".counter"));

        var timer = setInterval(function() {
            count--;
            if (count == 0) {
                cerrarJuego();
                clearInterval(timer);
                return;
            }
            setCounterData(count, $(".counter"));
        }, 1000);
    });

    </script>


@endsection
@include('alerts.success')
@include('alerts.messages')
