<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PharIo\Manifest\Email;

class InscriptionResource extends JsonResource
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
            'nom' => $this->user->nom,
            'prenom' => $this->user->prenom,
            'email' => $this->user->email,
            'telephone' => $this->user->telephone,
            'login' => $this->user->numero,
            'dateNaissance' => $this->user->dateNaissance,
            'lieuNaissance' => $this->user->lieuNaissance,
            'sexe' => $this->user->sexe,



        ];
    }
}
