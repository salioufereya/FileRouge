<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Salle;
use App\Models\Classe;
use App\Models\Session;
use App\Traits\HttpResp;
use App\Models\AnneeClasse;
use App\Models\CoursClasse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Requests\SessionRequest;
use App\Http\Resources\SessionResource;
use Error;

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
    public function store(SessionRequest $request)
    {
        try {
            $totalEleve = 0;
            $classeIds = $request->cours_classe_id;
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


            $professeurId = $request->professeur_id;
            $heureDebut = $request->heure_debut;
            $heureFin = $request->heure_fin;
            $date = $request->date;
            $salleId = $request->salle_id;
            $sessionsOccupees = Session::where('professeur_id', $professeurId)
                ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                    $query->where(function ($q) use ($heureDebut, $heureFin) {
                        $q->where('heure_debut', '<', $heureFin)
                            ->where('heure_fin', '>', $heureDebut);
                    })->orWhere('date', $date);
                })
                ->get();

            if ($sessionsOccupees->isNotEmpty()) {
                return $this->error(500, "Le professeur est déjà occupé pendant cette période.");
            }
            $sessionsSalleOccupees = Session::where('salle_id', $salleId)
                ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                    $query->where(function ($q) use ($heureDebut, $heureFin) {
                        $q->where('heure_debut', '<', $heureFin)
                            ->where('heure_fin', '>', $heureDebut);
                    })->orWhere('date', $date);
                })
                ->get();
            if ($sessionsSalleOccupees->isNotEmpty()) {
                return $this->error(500, "La salle est déjà réservée pendant cette période.");
            }
            foreach ($classeIds as $value) {
                $classeOccupees = Session::where('cours_classe', $value)
                    ->where(function ($query) use ($heureDebut, $heureFin, $date) {
                        $query->where(function ($q) use ($heureDebut, $heureFin) {
                            $q->where('heure_debut', '<', $heureFin)
                                ->where('heure_fin', '>', $heureDebut);
                        })->orWhere('date', $date);
                    })
                    ->get();
                if ($classeOccupees->isNotEmpty()) {
                    return $this->error(500, "La classe est en cours pour  cette intervalle d'heure.");
                }
            }

            foreach ($classeIds as $classId) {
                Session::create([
                    'date' => $date,
                    'cours_classe_id' => $classId,
                    'salle_id' => $salleId,
                    'etat' => $request->etat,
                    'heure_debut' => $heureDebut,
                    'heure_fin' => $heureFin,
                    'professeur_id' => $professeurId,
                ]);
            }
            return $this->success(200, 'session ajoutée avec success');
        } catch (Exception $th) {
            throw new Error($th);
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
