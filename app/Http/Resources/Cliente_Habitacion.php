<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cliente_Habitacion extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'cliente_nombre'=> \App\Cliente::select('nombre')->where('id',$this->cliente_id)->get(),
            'habitacion_id' => $this->habitacion_id,
            'habitacion_numero'=> \App\Habitacion::select('numero')->where('id',$this->habitacion_id)->get(),
            'fecha_reserva' => $this->fecha_reserva,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
