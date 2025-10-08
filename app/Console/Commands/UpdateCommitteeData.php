<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\IndividualCommittee;
use App\Models\Minute;

class UpdateCommitteeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:committee-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing committee data with missing company contact and HR responsible fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $committees = IndividualCommittee::all();
        $updated = 0;
        
        foreach ($committees as $committee) {
            $minute = Minute::find($committee->minutes_id);
            if ($minute) {
                $committee->company_contact = $minute->company_contact;
                $committee->hr_responsible = $minute->hr_manager_name;
                $committee->save();
                $updated++;
                $this->info("Updated committee ID: {$committee->individual_committee_id}");
            }
        }
        
        $this->info("Updated {$updated} committees successfully!");
    }
}
