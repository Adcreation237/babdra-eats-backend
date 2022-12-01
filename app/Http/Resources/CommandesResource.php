<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommandesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "iduser" => $this->iduser,
            "idplat" => $this->idplat,
            "qte" => $this->qte,
            "statut" => $this->statut,
            "date" => $this->date,
            "heure" => $this->heure,
            "created_at" => $this->created_at->format('d/m/Y'),
            "updated_at" => $this->updated_at->format('d/m/Y'),
        ];
    }
}

