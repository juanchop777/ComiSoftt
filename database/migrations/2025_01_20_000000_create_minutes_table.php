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
        Schema::create('minutes', function (Blueprint $table) {
            $table->id('minutes_id');
            $table->string('act_number', 20);
            $table->date('minutes_date')->nullable();
            $table->string('trainee_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('id_document', 30)->nullable();
            $table->string('program_name', 100)->nullable();
            $table->string('batch_number', 20)->nullable();
            $table->unsignedTinyInteger('has_contract');
            $table->string('company_name', 100)->nullable();
            $table->string('company_address', 150)->nullable();
            $table->string('hr_manager_name', 100)->nullable();
            $table->string('company_contact', 150)->nullable();
            $table->enum('incident_type', ['Academic', 'Disciplinary', 'Other'])->nullable();
            $table->text('incident_description')->nullable();
            $table->date('reception_date')->nullable();
            $table->unsignedBigInteger('reporting_person_id');
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutes');
    }
};
