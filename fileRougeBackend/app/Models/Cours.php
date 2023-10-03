<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cours extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public static function boot()
    {


        parent::boot();
        static::created(function ($cours) {
            $request = request();
            $classeIds = $request->input('classe_ids');
            $nbrHeures = $request->input('nbr_heures');
            if ($classeIds) {
                foreach ($classeIds as $classeId) {
                    $cours->classes()->attach($classeId, ['nbr_heures' => $nbrHeures]);
                }
            }
        });
    }


    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(AnneeClasse::class, 'cours_classes', 'cours_id', 'annee_classe_id');
    }
}
