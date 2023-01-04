@extends('../layout/' . $layout)

@section('subhead')
    <title>TicoTiempos - Clientes</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto"> Clientes del Sistema</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_new_cliente" class="btn btn-success shadow-md mr-2" id="agregar_sorteo" title="Agregar Nuevo Cliente"> <i class="w-4 h-4" data-lucide="user-plus"></i> </a>

        </div>
    </div>
    @include('clientes.modals.new')
    @include('clientes.modals.edit')

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap" style="text-align: center;">ID</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Identificación</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Nombre</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Teléfono</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Email</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $clientes as $cliente )
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td class="text-center">{{ $cliente->num_id }}</td>
                            <td class="text-center">{{ $cliente->nombre }}</td>
                            <td class="text-center">{{ $cliente->telefono }}</td>
                            <td class="text-center">{{ $cliente->email }}</td>
                            <td class="text-center">

                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_edit_cliente" class="btn btn-primary shadow-md mr-2" title='Editar' id="editarCliente" data-id='{{ $cliente->id }}'> <i class="w-4 h-4" data-lucide="edit"></i></a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="{{ route('clientes.delete', $cliente->id ) }}" class="btn btn-danger shadow-md mr-2" title="Eliminar"><i class="w-4 h-4" data-lucide="trash-2"></i></a>
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

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script type="text/javascript">
    $(document).ready(function () {

        $('body').on('click', '#submit', function (event) {
            event.preventDefault()
            var id = $("#cliente_id").val();
            var num_id = $("#modal-edit-form-1").val();
            var nombre = $("#modal-edit-form-2").val();
            var telefono = $("#modal-edit-form-3").val();
            var email = $("#modal-edit-form-4").val();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'clientes-'+ id+ '-update',
                type: "POST",
                data: {
                    id: id,
                    num_id: num_id,
                    nombre: nombre,
                    telefono: telefono,
                    email: email,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    window.location.reload(true);
                }
            });
        });

        $('body').on('click', '#editarCliente', function (event) {

            event.preventDefault();
            var id = $(this).data('id');
            //console.log(id)
            $.get('clientes-' + id + '-edit', function (data) {
                //console.log(data)
                $('#modal-edit-form-1').val(data.data.num_id);
                $('#modal-edit-form-2').val(data.data.nombre);
                $('#modal-edit-form-3').val(data.data.telefono);
                $('#modal-edit-form-4').val(data.data.email);
                $('#cliente_id').val(data.data.id);

            })
        });

        $(document).on("blur", "#modal-form-1" , function(event) {
            var id = $(this).val();
            var URL = 'https://apis.gometa.org/cedulas/' + id;
            $.ajax({
                type:'GET',
                url: URL,
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    if (typeof response =='object') {
                        $('#modal-form-2').val(response.nombre);
                    }
                },
                error:function(response){
                    alert('Identificación No Encontrada');
                    $('#modal-form-2').val('');
                }
            });
        });

    });
    </script>
@endsection
@include('alerts.success')
@include('alerts.messages')

