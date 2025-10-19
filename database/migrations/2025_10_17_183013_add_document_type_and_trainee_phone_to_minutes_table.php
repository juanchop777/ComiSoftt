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
            $table->string('document_type', 10)->nullable()->after('id_document');
            $table->string('trainee_phone', 20)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minutes', function (Blueprint $table) {
            $table->dropColumn(['document_type', 'trainee_phone']);
        });
    }
};
