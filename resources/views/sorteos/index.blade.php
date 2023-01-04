@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Sorteos</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Sorteos del Sistema</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_sorteo" class="btn btn-success shadow-md mr-2" id="agregar_sorteo" title="Agregar Nuevo Sorteo"><i class="w-4 h-4" data-lucide="plus"></i></a>

        </div>
    </div>
    @include('sorteos.modals.new')
    @include('sorteos.modals.restrin')

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Logo</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">ID</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Nombre</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Hora</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Dias</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Estatus</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sorteos as $sorteo)
                        <tr>
                            <td class="text-center">
                                <div class="w-10 h-10 image-fit zoom-in text-center">
                                    <img class="tooltip rounded-full text-center" alt="TicoTiempos" src="{{ $sorteo->primera_foto }}">
                                </div>
                            </td>
                            <td>{{ $sorteo->id }}</td>
                            <td class="text-center">{{ $sorteo->nombre }}</td>
                            <td>{{ $sorteo->hora }}</td>
                            <td  class="text-center">
                                @foreach (json_decode($sorteo->dias) as $dias)
                                    @switch($dias)
                                        @case(1)
                                            Lunes -
                                        @break
                                        @case(2)
                                            Martes -
                                        @break
                                        @case(3)
                                            Miercoles -
                                        @break
                                        @case(4)
                                            Jueves -
                                        @break
                                        @case(5)
                                            Viernes -
                                        @break
                                        @case(6)
                                            Sabado -
                                        @break
                                        @case(7)
                                            Domingo -
                                        @break
                                    @endswitch
                                @endforeach
                            </td>
                            <td  class="text-center">
                                @if ($sorteo->estatus > 0)
                                    <div class="flex items-center justify-center text-success">Activo</div>
                                @else
                                    <div class="flex items-center justify-center text-danger">Inactivo</div>
                                @endif
                            </td>

                            <td  class="text-center">
                                <a href="{{ route('sorteos.edit', $sorteo->id ) }}" class="btn btn-primary shadow-md mr-2" title='Editar' id="editarSorteo"> <i class="w-4 h-4" data-lucide="edit"></i></a>
                               <!-- &nbsp;&nbsp;&nbsp;
                                <a href="{{ route('sorteos.delete', $sorteo->id ) }}" class="btn btn-danger shadow-md mr-2" title="Eliminar"><i class="w-4 h-4" data-lucide="trash-2"></i></a> -->
                                &nbsp;&nbsp;&nbsp;
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_restrincciones_sorteos" class="btn btn-warning shadow-md mr-2" title='Restrincciones' id="restrinccionesSorteo" data-id='{{ $sorteo->id }}'> <i class="w-4 h-4" data-lucide="eye-off"></i></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script type="text/javascript">
    $(document).ready(function () {

        $('body').on('click', '#restrinccionesSorteo', function (event) {

            event.preventDefault();
            var id = $(this).data('id');
            $('#sorteo_id').val(id);

            //console.log(id)
            $.get('sorteos-' + id + '-restrinccion', function (data) {
                //console.log(data);
                if ($.isEmptyObject(data.data)) {

                } else {

                    $('#config_id').val(data.data.id);
                    $('#restrinccion_numero').val(data.data.restrinccion_numero);
                    $('#restrinccion_monto').val(data.data.restrinccion_monto);
                }
            })
        });

        $('body').on('click', '#submit_restrinccion', function (event) {
            event.preventDefault()
            var id = $("#sorteo_id").val();

            var restrinccion_numero = $("#restrinccion_numero").val();
            var restrinccion_monto = $("#restrinccion_monto").val();
            $.get('sorteos-' + id + '-restrinccion', function (data) {
                //console.log(data);
                if ($.isEmptyObject(data.data)) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: 'restrinccion-store',
                        type: "POST",
                        data: {
                            idsorteo: id,
                            restrinccion_numero: restrinccion_numero,
                            restrinccion_monto: restrinccion_monto,
                        },
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data);
                            window.location.reload(true);
                        }
                    });
                } else {

                    var idconfig = $("#config_id").val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: 'sorteos-restrinccion-'+ id+ '-update',
                        type: "POST",
                        data: {
                            idsorteo: id,
                            config_id: idconfig,
                            restrinccion_numero: restrinccion_numero,
                            restrinccion_monto: restrinccion_monto,
                        },
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data);
                            window.location.reload(true);
                        }
                    });
                }
            })

        });

    });
    </script>
@endsection
@include('alerts.success')
@include('alerts.messages')
