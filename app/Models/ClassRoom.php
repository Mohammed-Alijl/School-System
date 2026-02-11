<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ClassRoom extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = ['name', 'grade_id', 'status', 'sort_order', 'notes'];

    public $translatable = ['name'];


    //===============================================================
    //======================== RELATIONSHIPS ========================
    //===============================================================
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function sections(): HasMany {
        return $this->hasMany(Section::class, 'classroom_id');
    }
}
