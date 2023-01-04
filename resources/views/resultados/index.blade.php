@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Resultados</title>
    <style>
        .dot {
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
@endsection

@section('subcontent')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('resultado.filtro') }}">
            @csrf
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    Desde:
                    <input type="date" class="form-control w-48 box pr-6" placeholder="Fecha Desde" name="fecha_desde" value="{{ $fecha_desde }}">
                </div>
                <div class="w-48 relative text-slate-500 ml-2">
                    Estatus:
                    <select class="form-select" aria-label=".form-select-lg example" name="estatus" id="estatus_filter">
                        <option value="all" {{ ($estatus == 'all' ? 'selected="selected"' : '') }}>-- Todos los Estatus --</option>
                        <option value="abierto" {{ ($estatus == 'abierto' ? 'selected="selected"' : '') }}>Abierto</option>
                        <option value="cerrado" {{ ($estatus == 'cerrado' ? 'selected="selected"' : '') }}>Cerrado</option>
                        <option value="calculado" {{ ($estatus == 'calculado' ? 'selected="selected"' : '') }}>Calculado</option>
                        <option value="finalizado" {{ ($estatus == 'finalizado' ? 'selected="selected"' : '') }}>Finalizado</option>
                    </select>
                </div>
                <div class="w-48 relative text-slate-500 ml-2">
                    Buscar:<br>
                    <button type="submit" class="btn btn-success w-48 xl:w-auto box ml-2">
                        <i class="w-4 h-4" data-lucide="search"></i>
                    </button>
                </div>
            </div>
        </form>

        <h2 class="text-lg font-medium mr-auto">Resultados del Sistema</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('resultados.parameters') }}" class="btn btn-primary shadow-md mr-2" id="agregar_sorteo" title="Agregar Nuevo Sorteo"><i class="w-4 h-4" data-lucide="settings"></i></a>

        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap" style="text-align: center;">ID</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Sorteo</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Fecha - Hora</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto Venta</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Numero Ganador</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Adicional</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Estatus</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ( $venta_cabecera as $venta)

                        <tr>
                            <td> {{ $venta->id }}</td>
                            <td class="text-center"> {{ $venta->sorteos->nombre }}</td>
                            <td class="text-center"> {{ $venta->fecha }} {{ $venta->hora }}</td>
                            <td> {{ $venta->monto_venta }}</td>
                            <td> {{ $venta->numero_ganador }}</td>

                            <td class="text-center">
                                @if ( !is_null($venta->adicional_ganador))
                                    <span class="dot" style="background-color: <?php echo $venta->parameter_res->color; ?>;">
                                        <p style="padding: 2px; margin-left: 6px;">{{ $venta->parameter_res->descripcion }}</p>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @switch($venta->estatus)
                                    @case('cerrado')
                                        <a href="javascript:;" class="btn btn-danger shadow-md mr-2">
                                    @break
                                    @case('abierto')
                                        <a href="javascript:;" class="btn btn-primary shadow-md mr-2">
                                    @break
                                    @case('finalizado')
                                        <a href="javascript:;" class="btn btn-success shadow-md mr-2">
                                    @break
                                    @case('calculado')
                                        <a href="javascript:;" class="btn btn-warning shadow-md mr-2">
                                    @break
                                @endswitch
                                    <i class="w-4 h-4 mr-2" data-lucide="minus"></i> {{ $venta->estatus }}
                                </a>
                            </td>
                            <td class="text-center">
                                @if ($venta->estatus == 'cerrado')
                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_resultado" class="btn btn-success shadow-md mr-2" id="agregar_nuevo_resultado" title="Agregar Nuevo Resultado" data-id="{{ $venta->id }}"><i class="w-4 h-4" data-lucide="plus"></i></a>
                                @endif
                                @if ($venta->estatus == 'finalizado')
                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_edit_resultado" class="btn btn-warning shadow-md mr-2" id="editar_resultado" title="Editar Resultado" data-id="{{ $venta->id }}"><i class="w-4 h-4" data-lucide="edit"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@include('resultados.modals.new')
@include('resultados.modals.edit')

@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $(document).on("click", "#agregar_nuevo_resultado" , function(event) {
                    event.preventDefault();
                    var idventa_cabecera = $(this).data('id');
                    $('#idventacabecera_modal').val(idventa_cabecera);
                });
                $(document).on("click", "#editar_resultado" , function(event) {
                    event.preventDefault();
                    var idventa_cabecera = $(this).data('id');
                    $('#idventacabecera_edit_modal').val(idventa_cabecera);
                });

                $(document).on("click", "#updateResult" , function(event) {
                    event.preventDefault();
                    var idventa_cabecera  = $('#idventacabecera_edit_modal').val();
                    var adicional_ganador = $('#adicional_ganador_edit').val();
                    var numero_ganador    = $('#numero_ganador_edit').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: 'resultados-update',
                        type: "POST",
                        data: {
                            idventa_cabecera: idventa_cabecera,
                            adicional_ganador: adicional_ganador,
                            numero_ganador: numero_ganador,
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
            });
        </script>
@endsection
@include('alerts.success')
@include('alerts.messages')
