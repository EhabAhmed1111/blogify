<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            // this is the one who follow
            $table->foreignId('follower_id')->constrained("users")->cascadeOnDelete();
            // this is the one who is followed
            $table->foreignId('following_id')->constrained("users")->cascadeOnDelete();
            $table->timestamps();

            // prevent duplicate follows
            $table->unique(['follower_id', 'following_id']);

            // prevent that same person follow himself
            // $table->check("follower_id != following_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
