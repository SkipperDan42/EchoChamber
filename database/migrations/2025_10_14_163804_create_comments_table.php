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
        Schema::create('comments', function (Blueprint $table) {

            $table -> id();
            $table -> foreignId('user_id')
                        -> constrained()                 // Shortcut for references('id')->on('users')
                        -> onDelete('cascade');   // Delete comments if the user is deleted
            $table -> foreignId('post_id')
                        -> constrained()
                        -> onDelete('cascade');  // Delete comments if the post is deleted
            $table -> string('content');
            $table -> integer('heard');
            $table -> integer('claps');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
