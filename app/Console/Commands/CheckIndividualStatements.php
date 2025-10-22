<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GeneralCommittee;
use App\Models\Minute;

class CheckIndividualStatements extends Command
{
    protected $signature = 'check:individual-statements {act_number}';
    protected $description = 'Verifica los descargos individuales para un act_number específico';

    public function handle()
    {
        $actNumber = $this->argument('act_number');
        
        $this->info("Verificando descargos individuales para acta: {$actNumber}");
        
        // Obtener todos los comités generales para este act_number
        $committees = GeneralCommittee::where('act_number', $actNumber)->get();
        
        $this->info("Encontrados " . $committees->count() . " registros de comité general");
        
        foreach ($committees as $index => $committee) {
            $this->line("\n--- Registro #" . ($index + 1) . " ---");
            $this->line("ID: {$committee->general_committee_id}");
            $this->line("Aprendiz: {$committee->trainee_name}");
            $this->line("Minutes ID: {$committee->minutes_id}");
            
            if ($committee->individual_statements) {
                $statements = json_decode($committee->individual_statements, true);
                $this->line("Descargos individuales:");
                if (is_array($statements)) {
                    foreach ($statements as $key => $statement) {
                        $this->line("  - {$key}: " . substr($statement, 0, 50) . "...");
                    }
                } else {
                    $this->line("  - Formato inválido: " . $committee->individual_statements);
                }
            } else {
                $this->line("Sin descargos individuales");
            }
        }
        
        // Obtener los minutos para este act_number
        $minutes = Minute::where('act_number', $actNumber)->get();
        $this->line("\n--- Minutos para este act_number ---");
        $this->line("Encontrados " . $minutes->count() . " registros de minutos");
        
        foreach ($minutes as $index => $minute) {
            $this->line("Minute #" . ($index + 1) . ": {$minute->trainee_name} (ID: {$minute->minutes_id})");
        }
    }
}