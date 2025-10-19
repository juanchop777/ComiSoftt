<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalMinute extends Model
{
    protected $fillable = [
        'act_number',
        'committee_name',
        'city',
        'date',
        'start_time',
        'end_time',
        'place_link',
        'address_regional_center',
        'conclusions',
        'attachments'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'attachments' => 'array'
    ];
}
