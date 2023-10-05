<?php

namespace App\Http\Controllers;

use App\Http\Resources\SemestreResource;
use App\Models\Semestre;
use App\Traits\HttpResp;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semestres = Semestre::all();
        return $this->success(200, 'Liste des semestres', SemestreResource::collection($semestres));
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
