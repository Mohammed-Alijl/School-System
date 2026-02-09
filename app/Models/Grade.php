<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;
    protected $fillable = [
        'name',
        'notes',
        'status',
        'sort_order'
    ];

    public $translatable = ['name'];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }
}
