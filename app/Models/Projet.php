<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projet extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projets';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'description',
        'localisation',
        'start',
        'end',
        'etat',
    ];

    public function taches(): HasMany
    {
        return $this->hasMany(Tache::class);
    }
}
