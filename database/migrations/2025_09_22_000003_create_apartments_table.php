<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // Provider ID as PK
            $table->unsignedBigInteger('floor_id');

            $table->string('type_name')->nullable();
            $table->json('selected_orientations')->nullable();
            $table->string('friendly_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('website_latitude', 10, 8);
            $table->decimal('website_longitude', 11, 8);
            $table->string('website_address');
            $table->decimal('room_count', 3, 1);
            $table->decimal('usable_size_sqm', 8, 2);
            $table->decimal('built_size_sqm', 8, 2)->nullable();
            $table->integer('year_built')->nullable();
            $table->enum('built_state', ['under_construction', 'project', 'finished', 'coming_soon']);
            $table->integer('bathroom_count');
            $table->integer('floor_count');
            $table->decimal('sale_price', 10, 2);
            $table->decimal('promo_sale_price', 10, 2)->nullable();
            $table->decimal('price_per_sqm', 10, 2)->nullable();
            $table->string('floor_value');
            $table->enum('home_type', ['apartment', 'studio', '1bedroom', 'penthouse', 'duplex']);
            $table->string('layout_value')->nullable();
            $table->string('confort_value')->nullable();
            $table->decimal('balcony_size_sqm', 8, 2)->nullable();
            $table->decimal('total_size_sqm', 8, 2)->nullable();
            $table->decimal('garden_size_sqm', 8, 2)->nullable();
            $table->enum('availability', ['available', 'unavailable', 'sold', 'let', 'reserved']);
            $table->enum('kitchen_type', ['opened', 'closed'])->nullable();
            $table->string('number')->nullable();
            $table->json('utility_values')->nullable();
            $table->json('facility_values')->nullable();
            $table->json('finish_values')->nullable();
            $table->json('service_values')->nullable();
            $table->json('zone_detail_values')->nullable();
            $table->unsignedInteger('balcony_count')->nullable();
            $table->unsignedInteger('kitchen_count')->nullable();
            $table->unsignedInteger('garage_count')->nullable();
            $table->unsignedInteger('parking_spots_count')->nullable();
            $table->unsignedInteger('terrace_count')->nullable();
            $table->decimal('terrace_size_sqm', 8, 2)->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->json('videos')->nullable();
            $table->unsignedTinyInteger('energy_efficiency_class')->nullable();
            $table->timestamp('api_created_at')->nullable();
            $table->timestamp('api_updated_at')->nullable();
            $table->boolean('website_published')->default(false);
            $table->boolean('promo')->default(false);
            $table->string('zone')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable(); // provider value
            $table->json('documents')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->text('g_content')->nullable();

            $table->timestamps();

            $table->foreign('floor_id')->references('id')->on('floors')->cascadeOnDelete();
            $table->unique('friendly_id');
            // home_type is not used for filtering in practice (mostly 'apartment'), so omit index.
            $table->index('room_count');
            $table->index('availability');
            $table->index('project_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
