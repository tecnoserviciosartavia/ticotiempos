@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    <!-- BEGIN: Top Bar -->
    <div class="border-b border-white/[0.08] mt-[2.2rem] md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 pt-3 md:pt-0 mb-10">
        <div class="top-bar-boxed flex items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="-intro-x hidden md:flex">
                <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('dist/images/logos/logos-new.png') }}">
                <span class="text-white text-lg ml-3">
                TicoTiempos
                </span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <nav aria-label="breadcrumb" class="-intro-x h-full mr-auto">
                <ol class="breadcrumb breadcrumb-light">
                    <li class="breadcrumb-item"><a href="#">Fecha Actual</a></li>
                    <li class="breadcrumb-item active" aria-current="page" >{{ date('d-m-Y') }}&nbsp;&nbsp;&nbsp;<b id="reloj"></b></li>
                </ol>
            </nav>
            <!-- END: Breadcrumb -->
            <!-- BEGIN: Search -->
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search hidden sm:block">
                    <input type="number" step="any" id="saldo_actual_usuario_log" class="search__input form-control border-transparent" placeholder="Saldo del Usuario" value="{{ Auth::user()->saldo_actual }}" disabled='true'>
                    <img alt="Icono de colones" class="search__icon dark:text-slate-500" src="{{ asset('dist/images/logos/colone2.png') }}" style="width: 20px;">

                </div>
            </div>
            <!-- END: Search -->

            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                    <img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->photo_url }}">
                </div>
                <div class="dropdown-menu w-56">
                    <ul class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                        @if (Auth::user()->block_user > 0)
                            <li>
                                <a href="#" data-tw-toggle="modal" data-tw-target="#unlock-account" class="dropdown-item hover:bg-white/5">
                                    <i data-lucide="unlock" class="w-4 h-4 mr-2"></i> Desbloquear
                                </a>
                            </li>
                            @include('users.modals.unlock')
                        @else
                            <li class="p-2">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">{{ Auth::user()->email }}</div>
                            </li>
                            <li><hr class="dropdown-divider border-white/[0.08]"></li>
                            <li>
                                <a href="{{ route('user.profile', Auth::user()->id) }}" class="dropdown-item hover:bg-white/5">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i> Perfil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('change-password', Auth::user()->id) }}" class="dropdown-item hover:bg-white/5">
                                    <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Restablecer Contraseña
                                </a>
                            </li>
                        @endif


                        <li><hr class="dropdown-divider border-white/[0.08]"></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5">
                                <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Salir
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>
    <!-- END: Top Bar -->
    <!-- BEGIN: Top Menu -->
    <nav class="top-nav">
        <ul>
            @foreach ($top_menu as $menuKey => $menu)
                <li>
                    <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'top-menu top-menu--active' : 'top-menu' }}">
                        <div class="top-menu__icon">
                            <i data-lucide="{{ $menu['icon'] }}"></i>
                        </div>
                        <div class="top-menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                                <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                        <ul class="{{ $first_level_active_index == $menuKey ? 'top-menu__sub-open' : '' }}">
                            @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                <li>
                                    <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="top-menu">
                                        <div class="top-menu__icon">
                                            <i data-lucide="activity"></i>
                                        </div>
                                        <div class="top-menu__title">
                                            {{ $subMenu['title'] }}
                                            @if (isset($subMenu['sub_menu']))
                                                <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
                                            @endif
                                        </div>
                                    </a>
                                    @if (isset($subMenu['sub_menu']))
                                        <ul class="{{ $second_level_active_index == $subMenuKey ? 'top-menu__sub-open' : '' }}">
                                            @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                <li>
                                                    <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="top-menu">
                                                        <div class="top-menu__icon">
                                                            <i data-lucide="zap"></i>
                                                        </div>
                                                        <div class="top-menu__title">{{ $lastSubMenu['title'] }}</div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
    <!-- END: Top Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        @yield('subcontent')
    </div>
    <!-- END: Content -->
@endsection

@section('admin_content')
    @include('../layout/components/mobile-menu')
    <!-- BEGIN: Top Bar -->
    <div class="border-b border-white/[0.08] mt-[2.2rem] md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 pt-3 md:pt-0 mb-10">
        <div class="top-bar-boxed flex items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="-intro-x hidden md:flex">
                <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('dist/images/logos/logos-new.png') }}">
                <span class="text-white text-lg ml-3">
                    TicoTiempos
                </span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <nav aria-label="breadcrumb" class="-intro-x h-full mr-auto">
                <ol class="breadcrumb breadcrumb-light">
                    <li class="breadcrumb-item"><a href="#">Fecha Actual</a></li>
                    <li class="breadcrumb-item active" aria-current="page" >{{ date('d-m-Y') }}&nbsp;&nbsp;&nbsp;<b id="reloj"></b></li>
                </ol>
            </nav>
            <!-- END: Breadcrumb -->
            <!-- BEGIN: Search -->
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search hidden sm:block">
                    <input type="number" step="any" id="saldo_actual_usuario_log" class="search__input form-control border-transparent" placeholder="Saldo del Usuario" value="{{ Auth::user()->saldo_actual }}" disabled='true'>
                    <img alt="Icono de colones" class="search__icon dark:text-slate-500" src="{{ asset('dist/images/logos/colone2.png') }}" style="width: 20px;">
                </div>
            </div>
            <!-- END: Search -->

            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown">

                    <img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->photo_url }}">
                </div>
                <div class="dropdown-menu w-56">
                    <ul class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                        <li class="p-2">
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">{{ Auth::user()->email }}</div>
                        </li>
                        <li><hr class="dropdown-divider border-white/[0.08]"></li>
                        <li>
                            <a href="{{ route('user.profile', Auth::user()->id) }}" class="dropdown-item hover:bg-white/5">
                                <i data-lucide="user" class="w-4 h-4 mr-2"></i> Perfil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('change-password', Auth::user()->id) }}" class="dropdown-item hover:bg-white/5">
                                <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Restablecer Contraseña
                            </a>
                        </li>

                        <li><hr class="dropdown-divider border-white/[0.08]"></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5">
                                <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Salir
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>
    <!-- END: Top Bar -->
    <!-- BEGIN: Top Menu -->
    <nav class="top-nav">
        <ul>
            @foreach ($top_menu as $menuKey => $menu)
                <li>
                    <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'top-menu top-menu--active' : 'top-menu' }}">
                        <div class="top-menu__icon">
                            <i data-lucide="{{ $menu['icon'] }}"></i>
                        </div>
                        <div class="top-menu__title">
                            {{ $menu['title'] }}
                            @if (isset($menu['sub_menu']))
                                <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
                            @endif
                        </div>
                    </a>
                    @if (isset($menu['sub_menu']))
                        <ul class="{{ $first_level_active_index == $menuKey ? 'top-menu__sub-open' : '' }}">
                            @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                <li>
                                    <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="top-menu">
                                        <div class="top-menu__icon">
                                            <i data-lucide="activity"></i>
                                        </div>
                                        <div class="top-menu__title">
                                            {{ $subMenu['title'] }}
                                            @if (isset($subMenu['sub_menu']))
                                                <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
                                            @endif
                                        </div>
                                    </a>
                                    @if (isset($subMenu['sub_menu']))
                                        <ul class="{{ $second_level_active_index == $subMenuKey ? 'top-menu__sub-open' : '' }}">
                                            @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                <li>
                                                    <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="top-menu">
                                                        <div class="top-menu__icon">
                                                            <i data-lucide="zap"></i>
                                                        </div>
                                                        <div class="top-menu__title">{{ $lastSubMenu['title'] }}</div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
    <!-- END: Top Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        @yield('subcontent')
    </div>
    <!-- END: Content -->
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

@endsection
