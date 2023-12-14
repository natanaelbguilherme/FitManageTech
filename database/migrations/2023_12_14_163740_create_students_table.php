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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->string('email')->unique();
            $table->date('date_birth');
            $table->string('cpf', 20)->unique();
            $table->string('contact', 20);
            $table->string('city', 50);
            $table->string('neighborhood', 50);
            $table->string('number', 30);
            $table->string('street', 30);
            $table->string('state', 2);
            $table->string('cep', 20);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
