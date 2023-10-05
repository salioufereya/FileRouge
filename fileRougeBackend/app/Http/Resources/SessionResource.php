<?php

namespace App\Http\Resources;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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
            'date' => $this->date,
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
            'etat' => $this->etat,
            'salle' => $this->salle->libelle,
            'professeur' => $this->professeur->nom_complet,
            'classe' =>  Classe::find($this->cours_classe->annee_classe_id)->libelle,

        ];
    }
}
