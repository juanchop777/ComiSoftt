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
            $table->string('offense_class')->nullable()->after('offense_classification');
            $table->string('fault_type')->nullable()->after('offense_class');
            $table->text('decision')->nullable()->after('statement');
            $table->text('commitments')->nullable()->after('decision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Committee', function (Blueprint $table) {
            $table->dropColumn(['offense_class', 'fault_type', 'decision', 'commitments']);
        });
    }
};
