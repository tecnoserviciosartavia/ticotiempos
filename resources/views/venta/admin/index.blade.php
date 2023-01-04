@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Sorteos</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Juegos para Hoy</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('juegos.abrir') }}" class="btn btn-warning shadow-md mr-2" id="ejecutar_inicio" title="Abrir todos los juegos para hoy">Abrir todos los juegos</a>
            <a href="{{ route('juegos.cerrar') }}" class="btn btn-danger shadow-md mr-2" id="ejecutar_cerrado" title="Cerrar todos los juegos">Cerrar todos los juegos</a>

        </div>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data1">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap" style="text-align: center;">ID</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Nombre Sorteo</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Hora/Fecha</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Cierra Antes</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto Venta</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta_cabecera as $venta)
                        <tr>
                            <td class="text-center">{{ $venta->id }}</td>
                            <td class="text-center">{{ $venta->nombre }}</td>
                            <td class="text-center">{{ $venta->fecha }} {{ $venta->hora }}</td>
                            <td class="text-center">{{ $venta->cierra_antes }} Minutos</td>
                            <td class="text-right">₡ {{ $venta->monto_venta }}</td>
                            <td class="text-center">
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_jugadas" class="btn btn-primary shadow-md mr-2" id="visualizar_jugadas" title="Visualizar Jugadas" data-id="{{ $venta->id  }}"><i class="w-4 h-4" data-lucide="bar-chart-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@endsection
@include('venta.admin.modals.jugadas')

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#recibido_data1').DataTable({
                order: [[2, 'asc']],
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
                    $('#recibido_modal_data tbody').html(content_body);
                })
            });
        });
    </script>
@endsection
@include('alerts.success')
@include('alerts.messages')
