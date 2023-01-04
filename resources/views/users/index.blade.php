@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Usuarios</title>
@endsection


@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <form class="form" method="post" action="{{ route('user.filter') }}">
            @csrf
            <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500 ml-2">
                    Estatus:
                    <select class="form-select" aria-label=".form-select-lg example" name="active">
                        <option value="all" {{ ($active == 'all' ? 'selected="selected"' : '') }}>-- Todos los Estatus --</option>
                        <option value="1" {{ ($active == '1' ? 'selected="selected"' : '') }}>Activo</option>
                        <option value="0" {{ ($active == '0' ? 'selected="selected"' : '') }}>Inactivo</option>
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

        <h2 class="text-lg font-medium mr-auto">Usuarios del Aplicativo</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('user.add') }}" class="btn btn-primary shadow-md mr-2" title="Agregar Nuevo Usuario"><i class="w-4 h-4" data-lucide="user-check"></i></a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Users Layout -->
        @foreach ($users as $user)
            <div class="intro-y col-span-12 md:col-span-6">
                <div class="box">
                    <div class="flex flex-col lg:flex-row items-center p-5">
                        <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                            <img alt="{{ $user->name }}" class="rounded-full" src="{{ $user->photo_url }}">
                        </div>
                        <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                            <a href="" class="font-medium">{{ $user->name }}</a>
                            <div class="text-slate-500 text-xs mt-0.5">{{ $user->email }}</div>
                        </div>
                        <div class="flex mt-4 lg:mt-0">
                            <a href="{{ route('user.edit', $user->id) }}"class="btn btn-primary py-1 px-2 mr-2" title='Editar'> <i class="w-4 h-4" data-lucide="edit"></i></a>
                            <a href="{{ route('user.profile', $user->id) }}"class="btn btn-primary py-1 px-2 mr-2" title='Perfil'> <i class="w-4 h-4" data-lucide="user"></i></a>
                            <a href="{{ route('parameter.index', $user->id) }}"class="btn btn-primary py-1 px-2 mr-2" title='Parametros'> <i class="w-4 h-4" data-lucide="settings"></i></a>
                            @if ($user->active > 0)
                                <a href="{{ route('user.delete', $user->id) }}"class="btn btn-danger py-1 px-2 mr-2" title='Inactivar'> <i class="w-4 h-4" data-lucide="trash-2"></i></a>
                            @else
                                <a href="{{ route('user.activate', $user->id) }}"class="btn btn-success py-1 px-2 mr-2" title='Activar'> <i class="w-4 h-4" data-lucide="log-in"></i></a>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- BEGIN: Users Layout -->
    </div>
@endsection
@include('alerts.success')
@include('alerts.messages')
