@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Cuentas</title>
@endsection

@section('subcontent')
@include('cuentas.modals.new')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Cuentas del Sistema</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Nombre Usuario</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Saldo Dia Anterior</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Saldo Actual</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $users as $user )
                        @php
                            $balance = \App\Models\User_balance::saldoActual($user->id);
                        @endphp
                        <tr>
                            <td class="text-center">
                                @if ($user->es_administrador > 0)
                                    Administrador &nbsp; &nbsp; - &nbsp;&nbsp;
                                @endif
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $balance->saldo_anterior }}
                            </td>
                            <td>
                                {{ $balance->saldo_final }}
                            </td>
                            <td class="text-center">
                                @if ($user->es_administrador == 0)

                                    @if ($balance->saldo_anterior > 0)

                                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_retiro" class="btn btn-success shadow-md mr-2" id="agregar_retiro" title="Agregar Nuevo Retiro" data-id="{{ $user->id }}"><i class="w-4 h-4" data-lucide="plus"></i></a>
                                    @endif
                                @endif
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

        $('body').on('click', '#submit', function (event) {
            event.preventDefault()
            var id = $("#usuario_id").val();
            var nombre = $("#modal-edit-form-1").val();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'sorteos-'+ id+ '-update',
                type: "POST",
                data: {
                    id: id,
                    nombre: nombre,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    window.location.reload(true);
                }
            });
        });

        $('body').on('click', '#agregar_retiro', function (event) {

            event.preventDefault();
            var id = $(this).data('id');
            $('#usuario_id').val(id);
        });

    });
    </script>
@endsection
@include('alerts.success')
@include('alerts.messages')

