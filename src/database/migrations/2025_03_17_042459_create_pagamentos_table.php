<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->decimal('valor');
            $table->date('data');
            $table->foreignId('categoria_id');
            $table->enum('metodo_pagamento', ['Pix', 'Cartão Black', 'Cartão Amazon', 'Cartão Inter']);
            $table->boolean('pago')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
