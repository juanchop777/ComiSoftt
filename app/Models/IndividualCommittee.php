<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualCommittee extends Model
{
    use HasFactory;

    protected $table = 'individual_committees';
    protected $primaryKey = 'individual_committee_id';

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
        'document_type',
        'program_name',
        'program_type',
        'trainee_status',
        'training_center',
        'batch_number',
        'email',
        'trainee_phone',
        'company_name',
        'company_address',
        'hr_contact',
        'company_contact',
        'incident_type',
        'incident_subtype',
        'reception_date',
        'hr_responsible',
        'incident_description',
    ];

    // Relación con minutes
    public function minutes()
    {
        return $this->belongsTo(Minute::class, 'minutes_id', 'minutes_id');
    }
}


