<?php

namespace App\Http\Controllers\Api;

use App\Cliente;
use App\Habitacion;
use App\Http\Controllers\Api\BaseController;
use App\Cliente_Habitacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Cliente_Habitacion as ClienteHabitacionResource;
class ClienteHabitacionController extends BaseController
{
    //
    public function index()
    {
        //
        $clientes = Cliente_Habitacion::all();
        return $this->sendResponse(ClienteHabitacionResource::collection($clientes), 'El listado de reservaciones se ha obtenido correctamente.');
    }
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'cliente_id' => 'required',
            'habitacion_id' => 'required',
            'fecha_reserva' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }
        if (!Cliente::where('id', $input['cliente_id'])->exists()) {
            return $this->sendError('No se encontró el cliente.', $validator->errors());
        }
        if (!Habitacion::where('id', $input['habitacion_id'])->exists()) {
            return $this->sendError('No se encontró la habitación.', $validator->errors());
        }
        $clientes = new Cliente_Habitacion();
        $clientes->cliente_id = $input['cliente_id'];
        $clientes->habitacion_id  = $input['habitacion_id'];
        $clientes->fecha_reserva = $input['fecha_reserva'];
        $clientes->save();

        return $this->sendResponse(new ClienteHabitacionResource($clientes), 'El cliente fue asignado correctamente a la habitacion.');
    }
    public function update(Request $request)
    {
        //
        $input = $request->all();
        $clientes = Cliente_Habitacion::find($request->route('id'));
        $validator = Validator::make($input, [
            'habitacion_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }
        if (!Habitacion::where('id', $input['habitacion_id'])->exists()) {
            return $this->sendError('No se encontró la habitación.', $validator->errors());
        }
        $clientes->habitacion_id  = $input['habitacion_id'];
        $clientes->save();

        return $this->sendResponse(new ClienteHabitacionResource($clientes), 'El cliente fue asignado correctamente a la habitacion.');
    }
    public function show($id)
    {
        //
        $clientes = Cliente_Habitacion::find($id);

        if (is_null($clientes)) {
            return $this->sendError('Reservacion no encontrada.');
        }

        return $this->sendResponse(new ClienteHabitacionResource($clientes), 'La reservacion se ha obtenido correctamente.');
    }
}
