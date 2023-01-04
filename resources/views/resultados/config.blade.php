@extends('../layout/' . $layout)

@section('subhead')
    <head>
        <link rel="stylesheet" href="{{ asset('dist') }}/farbtastic.css" type="text/css" />
    </head>
    <title>TicoTiempos - Configuracion de Resultados</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Configuracion de Resultados</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_config_resultado" class="btn btn-success shadow-md mr-2" id="agregar_nueva_config_resultado" title="Agregar Nueva Configuracion de  Resultado"><i class="w-4 h-4" data-lucide="plus"></i></a>

        </div>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap" style="text-align: center;">ID</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Descripcion / Letra</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Color</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Paga</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ( $resultados_parametros as $parametro)
                        <tr>
                            <td> {{ $parametro->id }}</td>
                            <td> {{ $parametro->descripcion }}</td>
                            <td> {{ $parametro->color }}</td>
                            <td> {{ $parametro->paga_resultado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@include('resultados.modals.new_config')

@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('dist') }}/farbtastic.js"></script>
<script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#picker').farbtastic('#color');
            });
        </script>
@endsection
@include('alerts.success')
@include('alerts.messages')
