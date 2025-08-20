<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minutes extends Model
{
    protected $table = 'Minutes';
    protected $primaryKey = 'minutes_id';
    public $timestamps = false;

    protected $fillable = [
        'act_number',
        'minutes_date',
        'trainee_name',
        'email',
        'id_document',
        'program_name',
        'batch_number',
        'has_contract',
        'company_name',
        'company_address',
        'hr_manager_name',
        'company_contact',
        'incident_type',
        'incident_description',
        'reception_date',
        'reporting_person_id'
    ];

    public function reportingPerson()
    {
        return $this->belongsTo(ReportingPerson::class, 'reporting_person_id', 'reporting_person_id');
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
