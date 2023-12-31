<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoursResource;
use App\Http\Resources\CoursResource2;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\SessionResource;
use App\Http\Resources\SessionResource2;
use Error;
use Exception;
use App\Models\User;
use App\Models\Classe;
use App\Traits\HttpResp;
use App\Models\AnneeClasse;
use App\Models\Cours;
use App\Models\CoursClasse;
use App\Models\Inscription;
use App\Models\Session;
use App\Notifications\SendEleveNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnSelf;

class InscriptionController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            foreach ($request->object as $key) {
                $idClasse = Classe::where('libelle', $key['classe'])->first();
                $annee_id = 1;
                $idAnneeClasse = AnneeClasse::where(['classe_id' => $idClasse->id, 'annee_id' => $annee_id])->first();
                $numero = $idAnneeClasse->id . $key['telephone'];
                $password = Str::random(random_int(8, 10));
                $etudiants = [
                    'nom' => $key['nom'],
                    'prenom' => $key['prenom'],
                    'email' => $key['email'],
                    'dateNaissance' => $key['dateNaissance'],
                    'lieuNaissance' => $key['lieuNaissance'],
                    'telephone' => $key['telephone'],
                    'sexe' => $key['sexe'],
                    'numero' => $numero,
                    'password' => $password,
                    'role' => 'student',
                ];
                if ($key['numero'] == 'null') {
                    $user = User::create($etudiants);
                    Inscription::create([
                        'user_id' => $user->id,
                        'annee_classe_id' => $idAnneeClasse->id,
                    ]);
                } else {
                    $etudiant = [
                        'nom' => $key['nom'],
                        'prenom' => $key['prenom'],
                        'email' => $key['email'],
                        'dateNaissance' => $key['dateNaissance'],
                        'lieuNaissance' => $key['lieuNaissance'],
                        'telephone' => $key['telephone'],
                        'sexe' => $key['sexe'],
                        'numero' => $key['numero'],
                        'role' => 'student',
                    ];
                    $user = User::where($etudiant)->first();
                    Inscription::create([
                        'user_id' => $user->id,
                        'annee_classe_id' => $idAnneeClasse->id,
                    ]);
                }
                $data = ['classe' => $user->classe, 'login' => $user->numero, 'password' => $user->password];
                if ($user) {
                    $user->notify(new SendEleveNotify($user));
                }
            }
            DB::commit();
            return  $this->success(200, "ajout réussi");
        } catch (Exception $e) {
            DB::rollBack();
            throw new Error($e);
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



    public function  getElevesByClasse($classe)
    {
        $idAnCl = AnneeClasse::where(['classe_id' => $classe, 'annee_id' => 1])->first();
        $eleves = Inscription::where('annee_classe_id', $idAnCl->id)->get();
        return  InscriptionResource::collection($eleves);
    }


    public function coursByEleves(Request $request)
    {

        $id = Inscription::where('user_id', $request->id)->first();
        $id1 = AnneeClasse::find($id->annee_classe_id)->id;
        $cours = CoursClasse::where('annee_classe_id', $id1)->get();
        $courss = [];
        foreach ($cours as $value) {
            $courss[] = Cours::find($value->cours_id);
        }
        return $this->success(200, '', CoursResource2::collection($courss));
    }


    public function sessionsByEleves(Request $request)
    {
        $id = Inscription::where('user_id', $request->id)->first();
        $id1 = AnneeClasse::find($id->annee_classe_id)->id;
        $cours = CoursClasse::where('annee_classe_id', $id1)->get();
        $courss = [];
        foreach ($cours as $value) {
            $courss[] = Cours::find($value->cours_id)->id;
        }
        $sessions = [];
        foreach ($courss as $val) {
            $sessions[] = Session::where('cours_id',$val)->first();
        }
        return $this->success(200,"",SessionResource2::collection($sessions));
    }
}
