<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fournisseur extends Model
{
    use HasFactory;
    protected $table = 'fournisseurs';

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function materiels(): BelongsToMany
    {
        return $this->belongsToMany(Materiel::class);
    }
}
