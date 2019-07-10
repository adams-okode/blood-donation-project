<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    //
    /**
     *
     * @var array
     */
    protected $appends = [
        'person',
    ];

    public function getPersonAttribute()
    {
        $person = $this->belongsTo(Person::class, 'person_id');
        return $person->first();
    }
}
