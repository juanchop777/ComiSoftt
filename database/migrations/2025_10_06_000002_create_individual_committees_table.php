<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('individual_committees', function (Blueprint $table) {
            $table->id('individual_committee_id');

            // Sesión
            $table->date('session_date');
            $table->time('session_time');
            $table->date('minutes_date')->nullable();
            $table->string('access_link')->nullable();

            // Identificación de minute/aprendiz
            $table->unsignedBigInteger('minutes_id');
            $table->string('act_number');
            $table->string('trainee_name');

            // Modo de comité (fijo Individual)
            $table->enum('committee_mode', ['General','Individual'])->default('Individual');

            // Datos del aprendiz/empresa e incidente (copiados desde minutes al crear)
            $table->string('id_document')->nullable();
            $table->string('program_name')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('email')->nullable();
            // Datos de empresa (opcionales)
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('incident_type')->nullable();
            $table->date('reception_date')->nullable();
            $table->string('hr_responsible')->nullable();
            $table->string('hr_contact')->nullable();
            $table->longText('incident_description')->nullable();

            // Configuración del comité
            $table->enum('attendance_mode', ['Presencial','Virtual','No asistió'])->nullable();
            $table->enum('offense_class', ['Leve','Grave','Muy Grave'])->nullable();
            $table->text('fault_type')->nullable();
            $table->text('offense_classification')->nullable();

            // Descargos (compatibilidad total)
            $table->longText('statement')->nullable();
            $table->longText('general_statements')->nullable();
            $table->longText('individual_statements')->nullable();

            // Decisiones y seguimiento
            $table->longText('decision')->nullable();
            $table->longText('commitments')->nullable();
            $table->longText('missing_rating')->nullable();
            $table->longText('recommendations')->nullable();
            $table->longText('observations')->nullable();

            $table->timestamps();

            // Índices
            $table->index('minutes_id');
            $table->index('act_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('individual_committees');
    }
};


