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
        Schema::create('comment_claps', function (Blueprint $table) {
            $table  -> foreignId('user_id')             // The clapper
                    -> constrained()                            // Shortcut for references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table  -> foreignId('comment_id')           // The comment
                    -> constrained()                            // Shortcut for references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'comment_id']);         // prevents duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_claps');
    }
};
