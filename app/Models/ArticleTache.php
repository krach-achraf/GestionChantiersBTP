<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleTache extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'article_tache';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'article_id',
        'tache_id',
        'fournisseur_id',
        'quantité',
        'priorité',
        'unité',
        'dateCommande',
        'dateReception',
        'étatCommande',
        'validité',
    ];

}
