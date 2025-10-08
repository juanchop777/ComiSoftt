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
        Schema::table('committees', function (Blueprint $table) {
            // Información del Aprendiz
            $table->string('id_document', 50)->nullable()->after('trainee_name');
            $table->string('program_name', 100)->nullable()->after('id_document');
            $table->string('batch_number', 50)->nullable()->after('program_name');
            $table->string('email', 100)->nullable()->after('batch_number');
            
            // Información de la Empresa
            $table->string('company_name', 100)->nullable()->after('email');
            $table->text('company_address')->nullable()->after('company_name');
            
            // Información del Incidente
            $table->string('incident_type', 100)->nullable()->after('company_address');
            $table->date('reception_date')->nullable()->after('incident_type');
            $table->string('hr_responsible', 100)->nullable()->after('reception_date');
            $table->string('hr_contact', 50)->nullable()->after('hr_responsible');
            $table->text('incident_description')->nullable()->after('hr_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->dropColumn([
                'id_document',
                'program_name', 
                'batch_number',
                'email',
                'company_name',
                'company_address',
                'incident_type',
                'reception_date',
                'hr_responsible',
                'hr_contact',
                'incident_description'
            ]);
        });
    }
};
