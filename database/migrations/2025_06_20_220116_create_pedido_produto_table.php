<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('pedido_produto')) {
            Schema::create('pedido_produto', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
                $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
                $table->integer('quantidade');
                $table->decimal('preco_unitario', 10, 2);
                $table->timestamps();
                $table->unique(['pedido_id', 'produto_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('pedido_produto');
    }
}
?>
