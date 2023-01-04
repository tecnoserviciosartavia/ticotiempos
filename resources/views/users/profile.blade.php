@extends('../layout/' . $layout)

@section('subhead')
    <title>Tiempos Darwins - Perfil</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Perfil de Usuario</h2>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="{{ $users->name }}" class="rounded-full" src="{{ $users->photo_url }}">
                    <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2">
                        <i class="w-4 h-4 text-white" data-lucide="camera">
                        </i>
                    </div>
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $users->name }}</div>
                    <div class="text-slate-500">{{ $users->email }}</div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Detalle de Contacto</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $users->email }}
                    </div>
                </div>
            </div>
        </div>
        <ul
            class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center"
            role="tablist"
        >
            <li id="account-tab" class="nav-item" role="presentation">
                <a
                    href="{{ route('user.updprofile', $users->id) }}"
                    class="nav-link py-4 flex items-center"
                    data-tw-target="#account"
                    aria-selected="false"
                    role="tab"
                >
                    <i class="w-4 h-4 mr-2" data-lucide="edit" ></i> Editar Perfil
                </a>
            </li>
            <li id="change-password-tab" class="nav-item" role="presentation">
                <a
                    href="{{ route('change-password',  $users->id) }}"
                    class="nav-link py-4 flex items-center"
                    data-tw-target="#change-password"
                    aria-selected="false"
                    role="tab"
                >
                    <i class="w-4 h-4 mr-2" data-lucide="lock"></i> Cambiar Contraseña
                </a>
            </li>
            @if (Auth::User()->es_administrador > 0)
                <li id="change-password-tab" class="nav-item" role="presentation">
                    <a
                        href="{{ route('parameter.index', $users->id) }}"
                        class="nav-link py-4 flex items-center"
                        data-tw-target="#usuarios"
                        aria-selected="false"
                        role="tab"
                    >
                        <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Parametros
                    </a>
                </li>
            @else
                <li id="change-password-tab" class="nav-item" role="presentation">
                    <a
                        href="{{ route('parameter.user', $users->id) }}"
                        class="nav-link py-4 flex items-center"
                        data-tw-target="#usuarios"
                        aria-selected="false"
                        role="tab"
                    >
                        <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Parametros
                    </a>
                </li>
            @endif
            @if (Auth::User()->es_administrador > 0)
                <li id="change-password-tab" class="nav-item" role="presentation">
                    <a
                        href="#"
                        class="nav-link py-4 flex items-center"
                        data-tw-toggle="modal"
                        data-tw-target="#generate-key-account"
                        aria-selected="false"
                        role="tab"
                    >
                        <i class="w-4 h-4 mr-2" data-lucide="key"></i> Generar Llave
                    </a>
                </li>
            @else
                <li id="change-password-tab" class="nav-item" role="presentation">
                    <a
                        href="{{ route('user.block', $users->id) }}"
                        class="nav-link py-4 flex items-center"
                        data-tw-target="#usuarios"
                        aria-selected="false"
                        role="tab"
                    >
                        <i class="w-4 h-4 mr-2" data-lucide="lock"></i> Bloquear Venta
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <!-- END: Profile Info -->
    <div class="intro-y tab-content mt-5">
        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Daily Sales -->
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">Ultimas 5 Ventas Diarias</h2>
                        <a href="{{ route('resumen.index') }}" class="btn btn-outline-secondary hidden sm:flex">
                            <i data-lucide="file" class="w-4 h-4 mr-2"></i> Ver Mas
                        </a>
                    </div>
                    <div class="p-5">
                        @foreach ($venta_detalle as $venta)

                            <div class="relative flex items-center">
                                <div class="w-12 h-12 flex-none image-fit">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src=" {{ asset('dist/images/logos/LOGODkk.png') }}">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <a href="" class="font-medium">{{ $venta->nombre }}</a>
                                    <div class="text-slate-500 mr-5 sm:mr-5">{{ $venta->fecha }} - {{ $venta->hora }}</div>
                                </div>
                                <div class="font-medium text-slate-600 dark:text-slate-500">Numero Jugado: {{ $venta->numero }} - Monto: {{ $venta->monto }}</div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <!-- END: Daily Sales -->
                <!-- BEGIN: Latest Tasks -->
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">Sorteos Abiertos</h2>
                    </div>
                    <div class="p-5">
                        <div class="tab-content">
                            <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                                @foreach ($juegos_hoy as $juego)

                                    <div class="flex items-center mt-5">
                                        <div class="border-l-2 border-primary dark:border-primary pl-4">
                                            <a href="{{ route('venta_sorteo.create')}}" class="font-medium">{{ $juego->nombre}}</a>
                                            <div class="text-slate-500">{{ $juego->hora }}</div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Latest Tasks -->
            </div>
        </div>
    </div>
    @include('users.modals.key')
@endsection
@include('alerts.success')
@include('alerts.messages')


