<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];



    public function professeur(): BelongsTo
    {
        return $this->belongsTo(Professeur::class);
    }
    public function salle(): BelongsTo
    {
        return $this->belongsTo(Salle::class);
    }
    public function cours_classe(): BelongsTo
    {
        return $this->belongsTo(CoursClasse::class);
    }
    public function cours_classe_sessions(): BelongsToMany
    {
        return $this->belongsToMany(CoursClasse::class, 'cours_classe_sessions');
    }
}
