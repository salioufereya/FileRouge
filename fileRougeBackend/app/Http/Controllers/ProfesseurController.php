<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Traits\HttpResp;
use App\Models\Professeur;
use Illuminate\Http\Request;
use App\Http\Resources\CoursResource;
use App\Http\Resources\SessionResource;
use App\Models\Session;

class ProfesseurController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $professeurs = Professeur::all();
        return $this->success(200, 'Liste des profs', $professeurs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function  getCoursByProf($prof)
    {
        $cours = Cours::where('professeur_id', $prof)->get();
        return $this->success(200, "Les cours", CoursResource::collection($cours));
    }
    public function getSessionByProf($prof)
    {
        $sessions = Session::where('professeur_id', $prof)->get();
        return $this->success(200, "Listes des sessions", SessionResource::collection($sessions));
    }
}
