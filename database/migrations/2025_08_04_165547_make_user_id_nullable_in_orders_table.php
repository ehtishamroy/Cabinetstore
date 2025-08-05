<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to modify the column directly
        DB::statement('ALTER TABLE orders MODIFY COLUMN user_id BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original non-nullable column
        DB::statement('ALTER TABLE orders MODIFY COLUMN user_id BIGINT UNSIGNED NOT NULL');
    }
};
