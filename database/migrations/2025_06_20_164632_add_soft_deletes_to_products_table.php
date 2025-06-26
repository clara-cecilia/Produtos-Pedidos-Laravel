<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) { // Alterado para 'produtos'
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) { // Alterado para 'produtos'
            $table->dropColumn('is_active');
            $table->dropSoftDeletes();
        });
    }
};