<?php

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
        Schema::create('article_ventes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('categorie_id'); 
            $table->boolean('promo')->default(false);
            $table->decimal('promo_value', 10, 2)->nullable();
            $table->decimal('price', 10, 2);
            $table->string('reference')->nullable();
            $table->string('photo');
            $table->decimal('margin', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_ventes');
    }
};
