<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\CoursClasse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClasseResource2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             CoursClasse::find($this->id)
        ];
    }
}
