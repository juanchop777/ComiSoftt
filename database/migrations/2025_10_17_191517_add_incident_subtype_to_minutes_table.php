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
        Schema::table('minutes', function (Blueprint $table) {
            $table->string('incident_subtype', 100)->nullable()->after('incident_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minutes', function (Blueprint $table) {
            $table->dropColumn('incident_subtype');
        });
    }
};
