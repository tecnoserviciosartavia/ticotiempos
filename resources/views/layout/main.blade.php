@extends('../layout/base')

@section('body')
    <body class="py-5">
        @if (Auth::user()->es_administrador == 0)
            @yield('content')
        @else
            @yield('admin_content')
        @endif
        <!-- @include('../layout/components/dark-mode-switcher')
         @include('../layout/components/main-color-switcher')-->

        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="{{ mix('dist/js/app.js') }}"></script>

        <!-- END: JS Assets-->

        @yield('script')
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                    $('#recibido_data').DataTable();
            } );
        </script>
        <script type="text/javascript">

            window.onload = function() {
                setInterval(muestraReloj, 1000);
            }

            function muestraReloj() {
                $( "#reloj" ).html('');
                var fechaHora = new Date();
                var horas = fechaHora.getHours();
                var minutos = fechaHora.getMinutes();
                var segundos = fechaHora.getSeconds();

                var sufijo = ' am';
                if(horas > 12) {
                    horas = horas - 12;
                    sufijo = ' pm';
                }

                if(horas < 10) { horas = '0' + horas; }
                if(minutos < 10) { minutos = '0' + minutos; }
                if(segundos < 10) { segundos = '0' + segundos; }

                $( "#reloj" ).html(horas+':'+minutos+':'+segundos +sufijo);
            }
        </script>
    </body>
@endsection
