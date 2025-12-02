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
        Schema::create('post_claps', function (Blueprint $table) {
            $table  -> foreignId('user_id')             // The clapper
                    -> constrained()                            // Shortcut for references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table  -> foreignId('post_id')             // The post
                    -> constrained()                            // Shortcut for references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'post_id']);            // prevents duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_claps');
    }
};
