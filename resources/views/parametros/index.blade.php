@extends('../layout/' . $layout)

@section('subhead')
    <title>Tabulator - Midone - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Parametros de Sorteos por Usuario</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @if (count($sorteos) > 0)
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview" class="btn btn-success shadow-md mr-2" id="agregar_parametro" title="Agregar Nuevo Parametro"><i class="w-4 h-4" data-lucide="plus"></i></a>
            @endif
        </div>
    </div>
    @include('parametros.modals.new')
    @include('parametros.modals.edit')

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto">
            <table class="table table-bordered table-hover" id="recibido_data">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Sorteo</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Paga</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Comisión</th>
                        <th class="whitespace-nowrap items-center" style="text-align: center;">Devolución</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Monto Limite por Numero</th>
                        <th class="whitespace-nowrap" style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parametros as $parametro)
                        <tr>
                            <td class="text-center">{{ $parametro->parametros_sorteos->nombre }}</td>
                            <td class="text-center">{{ $parametro->paga }}</td>
                            <td class="text-right">{{ $parametro->comision }} %</td>
                            <td class="text-right">{{ $parametro->devolucion }}</td>
                            <td class="text-right">{{ $parametro->monto_arranque }}</td>
                            <td class="text-center">
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modal_edit_parametro" class="btn btn-primary shadow-md mr-2" title='Editar' id="editarParametro" data-id='{{ $parametro->id }}'> <i class="w-4 h-4" data-lucide="edit"></i></a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="{{ route('parameter.delete', $parametro->id) }}" class="btn btn-danger shadow-md mr-2">
                                    <i class="w-4 h-4" data-lucide="trash-2"></i>
                                </a>
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
    $(document).ready(function() {
        $('body').on('click', '#editarParametro', function (event) {

            event.preventDefault();
            var id = $(this).data('id');
            //console.log(id)
            $.get('parameter-' + id + '-edit', function (data) {
                //console.log(data)
                $('#modal-edit-form-1').val(data.data.paga);
                $('#modal-edit-form-2').val(data.data.comision);
                $('#modal-edit-form-3').val(data.data.devolucion);
                $('#modal-edit-form-4').val(data.data.monto_arranque);
                $('#parametros_id').val(data.data.id);

            })
        });

        $('body').on('click', '#submit', function (event) {
            event.preventDefault()
            var id = $("#parametros_id").val();
            var paga = $("#modal-edit-form-1").val();
            var comision = $("#modal-edit-form-2").val();
            var devolucion = $("#modal-edit-form-3").val();
            var monto_arranque = $("#modal-edit-form-4").val();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'parameter-'+ id+ '-update',
                type: "POST",
                data: {
                    id: id,
                    paga: paga,
                    comision: comision,
                    devolucion: devolucion,
                    monto_arranque: monto_arranque,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    window.location.reload(true);
                }
            });
        });
    });
</script>
@endsection
@include('alerts.success')
@include('alerts.messages')

