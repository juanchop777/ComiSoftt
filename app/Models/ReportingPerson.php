<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportingPerson extends Model
{
    protected $table = 'reporting_persons';
    protected $primaryKey = 'reporting_person_id';
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'email',
        'phone'
    ];

    public function minutes()
    {
        return $this->hasMany(Minute::class, 'reporting_person_id', 'reporting_person_id');
    }
}
