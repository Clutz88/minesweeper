<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->integer('mine_count')->nullable()->after('state');
            $table->integer('width')->nullable()->after('mine_count');
            $table->integer('height')->nullable()->after('width');
        });
    }

    public function down(): void
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->dropColumn(['mine_count', 'width', 'height']);
        });
    }
};
