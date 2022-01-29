<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'materiels';

    protected $fillable = [
        'libelle',
        'photo',
    ];

    protected $dates = ['deleted_at'];

    public function taches(): BelongsToMany
    {
        return $this->belongsToMany(Tache::class);
    }

    public function fournisseurs(): BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class);
    }

}
