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
            $table->string('training_center', 255)->nullable()->after('incident_subtype');
            $table->string('program_type', 100)->nullable()->after('training_center');
            $table->string('trainee_status', 50)->nullable()->after('program_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minutes', function (Blueprint $table) {
            $table->dropColumn(['training_center', 'program_type', 'trainee_status']);
        });
    }
};
