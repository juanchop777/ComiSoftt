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
        // Eliminar todas las tablas del módulo de meetings
        Schema::dropIfExists('meetings');
        Schema::dropIfExists('commitments');
        Schema::dropIfExists('attendee_approvals');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar las tablas eliminadas
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('act_number');
            $table->string('committee_name');
            $table->string('city_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('place_link')->nullable();
            $table->string('address_regional_center')->nullable();
            $table->text('conclusions')->nullable();
            $table->timestamps();
            
            $table->foreign('act_number')->references('act_number')->on('minutes');
        });

        Schema::create('commitments', function (Blueprint $table) {
            $table->id();
            $table->text('conclusions')->nullable();
            $table->string('activity_decision');
            $table->date('date');
            $table->string('responsible', 150);
            $table->string('virtual_signature', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('attendee_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('company_dependency', 150);
            $table->enum('approves', ['SI', 'NO']);
            $table->text('observation')->nullable();
            $table->string('virtual_signature', 255)->nullable();
            $table->longblob('attachments')->nullable();
            $table->timestamps();
        });
    }
};
