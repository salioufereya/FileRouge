<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\CoursClasse;
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
        $classeIdsArray = array_map('intval', explode(',', $this->cours_classe_ids));
        $classeValue = [];
        foreach ($classeIdsArray as $key) {
            $classe = CoursClasse::find($key);
            $classeValue[] = $classe->annee_classe_id;
        }
        $classes = [];
        foreach ($classeValue as $value) {
            $cl = Classe::select('id', 'libelle')->find($value);
            $classes[] = $cl;
        }
        return [
            'id' => $this->id,
            'date' => $this->date,
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
            'etat' => $this->etat,
            'salle' => $this->salle->libelle,
            'professeur' => $this->professeur->nom_complet,
            'classes' => $classes
        ];
    }
}
