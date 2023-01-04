<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Venta_detalle;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes/index', [
            // Use the top-menu layout
            // Pass data to view
            'clientes' => Clientes::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_id' => 'required|integer',
            'nombre' => 'required',
        ]);
        $clientes = new Clientes;

        $clientes->num_id = $request->num_id;
        $clientes->nombre = $request->nombre;
        if (isset($request->telefono)) {

            $clientes->telefono = $request->telefono;

        }
        if (isset($request->email)) {

            $clientes->email = $request->email;

        }
        $clientes->save();
        if (Auth::user()->es_administrador > 0) {

            return redirect()->route('clientes.index')->withSuccess(__('Cliente Agregado correctamente.'));

        } else {

            if ($request->form_action === '0') {

                return redirect()->route('venta_sorteo.create')->withSuccess(__('Cliente Agregado correctamente.'));

            } else {
                // Traigo los clientes de la venta para poderlos actualizar todos si tiene 1 o N ventas las actualizo todas
                $callback = $this->traer_cliente_venta($request->padre_id_edit_modal);

                foreach ($callback as $jugada) {
                    Venta_detalle::where('id', $jugada->id)
                    ->update(['idcliente' => $clientes->id]);
                }
                return redirect()->route('venta_sorteo.edit', $request->padre_id_edit_modal)->withSuccess(__('Cliente Agregado correctamente.'));

            }

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Clientes::find($id);

	    return response()->json([
	      'data' => $cliente
	    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'num_id' => 'required|integer',
            'nombre' => 'required',
        ]);

        $cliente = Clientes::find($id);
        $cliente->num_id = $request->num_id;
        $cliente->nombre = $request->nombre;

        if (isset($request->telefono)) {

            $cliente->telefono = $request->telefono;

        }
        if (isset($request->email)) {

            $cliente->email = $request->email;

        }
        $cliente->save();
        Session::flash('success', "Cliente Editado correctamente.");
        return response()->json([ 'success' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clientes::destroy($id);
        return redirect()->route('clientes.index')->withSuccess(__('Cliente Eliminado correctamente.'));
    }

    public function traer_cliente_venta($padre_id){

        //QUERY PARA SABER CUAL ES EL PADRE DE LA VENTA
        $v_detalle     = Venta_detalle::find($padre_id);
        //QUERY PARA SABER CUALES SON LOS HIJOS DE LA VENTA Y ARMAR 1 SOLO ARRAY CON TODAS LAS JUGADAS
        $venta_detalle = Venta_detalle::where('jugada_padre',$padre_id)->get();
        //CREO LA VARIABLE Y LE ADJUNTO ENSEGUIDA EL PADRE
        $callback      = [];
        array_push($callback, $v_detalle);
        //RECORRO EL QUERY DE LOS HIJOS Y LO ADJUNTO A LA VARIABLE CALLBACK
        if (count($venta_detalle) > 0) {

            foreach ($venta_detalle as $venta) {

                array_push($callback, $venta);
            }
        }

        return $callback;
    }
}
