<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    //

    protected $fillable = [
        'data',
    ];

    /**
     *
     * @var array
     */
    protected $appends = [
        'person',
    ];

    public function getPersonAttribute()
    {
        $person = $this->belongsTo(Person::class, 'recepient_id')->orderBy('id', 'DESC');
        return $person->first();
    }

}
