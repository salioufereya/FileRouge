<?php

namespace App\Models;

use App\Models\AnneeClasse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cours extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public static function boot()
    {
        parent::boot();
        static::created(function ($cours) {
            $request = request();
            $classeIds = $request->input('classe_ids');
            $nbrHeures = $request->input('nbr_heures');
            if ($classeIds && $nbrHeures) {
                foreach ($classeIds as $classeId) {
                    $cours->classes()->attach($classeId, ['nbr_heures' => $nbrHeures, 'heures_restant' => $nbrHeures]);
                }
            }
        });
    }



    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(AnneeClasse::class, 'cours_classes', 'cours_id', 'annee_classe_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class);
    }

    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class);
    }

    public function cours_classes(): BelongsToMany
    {
        return $this->belongsToMany(AnneeClasse::class, 'cours_classes')
            ->withPivot(['nbr_heures']);
    }
}
