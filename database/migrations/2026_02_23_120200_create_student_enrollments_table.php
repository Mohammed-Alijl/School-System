<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('classroom_id')->constrained('class_rooms')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('enrollment_status', 20);
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'academic_year_id']);
            $table->index(['academic_year_id', 'grade_id', 'classroom_id', 'section_id'], 'student_enrollments_scope_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enrollments');
    }
};
