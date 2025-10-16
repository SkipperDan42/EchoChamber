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
        Schema::create('posts', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('user_id')     // The author
                        -> constrained()                 // ?????   Shortcut for references('id')->on('users')   ?????
                        -> onDelete('cascade');   // Delete posts if the user is deleted
            $table -> string('title');
            $table -> string('content');
            $table -> integer('heard');
            $table -> unsignedBigInteger('echoed')
                        -> nullable();
            $table -> integer('echoes');
            $table -> integer('claps');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
