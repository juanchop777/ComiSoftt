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
        Schema::table('individual_committees', function (Blueprint $table) {
            $table->string('document_type', 10)->nullable()->after('id_document');
            $table->string('trainee_phone', 20)->nullable()->after('email');
            $table->string('program_type', 100)->nullable()->after('program_name');
            $table->string('trainee_status', 50)->nullable()->after('program_type');
            $table->string('training_center', 255)->nullable()->after('trainee_status');
            $table->string('incident_subtype', 100)->nullable()->after('incident_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individual_committees', function (Blueprint $table) {
            $table->dropColumn([
                'document_type',
                'trainee_phone', 
                'program_type',
                'trainee_status',
                'training_center',
                'incident_subtype'
            ]);
        });
    }
};
