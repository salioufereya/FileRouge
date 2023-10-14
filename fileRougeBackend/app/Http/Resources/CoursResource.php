<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursResource extends JsonResource
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
            'semestre' =>  $this->semestre->libelle,
            'module' => $this->module->libelle,
            "photo" => $this->module->photo,
            'professeur' =>   $this->professeur->nom_complet,
            'etat' => $this->etat,
            'classes' =>  CoursClasseResource::collection($this->cours_classes),
        ];
    }
}
