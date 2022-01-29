<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterielFournisseur extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'fournisseur_materiel';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'materiel_id',
        'fournisseur_id',
        'dateAccuse',
    ];

}
