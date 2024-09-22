<?php

use App\Models\Row;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cells', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Row::class);
            $table->integer('index');
            $table->integer('x');
            $table->integer('y');
            $table->string('value');
            $table->boolean('is_mine');
            $table->boolean('is_flag')->default(false);
            $table->boolean('is_revealed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cells');
    }
};
