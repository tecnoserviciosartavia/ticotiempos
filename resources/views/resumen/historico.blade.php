@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Historico de Jugadas</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">
        Historico de Jugadas del Sistema
    </h2>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('filtro.historico') }}">
            @csrf
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    Desde:
                    <input type="date" class="form-control w-48 box pr-6" placeholder="Fecha Desde" name="fecha_desde" value="{{ $fecha_desde }}">
                </div>
                <div class="w-48 relative text-slate-500 ml-2">
                    Sorteos:
                    <select data-placeholder="Selecciona un Cliente" class="tom-select w-full" name="idsorteo" id="cliente_seleccionado">
                        @foreach ( $sorteos as $sorteo)

                            @if (!is_null($sorteo_seleccionado))

                                <option value="{{ $sorteo->id }}" {{ ($sorteo->id == $sorteo_seleccionado->id ? 'selected="selected"' : '') }}>{{ $sorteo->nombre }}</option>
                            @else

                                <option value="{{ $sorteo->id }}" >{{ $sorteo->nombre }}</option>
                            @endif
                        @endforeach
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
                        <th class="whitespace-nowrap" style="text-align: center;">Numero</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;
                    ?>
                    @foreach ( $historico as $key => $value )
                        <tr>
                            <td>
                                @if (!is_null($sorteo_seleccionado))
                                {{ $sorteo_seleccionado->nombre }}
                                @endif
                            </td>
                            <td>
                                {{ $fecha_desde }}
                            </td>
                            <td>
                                {{ $key }}
                            </td>
                            <td>
                                ₡ {{ $value}}
                            </td>
                        </tr>
                        <?php $total += $value; ?>
                    @endforeach
                </tbody>
                <tfoot>

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

