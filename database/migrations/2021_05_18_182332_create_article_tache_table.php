<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tache', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained();
            $table->foreignId('tache_id')->constrained();
            $table->foreignId('fournisseur_id')->constrained();
            $table->float('quantité');
            $table->integer('priorité');
            $table->string('unité');
            $table->date('dateReception')->nullable();
            $table->string('étatCommande')->default('En commande');
            $table->string('validité')->default('En attend');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_tache');
    }
}
