<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $fillable = [
        'first_name', 'last_name', 'dob', 'weight', 'ethnicity', 'gender', 'email', 'phone', 'last_active', 'isOnline',
    ];
    protected $appends = [
        'blood_group',
    ];

    public function getBloodGroupAttribute()
    {
        $group = $this->belongsTo(BloodGroup::class, 'person_id');
        return $group->first();
    }
}
