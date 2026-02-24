<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'joining_date',
        'gender_id',
        'status',
        'image',
        'attachments',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function gender(): BelongsTo {
        return $this->belongsTo(Gender::class);
    }

    public function attachments(): HasMany {
        return $this->hasMany(TeacherAttachment::class,'teacher_id');
    }



    // ─── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Only active teachers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
