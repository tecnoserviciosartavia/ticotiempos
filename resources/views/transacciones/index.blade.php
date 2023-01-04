@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Transacciones</title>

@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('transacciones.filtro') }}">
            @csrf
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    Fecha:
                    <input type="date" class="form-control w-48 box pr-6" placeholder="Fecha Desde" name="fecha_desde" value="{{ $fecha_desde }}">
                </div>
                <div class="w-48 relative text-slate-500 ml-2">
                    Tipo de Concepto:
                    <select class="form-select" aria-label=".form-select-lg example" name="tipo_concepto" id="tipo_concepto">
                        <option value="all" {{ ($tipo_concepto == 'all' ? 'selected="selected"' : '') }}>-- Todos los Conceptos --</option>
                        <option value="venta" {{ ($tipo_concepto == 'venta' ? 'selected="selected"' : '') }}>Venta por Usuario</option>
                        <option value="comision" {{ ($tipo_concepto == 'comision' ? 'selected="selected"' : '') }}>Comision de Usuario</option>
                        <option value="premio" {{ ($tipo_concepto == 'premio' ? 'selected="selected"' : '') }}>Premio Obtenido</option>
                        <option value="retiro" {{ ($tipo_concepto == 'retiro' ? 'selected="selected"' : '') }}>Retiro a Usuario</option>
                        <option value="otro" {{ ($tipo_concepto == 'otro' ? 'selected="selected"' : '') }}>Otro Concepto</option>

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
        <h2 class="text-lg font-medium mr-auto">Transacciones Diarias del Sistema</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <!--<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_transaccion" class="btn btn-success shadow-md mr-2" id="agregar_transaccion"><i class="w-4 h-4" data-lucide="plus"></i></a>-->

        </div>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap" style="text-align: center;">Usuario</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Monto</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Detalle de Transacción</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Tipo de Operacion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transacciones as $transaccion)
                        <?php
                            $padre = $transaccion->buscarPadre();
                        ?>
                        <tr>
                            <td style="text-align: center;">{{ $transaccion->usuarios->name }}</td>
                            <td>₡ {{ $transaccion->monto }}</td>
                            <td style="text-align: center;">{{ $transaccion->concepto }}</td>
                            <td style="text-align: center;">
                                @switch($transaccion->tipo_concepto)
                                    @case('venta')
                                        <a href="javascript:;" class="btn btn-success shadow-md mr-2 my-modal" data-tw-toggle="modal" data-tw-target="#modal_ticket_impresion"  data-id="{{ $padre}}"><i class="w-4 h-4 mr-2" data-lucide="plus"></i>Venta</a>
                                    @break
                                    @case('comision')
                                        <a href="javascript:;" class="btn btn-primary shadow-md mr-2 my-modal" data-tw-toggle="modal" data-tw-target="#modal_ticket_impresion"  data-id="{{ $padre}}"><i class="w-4 h-4 mr-2" data-lucide="gift"></i>Comision</a>
                                    @break
                                    @case('premio')
                                        <a href="javascript:;" class="btn btn-warning shadow-md mr-2 my-modal" data-tw-toggle="modal" data-tw-target="#modal_ticket_impresion"  data-id="{{ $padre}}"><i class="w-4 h-4 mr-2" data-lucide="dollar-sign"></i>Premio</a>
                                    @break
                                    @case('retiro')
                                        <a href="javascript:;" class="btn btn-danger shadow-md mr-2"><i class="w-4 h-4 mr-2" data-lucide="minus"></i>Retiro</a>
                                    @break
                                    @case('otro')
                                        <a href="javascript:;" class="btn btn-black shadow-md mr-2"><i class="w-4 h-4 mr-2" data-lucide="alert-circle"></i>Otro</a>
                                    @break
                                @endswitch
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
    @include('transacciones.modals.new')
    @include('transacciones.modals.ticket')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').on('click', '.my-modal', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                $.get('json-' + id + '-imprimir', function (data) {
                    console.log(data.success);
                    $('#mostrarTicket').html(data.success);
                })
            });
        });
    </script>
@endsection
