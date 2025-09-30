<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('floors', function (Blueprint $table) {
            // Store multiple SVG shapes for a floor as an array of objects: [{ d, transform }]
            $table->json('shape_paths')->nullable()->after('floor_plan');
            // Group-level transform for multi-shape floors (wrapping <g> transform)
            if (! Schema::hasColumn('floors', 'group_transform')) {
                $table->string('group_transform')->nullable()->after('floor_transform');
            }
            // Make existing single-shape columns nullable so multi-shape floors can coexist
            if (Schema::hasColumn('floors', 'floor_d')) {
                $table->text('floor_d')->nullable()->change();
            }
            if (Schema::hasColumn('floors', 'floor_transform')) {
                $table->string('floor_transform')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('floors', function (Blueprint $table) {
            // Drop the new columns first (only if they exist)
            if (Schema::hasColumn('floors', 'shape_paths')) {
                $table->dropColumn('shape_paths');
            }
            if (Schema::hasColumn('floors', 'group_transform')) {
                $table->dropColumn('group_transform');
            }

            // Before making columns NOT NULL again, ensure no NULL values remain
            // to avoid SQL warnings about data truncation. Set NULL floor_d/floor_transform
            // to empty strings as a safe default.
            if (Schema::hasColumn('floors', 'floor_d')) {
                // Use a raw query because Blueprint can't update data rows.
                DB::table('floors')->whereNull('floor_d')->update(['floor_d' => '']);
                $table->text('floor_d')->nullable(false)->change();
            }
            if (Schema::hasColumn('floors', 'floor_transform')) {
                DB::table('floors')->whereNull('floor_transform')->update(['floor_transform' => '']);
                $table->string('floor_transform')->nullable(false)->change();
            }
        });
    }
};
