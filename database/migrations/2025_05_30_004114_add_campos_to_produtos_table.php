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
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('nome')->nullable();
            $table->decimal('custo', 8, 2)->nullable();
            $table->decimal('preco', 8, 2)->nullable();
            $table->integer('quantidade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['nome', 'custo', 'preco', 'quantidade']);
        });
    }
};
