<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterielTacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiel_tache', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materiel_id')->constrained();
            $table->foreignId('tache_id')->constrained();
            $table->date('dateDebut');
            $table->date('dateFin');
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
        Schema::dropIfExists('materiel_tache');
    }
}
