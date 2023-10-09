<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required',
            'heure_debut' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'heure_fin' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
                'after:heure_debut',
            ],
            'etat' => 'in:enAttente,enCours,annule,termine',
            'salle_id' => 'required|exists:salles,id',
            // 'cours_classe_id' => 'required|exists:cours_classes,id',
            // 'professeur_id' => 'required|exists:professeurs,id',
        ];
    }
}
