<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('site_experience_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('rating'); 
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id', 100)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('session_id');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('site_experience_ratings');
    }
};
