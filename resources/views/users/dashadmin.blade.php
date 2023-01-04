@extends('../layout/' . $layout)

@section('subhead')
    <title>Principal - Sistema de Tiempos</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <form class="form" method="post" action="{{ route('dashadmin.filtro') }}">
                            @csrf
                            <div class="flex w-full sm:w-auto">
                                <div class="w-48 relative text-slate-500 ml-2">Usuario:
                                    <select class="form-select" aria-label=".form-select-lg example" name="usuarios" id="usuarios_filter">
                                        <option value="all"  {{ ($usuario_seleccionado == 'all' ? 'selected="selected"' : '') }}>-- Todos los Usuarios --</option>
                                        @foreach ($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}" {{ ($usuario_seleccionado == $usuario->id ? 'selected="selected"' : '') }}>{{ $usuario->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-48 relative text-slate-500 ml-2">Sorteo:
                                    <select class="form-select" aria-label=".form-select-lg example" name="sorteos" id="sorteos_filter">
                                        <option value="all" {{ ($sorteo_seleccionado == 'all' ? 'selected="selected"' : '') }}>-- Todos los Sorteos --</option>
                                        @foreach ($sorteos as $sorteo)
                                            <option value="{{ $sorteo->id }}" {{ ($sorteo_seleccionado == $sorteo->id ? 'selected="selected"' : '') }}>{{ $sorteo->nombre }}</option>
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
                        <h2 class="text-lg font-medium truncate mr-5">Reporte General</h2>
                        <a href="{{ route('dashboard.admin')}}" class="ml-auto flex items-center text-primary">
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Refrescar
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                        <div class="ml-auto">
                                             @if ($jugadas > 0)
                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month">
                                                {{ $jugadas }} <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                                </div>
                                            @else
                                                <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="2% Lower than last month">
                                                {{ $jugadas }} <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">₡ {{ $jugadas}}</div>
                                    <div class="text-base text-slate-500 mt-1">Total Monto Apostado</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                        <div class="ml-auto">
                                            @if ($ganadores > 0)
                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month">
                                                {{ $ganadores }} <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                                </div>
                                            @else
                                                <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="2% Lower than last month">
                                                {{ $ganadores }} <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">₡ {{ $ganadores }} </div>
                                    <div class="text-base text-slate-500 mt-1">Total Ganadores</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                        <div class="ml-auto">

                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        @if ($sorteo_seleccionado == 'all')
                                            Activos
                                        @else
                                            @if ($estatus == 1)
                                                Activo
                                            @else
                                                Inactivo
                                            @endif
                                        @endif
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Estatus Sorteo</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="user" class="report-box__icon text-success"></i>
                                        <div class="ml-auto">

                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $tickets_apostados }}</div>
                                    <div class="text-base text-slate-500 mt-1">Tiquetes Jugados</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Ultimas ventas concretadas</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <a href="{{ route('juegos.index')}}" class="btn box flex items-center text-slate-600 dark:text-slate-300"> <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Ver Mas </a>
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap" style="text-align: center;">Sorteo</th>
                                    <th class="whitespace-nowrap" style="text-align: center;">Fecha/Hora</th>
                                    <th class="text-center whitespace-nowrap" style="text-align: center;">Jugada</th>
                                    <th class="text-center whitespace-nowrap" style="text-align: center;">Monto</th>
                                    <th class="text-center whitespace-nowrap" style="text-align: center;">Reventado</th>
                                    <th class="text-center whitespace-nowrap" style="text-align: center;">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($ultimas_ventas->count() == 0)
                                    <tr>
                                        <td colspan="5">
                                            <h2 class="text-center">No existen Transacciones al momento!</h2>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($ultimas_ventas as $jugadas)

                                    <tr class="intro-x">
                                        <td class="w-40 text-center">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in -ml-5">
                                                    <img alt="TicoTiempos" class="tooltip rounded-full" src="{{ $jugadas->sorteos->primera_foto }}" title="{{ $jugadas->sorteos->nombre}}">
                                                </div>{{ $jugadas->sorteos->nombre}}
                                            </div>

                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $jugadas->fecha}}</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $jugadas->hora}}</div>
                                        </td>
                                        <td class="text-center">{{ $jugadas->numero}}</td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> {{ $jugadas->monto}} </div>
                                        </td>
                                        <td class="text-center">{{ $jugadas->monto_reventado}}</td>

                                        <td class="table-report__action w-56 text-center">
                                            <div class="flex justify-center items-center">
                                                {{ $jugadas->estatus_detalle}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>
        <div class="col-span-12 2xl:col-span-3">
            <div class="2xl:border-l -mb-10 pb-10">
                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                    <!-- BEGIN: Transactions -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">Transacciones</h2>
                        </div>
                        <div class="mt-5">
                            @if ($transacciones->count() > 0)

                            @foreach ($transacciones as $operaciones)
                                <div class="intro-x">
                                    <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                        <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                            <img alt="Logo Darwins" src="{{ asset('dist/images/logos/logos-new.png') }}">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">{{ $operaciones->concepto }} - {{ $operaciones->usuarios->name }}</div>
                                            <div class="text-slate-500 text-xs mt-0.5">{{ $operaciones->created_at }}</div>
                                        </div>
                                        <div class="{{ 'text-success'}}">₡{{ $operaciones->monto }}</div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                <h2 class="text-lg font-medium truncate mr-5">No Existen Transacciones</h2>
                            @endif

                            <a href="{{ route('transacciones.index') }}" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Ver Mas</a>
                        </div>
                    </div>
                    <!-- END: Transactions -->
                </div>
            </div>
        </div>
    </div>
@endsection
@include('alerts.success')
@include('alerts.messages')
