<?php

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->integer('prix');
            $table->integer('stock');
            $table->unsignedBigInteger('fournisseurs_id');
            $table->unsignedBigInteger('categories_id');
            $table->json('fournisseurs_id');
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->string('REF');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
