<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FournisseurArticle extends Model
{
    use HasFactory;
    protected $table = 'fournisseur_article';

    protected $fillable = [
        'article_id',
        'fournisseur_id',
    ];
}
