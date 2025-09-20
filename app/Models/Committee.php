<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table = 'committees';
    protected $primaryKey = 'committee_id';
    public $timestamps = false;

    protected $fillable = [
        'session_date',
        'session_time',
        'minutes_date',
        'access_link',
        'minutes_id',
        'act_number',
        'trainee_name',
        'statement',
        'offense_classification',
        'offense_class',
        'fault_type',
        'decision',
        'commitments',
        'missing_rating',
        'recommendations',
        'observations',
        'attendance_mode',
        'committee_mode',
        'general_statements',
        'individual_statements'
    ];

    // 🔹 Relación: un Comité pertenece a un Acta
    public function minutes()
    {
        return $this->belongsTo(Minute::class, 'minutes_id', 'minutes_id');
    }
}


















