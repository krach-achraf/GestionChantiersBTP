<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterielTache extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id','materiel_id','projet_id','dateDebut','dateFin'];

    protected $table = 'materiel_tache';

    protected $dates = ['deleted_at'];
}
