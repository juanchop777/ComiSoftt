<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralCommittee extends Model
{
    use HasFactory;

    protected $table = 'general_committees';
    protected $primaryKey = 'general_committee_id';

    protected $fillable = [
        'session_date',
        'session_time',
        'minutes_date',
        'access_link',
        'minutes_id',
        'act_number',
        'trainee_name',
        'committee_mode',
        'attendance_mode',
        'offense_class',
        'fault_type',
        'offense_classification',
        'statement',
        'general_statements',
        'individual_statements',
        'decision',
        'commitments',
        'missing_rating',
        'recommendations',
        'observations',
        'id_document',
        'program_name',
        'batch_number',
        'email',
        'company_name',
        'company_address',
        'incident_type',
        'reception_date',
        'hr_manager_name',
        'hr_responsible',
        'company_contact',
        'incident_description',
    ];

    public function minutes()
    {
        return $this->belongsTo(Minute::class, 'minutes_id');
    }
}


