<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatsResource extends JsonResource
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
            "idCat" => $this->idCat,
            "img_link" => $this->img_link,
            "nameplats" => $this->nameplats,
            "prix" => $this->prix,
            "ingredients" => $this->ingredients,
            "description" => $this->description,
            "posted" => $this->posted,
            "created_at" => $this->created_at->format('d/m/Y'),
            "updated_at" => $this->updated_at->format('d/m/Y'),
        ];
    }
}
