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

            $table->id();
            $table->foreignId('user_id')     // The author
                    ->constrained()                 // Shortcut for references('id')->on('users')
                    ->onDelete('cascade');   // Delete posts if the user is deleted
            $table->foreignId('post_id')    // The post
                    ->constrained()
                    ->onDelete('cascade');
            $table->string('content');
            $table->timestamps();
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
