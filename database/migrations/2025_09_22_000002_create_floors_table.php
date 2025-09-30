<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->id(); // Local auto-increment ID
            $table->unsignedBigInteger('building_id');
            $table->integer('level');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('floor_d', 191);
            $table->string('floor_transform', 191);
            $table->string('floor_svg_viewbox', 191);
            $table->string('floor_plan');
            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
            $table->index(['building_id', 'level']);
            $table->unique(['building_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};
