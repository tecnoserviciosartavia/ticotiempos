@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Actualizar Perfil</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Actualizar Perfil</h2>
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
                    <a class="flex items-center mt-5" href="{{ route('change-password',  $users->id) }}">
                        <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Cambiar Contraseña
                    </a>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Informacion del Perfil</h2>
                </div>
                <div class="p-5">
                    <form method="post" action="{{ route('user.update', $users->id) }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div>
                                            <label for="update-profile-form-6" class="form-label">Email</label>
                                            <input id="update-profile-form-6" type="text" class="form-control" placeholder="Input text" value="{{ $users->email }}" disabled>
                                        </div>
                                        <div class="mt-3 2xl:mt-4">
                                            <label for="update-profile-form-1" class="form-label">Nombre</label>
                                            <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ $users->name }}">
                                        </div>
                                    </div>
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div>
                                            <label for="update-profile-form-2" class="form-label">Sexo</label>
                                            <select id="update-profile-form-2" data-search="true" class="tom-select w-full" name="gender">
                                                <option value="male" {{ ($users->gender == 'male' ? 'selected="selected"' : '') }}>Hombre</option>
                                                <option value="female" {{ ($users->gender == 'female' ? 'selected="selected"' : '') }}>Mujer</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img alt="{{ $users->name }}" class="rounded-md" src="{{ $users->photo_url }}">
                                        <div title="Desea eliminar esta foto?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="btn btn-primary w-full"><i data-lucide="image" class="w-4 h-4 mr-2"></i>Cargar Foto</button>
                                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3"><i data-lucide="save" class="w-4 h-4 mr-2"></i>Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Display Information -->
        </div>
    </div>
@endsection
@include('alerts.success')
@include('alerts.messages')
