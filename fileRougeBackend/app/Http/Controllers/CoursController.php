<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Semestre;
use App\Traits\HttpResp;
use App\Models\Professeur;
use App\Models\AnneeClasse;
use Illuminate\Http\Request;
use App\Http\Requests\CoursRequest;
use App\Http\Resources\ClasseResource;
use App\Http\Resources\CoursResource;
use App\Http\Resources\ModuleResource;
use Illuminate\Database\QueryException;
use App\Http\Resources\SemestreResource;
use App\Http\Resources\ProfesseurResource;

class CoursController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  $this->success(200, 'Liste des cours ', CoursResource::collection(Cours::all()));
    }


    public function getAllNeed()
    {
        $semestres = SemestreResource::collection(Semestre::all());
        $modules = ModuleResource::collection(Module::all());
        $profs = ProfesseurResource::collection(Professeur::all());
        $classes = AnneeClasse::where('annee_id', 1)->get();
        $classe = [];
        foreach ($classes as $key) {
            $classe[] = (Classe::find($key->classe_id));
        }
        $data = [
            'semestres' => $semestres,
            'modules' => $modules,
            'professeurs' => $profs,
            'classes' =>  ClasseResource::collection($classe),
            'cours' => CoursResource::collection(Cours::all())
        ];
        return $this->success(200, 'Liste', $data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CoursRequest $request)
    {
        try {
            $cours = Cours::create($request->all());
            return $this->success(200, "Successfully",   new CoursResource($cours));
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return $this->error(500, "Ce cours est déjà programmé.");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
