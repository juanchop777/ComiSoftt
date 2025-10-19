<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    protected $table = 'minutes';
    protected $primaryKey = 'minutes_id';
    public $timestamps = false;

    protected $fillable = [
        'act_number',
        'minutes_date',
        'trainee_name',
        'email',
        'id_document',
        'document_type',
        'trainee_phone',
        'program_name',
        'batch_number',
        'training_center',
        'program_type',
        'trainee_status',
        'has_contract',
        'company_name',
        'company_address',
        'hr_manager_name',
        'company_contact',
        'incident_type',
        'incident_subtype',
        'incident_description',
        'reception_date',
        'reporting_person_id'
    ];

    public function reportingPerson()
    {
        return $this->belongsTo(ReportingPerson::class, 'reporting_person_id', 'reporting_person_id');
    }

    /**
     * Get the meeting associated with this minute.
     */
    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'act_number', 'act_number');
    }

    /**
     * Get the individual committees associated with this minute.
     */
    public function individualCommittees()
    {
        return $this->hasMany(IndividualCommittee::class, 'minutes_id', 'minutes_id');
    }

    /**
     * Get the general committees associated with this minute.
     */
    public function generalCommittees()
    {
        return $this->hasMany(GeneralCommittee::class, 'minutes_id', 'minutes_id');
    }

    protected $casts = [
        'has_contract' => 'boolean',
        'minutes_date' => 'date',
        'reception_date' => 'date'
    ];

    // 🔹 AÑADIDO: clave primaria incremental tipo entero
    public $incrementing = true;
    protected $keyType = 'int';

    // 🔹 AÑADIDO: relación con Comité
    public function committees()
    {
        return $this->hasMany(Committee::class, 'minutes_id', 'minutes_id');
    }
}
