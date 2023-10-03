<?php

namespace App\Http\Requests;

use App\Traits\HttpResp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class CoursRequest extends FormRequest
{
    use HttpResp;
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
            'nbr_heures' => 'required|numeric|min:1',
            'etat' => 'string',
            'semestre_id' => 'required|exists:semestres,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'module_id' => 'required|exists:modules,id',
            'classe_ids' => 'required|array|exists:annee_classes,id'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(500, "Quelque chose s'est mal passé", $validator->errors())
        );
    }
}
