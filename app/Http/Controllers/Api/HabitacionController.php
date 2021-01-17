<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Habitacion;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Habitacion as HabitacionResource;
class HabitacionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $habitaciones = Habitacion::all();
        return $this->sendResponse(HabitacionResource::collection($habitaciones), 'El listado de habitaciones se ha obtenido correctamente.');
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
            'numero' => 'required',
            'tipo' => 'required',
            'piso' => 'required'
        ]);
        $habitacion = new Habitacion();
        $habitacion->numero = $input['numero'];
        $habitacion->tipo = $input['tipo'];
        $habitacion->piso = $input['piso'];
        $habitacion->descripcion = $input['descripcion'];
        $habitacion->estado = 1;
        $habitacion->save();

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }

        return $this->sendResponse(new HabitacionResource($habitacion), 'Habitación creada satisfactoriamente.');
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
        $habitaciones = Habitacion::find($id);

        if (is_null($habitaciones)) {
            return $this->sendError('Habitación no encontrada.');
        }

        return $this->sendResponse(new HabitacionResource($habitaciones), 'El listado de habitaciones se ha obtenido correctamente.');
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

        $validator = Validator::make($input, [
            'numero' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }
        $habitacion = Habitacion::find($request->route('id'));
        $habitacion->numero  = (isset($input['numero'])) ? $input['numero'] : $habitacion->numero;
        $habitacion->tipo  = (isset($input['tipo'])) ? $input['tipo'] : $habitacion->tipo;
        $habitacion->piso  = (isset($input['piso'])) ? $input['piso'] : $habitacion->piso;
        $habitacion->descripcion  = (isset($input['descripcion'])) ? $input['descripcion'] : $habitacion->descripcion;
        $habitacion->save();

        return $this->sendResponse(new HabitacionResource($habitacion), 'La habitación fue actualizada correctamente.');
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
        $habitacion =  Habitacion::find($id);
        $habitacion->delete();

        return $this->sendResponse([], 'La habitación fue eliminada correctamente.');
    }
}
