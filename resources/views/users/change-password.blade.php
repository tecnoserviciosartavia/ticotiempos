@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Cambiar Contraseña</title>
@endsection

@section('subcontent')
@include('alerts.success')
@include('alerts.messages')

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Cambiar Contraseña</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">
                    <div class="w-12 h-12 image-fit">

                        <img alt="{{ $users->name }}" class="rounded-full" src="{{ $users->photo_url }}">

                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">{{ $users->name }}</div>
                        <div class="text-slate-500">{{ $users->email }}</div>
                    </div>

                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="flex items-center mt-5" href="{{ route('user.profile', $users->id) }}">
                        <i data-lucide="user" class="w-4 h-4 mr-2"></i> Ver Perfil
                    </a>
                    <a class="flex items-center mt-5" href="{{ route('user.updprofile', $users->id) }}">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Editar Perfil
                    </a>
                    <a class="flex items-center mt-5" href="{{ route('change-password',  $users->id) }}">
                        <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Cambiar Contraseña
                    </a>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Change Password -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Cambiar Contraseña</h2>
                </div>
                <div class="p-5">

                    <form class="form" method="post" action="{{ route('password.update', $users->id) }}">
                        @csrf
                        <div>
                            <label for="change-password-form-1" class="form-label">Actual Contraseña</label>
                            <input id="change-password-form-1" name='oldPassword' type="password" class="form-control" placeholder="Ingrese su actual contraseña" require value="{{ $users->password }}">
                            @include('alerts.feedback', ['field' => 'oldPassword'])
                        </div>
                        <div class="mt-3">
                            <label for="change-password-form-2" class="form-label">Nueva Contraseña</label>
                            <input id="change-password-form-2" name='password' type="password" class="form-control" placeholder="Ingrese su nueva Contraseña" require>
                            @include('alerts.feedback', ['field' => 'password'])

                        </div>
                        <div class="mt-3">
                            <label for="change-password-form-3" class="form-label">Confirmar Nueva Contraseña</label>
                            <input id="change-password-form-3"  name='password_confirmation' type="password" class="form-control" placeholder="Confirme la nueva contraseña" require>
                            @include('alerts.feedback', ['field' => 'password_confirmation'])

                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
            <!-- END: Change Password -->
        </div>
    </div>
@endsection

