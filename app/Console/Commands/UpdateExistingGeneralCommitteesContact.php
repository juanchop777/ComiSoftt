<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GeneralCommittee;
use App\Models\Minute;
use Illuminate\Support\Facades\DB;

class UpdateExistingGeneralCommitteesContact extends Command
{
    protected $signature = 'update:general-committees-contact';
    protected $description = 'Actualiza el campo company_contact en general_committees con datos de minutes';

    public function handle()
    {
        $this->info('Iniciando actualización de company_contact en general_committees...');
        
        $updatedCount = 0;
        $errorCount = 0;
        
        // Obtener todos los comités generales
        $committees = GeneralCommittee::all();
        
        foreach ($committees as $committee) {
            try {
                // Buscar el minute correspondiente por minutes_id
                $minute = Minute::find($committee->minutes_id);
                
                if ($minute && $minute->company_contact) {
                    // Actualizar el company_contact del comité con el del minute
                    $committee->update([
                        'company_contact' => $minute->company_contact
                    ]);
                    
                    $updatedCount++;
                    $this->line("✓ Actualizado comité ID: {$committee->general_committee_id} - Contacto: {$minute->company_contact}");
                } else {
                    $this->warn("⚠ No se encontró minute o company_contact para comité ID: {$committee->general_committee_id}");
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("✗ Error actualizando comité ID: {$committee->general_committee_id} - {$e->getMessage()}");
            }
        }
        
        $this->info("\n=== RESUMEN ===");
        $this->info("Comités actualizados: {$updatedCount}");
        $this->info("Errores: {$errorCount}");
        $this->info("Total procesados: " . $committees->count());
        
        if ($updatedCount > 0) {
            $this->info("\n¡Actualización completada exitosamente!");
        } else {
            $this->warn("\nNo se actualizaron registros. Verifica que los datos en minutes tengan company_contact.");
        }
    }
}