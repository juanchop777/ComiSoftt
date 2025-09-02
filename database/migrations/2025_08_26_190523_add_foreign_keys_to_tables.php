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
            $table->foreign('reporting_person_id')->references('reporting_person_id')->on('reporting_persons');
        });

        Schema::table('committees', function (Blueprint $table) {
            $table->foreign('minutes_id')->references('minutes_id')->on('minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->dropForeign(['minutes_id']);
        });

        Schema::table('minutes', function (Blueprint $table) {
            $table->dropForeign(['reporting_person_id']);
        });
    }
};
