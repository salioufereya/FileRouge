<?php

namespace App\Http\Resources;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursClasseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'classe' => Classe::find($this->classe_id)->libelle,
            'effectif' => $this->effectif,
            'nombre_heures' => $this->pivot->nbr_heures
        ];
    }
}
