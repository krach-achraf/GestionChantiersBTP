<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function taches(): BelongsToMany
    {
        return $this->belongsToMany(Tache::class);
    }

    public function fournisseurs(): BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class);
    }
}
