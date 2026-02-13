<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Guardian extends Authenticatable
{
    use HasFactory, Notifiable, HasTranslations, SoftDeletes;

    protected $guarded = [];

    public $translatable = [
        'name_father',
        'job_father',
        'name_mother',
        'job_mother'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function nationalityFather()
    {
        return $this->belongsTo(Nationality::class, 'nationality_father_id');
    }

    public function religionFather()
    {
        return $this->belongsTo(Religion::class, 'religion_father_id');
    }

    public function nationalityMother()
    {
        return $this->belongsTo(Nationality::class, 'nationality_mother_id');
    }

    public function religionMother()
    {
        return $this->belongsTo(Religion::class, 'religion_mother_id');
    }

}
