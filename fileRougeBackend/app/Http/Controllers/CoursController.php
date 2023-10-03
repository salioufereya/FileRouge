<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Traits\HttpResp;
use Illuminate\Http\Request;
use App\Http\Requests\CoursRequest;
use Illuminate\Database\QueryException;

class CoursController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cours::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoursRequest $request)
    {
        try {
            $cours = Cours::create($request->all());
            return $this->success(200, "Successfully", $cours);
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
