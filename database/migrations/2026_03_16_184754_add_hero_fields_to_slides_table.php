<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('type')->default('standard')->after('id');
            $table->string('image_right')->nullable()->after('image');
            $table->string('link_right')->nullable()->after('link');
            $table->string('link_left_text')->nullable()->after('link_right');
            $table->string('link_right_text')->nullable()->after('link_left_text');
        });
        Schema::table('slides', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->change();
        });
    }

    
    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn(['type', 'image_right', 'link_right', 'link_left_text', 'link_right_text']);
            $table->string('subtitle')->nullable(false)->change();
        });
    }
};
