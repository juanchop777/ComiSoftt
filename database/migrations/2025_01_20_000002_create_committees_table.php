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
        Schema::create('committees', function (Blueprint $table) {
            $table->id('committee_id');
            $table->date('session_date')->nullable();
            $table->time('session_time')->nullable();
            $table->date('minutes_date')->nullable();
            $table->string('act_number', 20)->nullable();
            $table->string('access_link', 255)->nullable();
            $table->unsignedBigInteger('minutes_id')->nullable();
            $table->string('trainee_name', 100)->nullable();
            $table->text('statement')->nullable();
            $table->text('decision')->nullable();
            $table->text('commitments')->nullable();
            $table->text('offense_classification')->nullable();
            $table->string('offense_class', 255)->nullable();
            $table->string('fault_type', 255)->nullable();
            $table->text('missing_rating')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('observations')->nullable();
            $table->string('attendance_members', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
