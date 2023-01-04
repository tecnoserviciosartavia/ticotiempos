@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Canjear Sorteo</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('canjear.filtro') }}">
            @csrf
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    Numero del ticket
                    <input type="number" class="form-control w-48 box pr-6" placeholder="Id del ticket" name="ticket_id" value="{{ $ticket}}">
                </div>
                <div class="w-48 relative text-slate-500 ml-2">
                    Buscar:<br>
                    <button type="submit" class="btn btn-success w-48 xl:w-auto box ml-2">
                        <i class="w-4 h-4" data-lucide="search"></i>
                    </button>
                </div>
            </div>
        </form>
        <h2 class="text-lg font-medium mr-auto">Verificar si un boleto es premiado</h2>
        @if (sizeof($ganador) > 0)
            @if ($ganador[0]['estatus'] == 'abierto')
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <a href="{{ route('venta_detalle.imprimir', $traer_padre)}}" class="btn btn-warning shadow-md mr-2"> <i class="w-4 h-4" data-lucide="printer"></i> </a>
                </div>
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <a href="{{ route('venta_sorteo.edit', $traer_padre)}}" class="btn btn-primary shadow-md mr-2"> <i class="w-4 h-4" data-lucide="edit"></i> </a>
                </div>
            @endif
        @endif
        @if ($copiar > 0)
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('copiar.ticket', $traer_padre)}}" class="btn btn-primary shadow-md mr-2"> <i class="w-4 h-4" data-lucide="copy"></i> </a>
            </div>
        @endif
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Sorteo</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Paga</th>
                        <th class="whitespace-nowrap" style="text-align: center;">ID del Ticket</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Numero Jugado</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto Jugado</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">¿Es ganador?</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto Ganado</th>
                        <th class="whitespace-nowrap" style="text-align: center;">¿Fue Pagado?</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($ganador) > 0)
                        @foreach ($ganador as $ticket)
                            <tr>
                                <td>{{ $ticket['sorteo'] }}</td>
                                <td>{{ $ticket['paga'] }}</td>
                                <td>
                                    @if (is_null($ticket['jugada_padre']))
                                        {{ $ticket['id'] }}
                                    @else
                                        {{ $ticket['jugada_padre'] }}

                                    @endif
                                </td>
                                <td>{{ $ticket['numero'] }}</td>
                                <td>{{ $ticket['monto'] }}</td>
                                <td class="text-center">
                                    @if ($ticket['es_ganador'] > 0)
                                     <img src="{{ url('dist/images/sorteo-ganador-min.png')}}" alt="TicoTiempos" style="width: 120px;" class="text-center">
                                    @else
                                        Mas suerte la proxima Vez!
                                    @endif
                                </td>
                                <td>{{ $ticket['monto_ganador'] }}</td>
                                <td>
                                    @if ($ticket['fue_pagado'] > 0)
                                        <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Si</div>
                                    @else
                                        <div class="flex items-center justify-center text-danger"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> No</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($ticket['es_ganador'] > 0 && $ticket['fue_pagado'] == 0)
                                        <a href="{{ route('pagar.ticket', $ticket['id'] ) }}" class="btn btn-warning shadow-md mr-2" title="Pagar"><i class="w-4 h-4 " data-lucide="gift"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!--<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>-->
        </div>
    </div>
    <!-- END: HTML Table Data -->
@endsection
@include('alerts.success')
@include('alerts.messages')
