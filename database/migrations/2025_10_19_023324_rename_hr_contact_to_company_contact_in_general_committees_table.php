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
        Schema::table('general_committees', function (Blueprint $table) {
            $table->renameColumn('hr_contact', 'company_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_committees', function (Blueprint $table) {
            $table->renameColumn('company_contact', 'hr_contact');
        });
    }
};
