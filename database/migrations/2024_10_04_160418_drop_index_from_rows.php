<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rows', function (Blueprint $table) {
            $table->dropColumn('index');
        });
    }

    public function down(): void
    {
        Schema::table('rows', function (Blueprint $table) {
            $table->integer('index');
        });
    }
};
