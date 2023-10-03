<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Traits\HttpResp;
use Illuminate\Http\Request;

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
}
