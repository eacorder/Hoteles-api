<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Habitacion;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Habitacion as HabitacionResource;
class HabitacionController  extends BaseController
{
    //
    public function index()
    {
        $habitaciones = Habitacion::all();

        return $this->sendResponse(HabitacionResource::collection($habitaciones), 'El listado de habitaciones se ha obtenido correctamente.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'numero' => 'required',
            'tipo' => 'required',
            'piso' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }

        $habitaciones = Habitacion::create($input);

        return $this->sendResponse(new HabitacionResource($habitaciones), 'Habitación creada satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $habitaciones = Habitacion::find($id);

        if (is_null($habitaciones)) {
            return $this->sendError('Habitación no encontrada.');
        }

        return $this->sendResponse(new HabitacionResource($habitaciones), 'El listado de habitaciones se ha obtenido correctamente.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habitacion $product)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors());
        }

        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();

        return $this->sendResponse(new HabitacionResource($product), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
