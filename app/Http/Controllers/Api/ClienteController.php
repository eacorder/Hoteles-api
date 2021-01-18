<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Cliente;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Cliente as ClienteResource;
class ClienteController extends BaseController
{
    //
    public function index()
    {
        //
        $clientes = Cliente::all();
        return $this->sendResponse(ClienteResource::collection($clientes), 'El listado de clientes se ha obtenido correctamente.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required'
        ]);
        $clientes = new Cliente();
        $clientes->nombre = $input['nombre'];
        $clientes->telefono  = $input['telefono'];
        $clientes->direccion = $input['direccion'];
        $clientes->email = $input['email'];
        $clientes->estado = 1;
        $clientes->save();

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }

        return $this->sendResponse(new ClienteResource($clientes), 'El cliente fue creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $clientes = Cliente::find($id);

        if (is_null($clientes)) {
            return $this->sendError('Cliente no encontrado.');
        }

        return $this->sendResponse(new ClienteResource($clientes), 'El listado de clientes se ha obtenido correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        //
        $input = $request->all();

        $clientes = Cliente::find($request->route('id'));
        $clientes->nombre  = (isset($input['nombre'])) ? $input['nombre'] : $clientes->nombre;
        $clientes->telefono  = (isset($input['telefono'])) ? $input['telefono'] : $clientes->telefono;
        $clientes->direccion  = (isset($input['direccion'])) ? $input['direccion'] : $clientes->direccion;
        $clientes->email  = (isset($input['email'])) ? $input['email'] : $clientes->email;
        $clientes->save();

        return $this->sendResponse(new ClienteResource($clientes), 'El cliente fue actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cliente =  Cliente::find($id);
        $cliente->delete();

        return $this->sendResponse([], 'El cliente fue eliminado correctamente.');
    }

}
