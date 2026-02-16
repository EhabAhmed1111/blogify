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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');

            // I think null on delete will be more good
            // or maybe change user name to deleted user 
            $table->foreignId('author_id')->constrained('users')->noActionOnDelete();
            // this will be used for media in the specific blog
            // $table->foreignId('media_id')->constrained()->cascadeOnDelete();
            // will also has slug or key word 
            // also number of reader 
            // also number of likes 
            // also number of comments 

            // status of the post (Draft, Published, Archived)


            // this could be in future
            $table->timestamp('publish_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
