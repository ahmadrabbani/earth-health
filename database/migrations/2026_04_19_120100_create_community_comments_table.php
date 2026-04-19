<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_post_id')->constrained()->cascadeOnDelete();
            $table->string('auth0_user_id');
            $table->string('author_name');
            $table->string('author_email')->nullable();
            $table->text('body');
            $table->timestamps();

            $table->index('auth0_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_comments');
    }
};
