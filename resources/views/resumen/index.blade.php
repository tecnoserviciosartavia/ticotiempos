@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Resumen del Dia</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">
        Resumen Diarios del Sistema
    </h2>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('resumen.filtro') }}">
            @csrf
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    Desde:
                    <input type="date" class="form-control w-48 box pr-6" placeholder="Fecha Desde" name="fecha_desde" value="{{ $fecha_desde }}">
                </div>
                <div class="w-48 relative text-slate-500 ml-2">
                    Hasta:
                    <input type="date" class="form-control w-48 box pr-6" placeholder="Fecha Hasta" name="fecha_hasta" value="{{ $fecha_hasta }}">
                </div>

                <div class="w-48 relative text-slate-500 ml-2">
                    Buscar:<br>
                    <button type="submit" class="btn btn-success w-48 xl:w-auto box ml-2">
                        <i class="w-4 h-4" data-lucide="search"></i>
                    </button>
                </div>
            </div>
        </form>

        <h2 class="text-lg font-medium mr-auto"></h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        </div>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap" style="text-align: center;">Sorteo</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Fecha Sorteo</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Total Venta</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Numero Ganador</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    @foreach ($resumen as $detalle)
                        <tr>
                            <td class="text-center">
                                {{ $detalle['nombre'] }}
                            </td>
                            <td>
                                {{ $detalle['fecha'] }}
                            </td>
                            <td>
                                ₡ {{ $detalle['monto_venta'] }}
                            </td>
                            <td class="text-center">
                                @if (is_null($detalle['numero_ganador']))
                                    -- Aun Sin Cargar Resultados --
                                @else
                                    {{ $detalle['numero_ganador']}}
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_jugadas" class="btn btn-primary shadow-md mr-2" id="visualizar_jugadas" title="Visualizar Jugadas" data-id="{{ $detalle['id'] }}"><i class="w-4 h-4" data-lucide="bar-chart-2"></i></a>
                                @if ($detalle['numero_ganador'] !== NULL)
                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_ganadores" class="btn btn-warning shadow-md mr-2" id="ver_ganadores" title="Ver Ganadores" data-id="{{ $detalle['id'] }}"><i class="w-4 h-4" data-lucide="award"></i></a>
                                @endif
                            </td>
                        </tr>
                        <?php $total += $detalle['monto_venta']; ?>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><b>TOTAL</b> </td>
                        <td colspan="3">₡  {{ $total }}</td>
                    </tr>
                </tfoot>
            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@include('resumen.modals.jugadas')
@include('resumen.modals.ganadores')
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('click', '#ver_ganadores', function (event) {

                event.preventDefault();
                var id = $(this).data('id');

                $.get('resumen-' + id + '-ganadoras', function (data) {
                    //console.log(data);
                    var content_body = '';
                    var recorrido = data['success'];
                    $.each(recorrido, function(key, value) {

                        content_body += '<tr>';
                        content_body += '<td>'+data['success'][key].id+'</td>';
                        content_body += '<td> ₡ '+data['success'][key].monto+'</td>';
                        content_body += '<td> ₡ '+data['success'][key].monto_ganador+'</td>';

                    })
                    $('#recibido_ganadores_data tbody').html(content_body);
                })
            });
            $('body').on('click', '#visualizar_jugadas', function (event) {

                event.preventDefault();
                var id = $(this).data('id');
                $.get('resumen-' + id + '-jugadas', function (data) {
                    //console.log(data);
                    var content_body = '';
                    var recorrido = data['success'];
                    $.each(recorrido, function(key, value) {
                        content_body += '<tr>';
                        content_body += '<td>'+key+'</td>';
                        content_body += '<td>'+value+'</td>';
                    })
                    $('#recibido_data tbody').html(content_body);
                })
            });
        });
    </script>
@endsection
@include('alerts.success')
@include('alerts.messages')

