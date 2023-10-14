<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Traits\HttpResp;
use App\Models\Professeur;
use Illuminate\Http\Request;
use App\Http\Resources\CoursResource;
use App\Http\Resources\SessionResource;
use App\Mail\MailProf;
use App\Models\Session;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Mail;

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
        try {
            foreach ($request->tab as $value) {
                User::create([
                    'nom' => $value['nom'],
                    'prenom' => $value['prenom'],
                    'email' => $value['email'],
                    'role' => $value['role'],
                    'password' => $value['password'],
                ]);
            }
            return $this->success(200, "", "");
        } catch (\Throwable $th) {
            throw  new Error($th);
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

    public function  getCoursByProf(Request $request)
    {
        $prof = Professeur::where('email', $request->email)->first();
        $cours = Cours::where('professeur_id', $prof->id)->get();
        return $this->success(200, "Les cours", CoursResource::collection($cours));
    }


    public function getSessionByProf(Request $request)
    {

        $prof = Professeur::where('email', $request->email)->first();
        $sessions = Session::where('professeur_id', $prof->id)->get();
        return $this->success(200, "Listes des sessions", SessionResource::collection($sessions));
    }




    public function demarrerSessionByProf($prof, $id)
    {
        $sessions = Session::where(['professeur_id' => $prof, 'id' => $id])->first();
        $sessions->etat = 'EnCours';
        $sessions->save();
        return $this->success(200, "", new  SessionResource($sessions));
    }
    public function demandeAnnulation(Request $request)
    {
        $content = [
            'subject' => 'This is the mail subject',
            'body' => "This is the mail body"
        ];
        Mail::to('salioufereya19@gmail.com')->send(new MailProf($content));
        return $this->success(200, "message envoyé");
    }
}
