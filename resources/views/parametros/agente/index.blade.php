@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Mis Parametros</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Parametros de Sorteos por Usuario</h2>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Sorteo</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Paga</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Comisión</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Devolución</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto Arranque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parametros as $parametro)
                        <tr>
                            <td>{{ $parametro->parametros_sorteos->nombre }}</td>
                            <td>{{ $parametro->paga }}</td>
                            <td>{{ $parametro->comision }}</td>
                            <td>{{ $parametro->devolucion }}</td>
                            <td>{{ $parametro->monto_arranque }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@endsection
