<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id(); // Local auto-increment ID
            $table->string('slug')->unique();
            $table->string('name')->nullable();
            $table->string('render');
            $table->string('building_d', 191);
            $table->string('building_transform', 191);
            $table->string('floor_svg_viewbox', 191);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
