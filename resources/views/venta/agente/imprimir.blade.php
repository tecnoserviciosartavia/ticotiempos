<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('black') }}/img/apple-icon.png">
    <link href="{{ asset('black') }}/css/theme.css" rel="stylesheet" />

	<style type="text/css">
* {
    font-size: 13px;
    font-family: 'Poppins';
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.producto,
th.producto {
    width: 135px;
    max-width: 135px;
}

td.cantidad,
th.cantidad {
    width: 30px;
    max-width: 30px;
    word-break: break-all;
}

td.precio,
th.precio {
    width: 90px;
    max-width: 90px;
    word-break: break-all;
    text-align: right;
}

.centrado {
    text-align: left;
    align-content: left;
}

.ticket {
    width: 235px;
    max-width: 235px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .oculto-impresion,
    .oculto-impresion * {
        display: none !important;
    }
}
.dot {
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 0%;
            display: inline-block;
        }

	</style>

</head>

    <body>
    	<button class="oculto-impresion" onclick="imprimir()">Imprimir</button>
    	<a href="{{ route('venta_sorteo.create')}}" class="oculto-impresion" >Atras</a>
        <div class="ticket">
            <p class="centrado">
                <img alt="TicoTiempos" class="w-6" src="{{ Auth::user()->photo_url }}" style="
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-left: 50px;
"><br>

                <b>{{ $venta[0]->name_banca }}</b>
                <br><b>Sorteo:</b> {{ $venta_cabecera[0]->nombre }}
                <br><b>Fecha:</b> {{ $venta_cabecera[0]->fecha }}
                <br><b>Hora:</b> {{ $venta_cabecera[0]->hora }}
        		<br><b>Cliente:</b> {{ $venta[0]->name_cliente }}
        		<br><b>Identificacion:</b> {{ $venta[0]->num_id }}
                <br><b>Tiquete:</b> {{ $venta[0]->id }}
                <br><b>Fecha de Compra de Tiquete:</b> {{ $venta[0]->created_at }}
                @if (isset($parametros[0]->paga))
                    <br><b>Paga:</b> {{ $parametros[0]->paga }}
                @else
                    <br><b>Paga:</b> -- Sin Definir --
                @endif
            </p><br>
            <table>
                <thead>
                    <tr>

                        <th class="producto">JUGADA</th>
                        <th class="precio">MONTO</th>
                        @if ($venta_cabecera[0]->es_reventado > 0)
                            <th class="precio">REVENTADO</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                	<?php
        				$total_comprobante = 0;
                	?>
                	@foreach($callback as $v)
                		<tr>
                        	<td class="producto">{{ $v->numero }}</td>
                        	<td class="precio"> {{ number_format($v->monto,2,',','.') }} </td>
                            <td class="precio"> {{ number_format($v->monto_reventado,2,',','.') }} </td>
                    	</tr>
                        <?php
                            if ($v->monto_reventado > 0) {
                                $total_comprobante +=  $v->monto + $v->monto_reventado;

                            } else {
                                $total_comprobante +=  $v->monto;
                            }
                	    ?>
                	@endforeach

                    <tr>
                        <td class="producto"><b><i>Total Comprobante:</i></td>
                        <td class="precio" colspan="2"><b>{{ number_format($total_comprobante,2,',','.') }}</b></td>
                    </tr>
                </tbody>
            </table>
            <p class="centrado">
                @foreach ($bolitas as $bolita)
                    <br><b  style="background-color: <?php echo $bolita->color; ?>;">{{ $bolita->descripcion }}</b> - <b>Paga: {{ $bolita->paga_resultado}}</b>
                @endforeach
                <br><b>SISTEMAS TicoTiempos<br></b>
                Mucha Suerte en el sorteo<br>
                <b>Nota:</b> tienes 7 días hábiles para canjear su premio.<br>
                @if ($impresion > 0)
                    <strong>REIMPRESO NO VALIDO</strong><br>
                @endif
            </p>
        </div>

<script type="text/javascript">
    window.print();
    function imprimir() {
      window.print();
    }
    </script>
    </body>

</html>
