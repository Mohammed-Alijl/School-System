<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherAttachment extends Model
{
    protected $fillable = [
      'teacher_id',
      'attachment',
    ];

    // ─── Relationships ─────────────────────────────────────────
    public function teacher(): BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

}
