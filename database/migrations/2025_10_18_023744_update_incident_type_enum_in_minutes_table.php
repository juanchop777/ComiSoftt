<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cambiar la columna incident_type de ENUM a VARCHAR para permitir los nuevos valores
        DB::statement("ALTER TABLE minutes MODIFY COLUMN incident_type VARCHAR(50) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a ENUM con los valores originales
        DB::statement("ALTER TABLE minutes MODIFY COLUMN incident_type ENUM('Academic', 'Disciplinary', 'Dropout') NULL");
    }
};
