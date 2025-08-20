<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('Committee', function (Blueprint $table) {
            if (!Schema::hasColumn('Committee', 'offense_class')) {
                $table->string('offense_class')->nullable()->after('offense_classification');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Committee', function (Blueprint $table) {
            if (Schema::hasColumn('Committee', 'offense_class')) {
                $table->dropColumn('offense_class');
            }
        });
    }
};
