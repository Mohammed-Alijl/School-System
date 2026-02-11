<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'name',
        'notes',
        'status',
        'sort_order',
        'classroom_id',
        'section_id'
    ];

    public $translatable = ['name'];


    //======================== SCOPES ========================
    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }


    //======================== RELATIONSHIPS ========================
    public function grades(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class,'classroom_id','id');
    }

}
