<?php

namespace App\Http\Resources;

use App\Models\AnneeClasse;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursClasseResource2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             AnneeClasse::find($this->annee_classe_id),
        ];
    }
}
