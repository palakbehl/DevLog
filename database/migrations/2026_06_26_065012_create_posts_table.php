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

        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // creates a foreign key to the users table and sets up cascading deletes meaning if a user is deleted, all their posts will be deleted as well

        $table->string('title');

        $table->string('slug')->unique(); // slug is a URL-friendly version of the title, and it should be unique for each post meaning no two posts can have the same slug

        $table->longText('content');

        $table->string('featured_image')->nullable();

        $table->boolean('is_published')->default(false);

        $table->timestamps();
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
