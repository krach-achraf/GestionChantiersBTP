<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';

    protected $fillable = ['id','article_id','quantite','unite'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

}
