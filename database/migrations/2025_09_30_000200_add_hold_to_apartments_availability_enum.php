<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add 'hold' to the availability ENUM. Use raw SQL for broad compatibility.
        DB::statement("ALTER TABLE `apartments` MODIFY `availability` ENUM('available','unavailable','sold','let','reserved','hold') NOT NULL");
    }

    public function down(): void
    {
        // Remove 'hold' from the ENUM definition (revert to previous set)
        DB::statement("ALTER TABLE `apartments` MODIFY `availability` ENUM('available','unavailable','sold','let','reserved') NOT NULL");
    }
};
