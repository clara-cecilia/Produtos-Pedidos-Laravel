<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pedido_produto', function (Blueprint $table) {
        // Primeiro remove a constraint existente se houver
        $table->dropForeign(['produto_id']);
        
        // Depois renomeia a coluna se necessário
        if (Schema::hasColumn('pedido_produto', 'produtos_id')) {
            $table->renameColumn('produtos_id', 'produto_id');
        }
        
        // Finalmente recria a constraint com um nome único
        $table->foreign('produto_id', 'fk_pedido_produto_produto_id')
              ->references('id')
              ->on('produtos')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('pedido_produto', function (Blueprint $table) {
        $table->dropForeign('fk_pedido_produto_produto_id');
        
        if (Schema::hasColumn('pedido_produto', 'produto_id')) {
            $table->renameColumn('produto_id', 'produtos_id');
        }
    });
}
};
