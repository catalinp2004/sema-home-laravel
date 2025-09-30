<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartment_images', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // Provider ID as PK
            $table->unsignedBigInteger('apartment_id');
            $table->integer('sort_order')->nullable();
            $table->string('url');
            $table->string('width_320_url');
            $table->string('width_560_url');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('image_processing')->default(false);
            $table->timestamp('api_created_at')->nullable();
            $table->timestamps();

            $table->foreign('apartment_id')->references('id')->on('apartments')->cascadeOnDelete();
            $table->index('apartment_id');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartment_images');
    }
};
