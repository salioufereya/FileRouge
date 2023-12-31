<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Throwable;
use App\Models\Salle;
use App\Models\Classe;
use App\Models\Session;
use App\Traits\HttpResp;
use App\Models\Professeur;
use App\Models\AnneeClasse;
use App\Models\CoursClasse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\CoursClasseSession;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SessionRequest;
use App\Http\Resources\SessionResource;
use Carbon\Carbon;

class SessionController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sessions = Session::all();
        return $this->success(200, 'Liste des sessions', SessionResource::collection($sessions));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function search(Request $request)
    {
        $professeurId = $request->professeur;
        $heureDebut = $request->heure_debut;
        $heureFin = $request->heure_fin;
        $date = $request->date;
        $professeur = Professeur::where('nom_complet', $professeurId)->first();
        $sessionsOccupees = Session::where('professeur_id', $professeur->id)
            ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                $query->where(function ($q) use ($heureDebut, $heureFin, $date) {
                    $q->where('heure_debut', '<', $heureFin)
                        ->where('heure_fin', '>', $heureDebut)
                        ->where('date', $date);
                });
            })
            ->get();

        if ($sessionsOccupees->isNotEmpty()) {
            return $this->error(500, "Le professeur est déjà occupé pendant cette période pour la date donnée.");
        } else {
            return $this->error(200, "success.");
        }
    }

    public function searchProf(Request $request)
    {
        $salleId = $request->salle_id;
        $heureDebut = $request->heure_debut;
        $heureFin = $request->heure_fin;
        $date = $request->date;
        $sessionsSalleOccupees = Session::where('salle_id', $salleId)
            ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                $query->where(function ($q) use ($heureDebut, $heureFin, $date) {
                    $q->where('heure_debut', '<', $heureFin)
                        ->where('heure_fin', '>', $heureDebut)
                        ->where('date', $date);
                });
            })
            ->get();
        if ($sessionsSalleOccupees->isNotEmpty()) {
            return $this->error(500, "La salle est déjà réservée pendant cette période.");
        } else {
            return $this->success(200, "success.");
        }
    }

    public function store(SessionRequest $request)
    {
        try {
            DB::beginTransaction();
            $professeurId = $request->professeur;
            $professeur = Professeur::where('nom_complet', $professeurId)->first();
            $heureDebut = strtotime($request->heure_debut);
            $heureFin = strtotime($request->heure_fin);
            $duree = $heureFin - $heureDebut;
            $clasIds = $request->classe_ids;
            $classeIds = [];


            // foreach ($clasIds as $key) {
            //     $cl = CoursClasse::where(['cours_id' => $request->cours_id, 'annee_classe_id' => $key['id']])->get();
            //     $classeIds[] = $cl[0]->id;
            //     $heure = $cl[0]->heures_restant * 3600;
            //     $fu = ($heure - $duree) / 3600;
            //     $cl[0]->heures_restant = $fu;
            //     $cl[0]->save();
            // }
            $heureDebut = date('H:i', $heureDebut);
            $heureFin = date('H:i', $heureFin);

            $totalEleve = 0;
            if (!is_array($classeIds)) {
                $classeIds = [$classeIds];
            }
            foreach ($classeIds as $classId) {
                $idAnneeClasse = CoursClasse::find($classId)->annee_classe_id;
                $class = AnneeClasse::find($idAnneeClasse);
                $totalEleve += $class->effectif;
            }
            $salle = Salle::find($request->salle_id);

            $effectifSalle = $salle->nbr_places;
            if ($effectifSalle < $totalEleve) {
                return $this->error(500, "Cette salle ne peut pas contenir cet effectif d'étudiants.");
            }
            $professeurId = $professeur->id;
            $date = $request->date;
            $salleId = $request->salle_id;
            $sessionsOccupees = Session::where('professeur_id', $professeurId)
                ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                    $query->where(function ($q) use ($heureDebut, $heureFin, $date) {
                        $q->where('heure_debut', '<', $heureFin)
                            ->where('heure_fin', '>', $heureDebut)
                            ->where('date', $date);
                    });
                })
                ->get();

            if ($sessionsOccupees->isNotEmpty()) {
                return $this->error(500, "Le professeur est déjà occupé pendant cette période.");
            }

            $sessionsSalleOccupees = Session::where('salle_id', $salleId)
                ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                    $query->where(function ($q) use ($heureDebut, $heureFin, $date) {
                        $q->where('heure_debut', '<', $heureFin)
                            ->where('heure_fin', '>', $heureDebut)
                            ->where('date', $date);
                    });
                })
                ->get();
            if ($sessionsSalleOccupees->isNotEmpty()) {
                return $this->error(500, "La salle est déjà réservée pendant cette période.");
            }

            $classeOccupees = Session::where('salle_id', $salleId)
                ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                    $query->where(function ($q) use ($heureDebut, $heureFin, $date) {
                        $q->where('heure_debut', '<', $heureFin)
                            ->where('heure_fin', '>', $heureDebut)
                            ->where('date', $date);
                    });
                })
                ->get();

            if ($classeOccupees->isNotEmpty()) {
                return $this->error(500, "La classe est en cours pour  cette intervalle d'heure.");
            }
            if ($salleId === null) {
                $typeCours = "enLigne";
            } else {
                $typeCours = "presentiel";
            }
            $session = Session::create([
                'date' => $date,
                'salle_id' => $salleId,
                'etat' => $request->etat,
                'heure_debut' => $heureDebut,
                'heure_fin' => $heureFin,
                'professeur_id' => $professeurId,
                'duree' =>  date('H:i', $duree),
                'cours_id' => $request->cours_id,
                'typeCours' => $typeCours,
                'cours_classe_ids' => implode(',', $classeIds)
            ]);
            DB::commit();
            return $this->success(200, 'session ajoutée avec success',  new SessionResource($session));
        } catch (Exception $th) {
            DB::rollback();
            throw new Error($th);
        }
    }

    public function getSessionsByProf()
    {
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

    public function annuler(Request $request)
    {
        try {
            $session = Session::find($request->id);
            $session->etat = "annuler";
            $session->save();
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    public function terminer(Request $request)
    {
       
        try {
            $session = Session::find($request->id);
            $session->etat = "terminer";
            $session->save();
            return $this->success(200, "Session termé avec success", $session);
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }



    public function valider(Request $request)
    {
        try {
            $session = Session::find($request->id);
            $session->etat = "valider";
            $session->save();
            $cl = CoursClasse::where('cours_id', $session->cours_id)->first();
            $duree = Carbon::parse($session->duree);
            $dureeEnHeures = $duree->hour + $duree->minute / 60 + $duree->second / 3600;
            $heure = $cl->heures_restant;
            $fu = $heure - $dureeEnHeures;
            $cl->heures_restant = $fu;
            $cl->save();
            return $this->success(200, "Valider avec succès", $session);
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
