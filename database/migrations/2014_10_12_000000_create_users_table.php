<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone');
            $table->string('nascimento');
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('imagem');
            $table->string('usina');
            $table->boolean('status');
            $table->timestamp('ultimo_acesso')->nullable();
            $table->integer('numero_acessos')->default(0);
            $table->integer('acessos_consecutivos')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
