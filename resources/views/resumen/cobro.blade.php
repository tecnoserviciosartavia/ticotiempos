@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Reporte de Cobro</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">
        Reporte de Cobro del Sistema
    </h2>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('cobro.filtro') }}">
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
                @if (Auth::user()->es_administrador > 0)

                    <div class="w-48 relative text-slate-500 ml-2">Usuario:
                        <select class="form-select" aria-label=".form-select-lg example" name="usuarios" id="usuarios_filter">
                            <option value="all"  {{ ($usuario_seleccionado == 'all' ? 'selected="selected"' : '') }}>-- Todos los Usuarios --</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ ($usuario_seleccionado == $usuario->id ? 'selected="selected"' : '') }}>{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
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
                        <th class="whitespace-nowrap" style="text-align: center;">Hora Sorteo</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Importe</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Comisión</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Premio</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $comision_total = 0;
                    $importe_total = 0;
                    $premios_total = 0;
                    ?>
                    @foreach ($resumen as $detalle)
                        <tr>
                            <td>
                                {{ $detalle['nombre_sorteo'] }}
                            </td>
                            <td>
                                {{ $detalle['fecha_sorteo']  }}
                            </td>
                            <td>
                                {{ $detalle['hora_sorteo']  }}
                            </td>
                            <td>
                                ₡ {{ $detalle['importe'] }}
                            </td>
                            <td>
                                ₡ {{ $detalle['comision'] }}
                            </td>
                            <td>
                                ₡ {{ $detalle['premio'] }}
                            </td>
                            <td>
                                ₡ {{ $detalle['balance'] }}
                            </td>
                        </tr>
                        <?php
                            $total += $detalle['balance'];
                            $comision_total += $detalle['comision'];
                            $importe_total += $detalle['importe'];
                            $premios_total += $detalle['premio'];
                        ?>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td>Total Importe: ₡ {{ $importe_total }}</td>
                        <td>Total Comision: ₡ {{ $comision_total }}</td>
                        <td>Total Premios: ₡ {{ $premios_total }}</td>
                        <td>Total Balance: ₡ {{ $total }}</td>
                        <td></td>
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

