<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->foreignId('specialization_id')
                  ->constrained('specializations')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
            $table->foreignId('grade_id')
                  ->constrained('grades')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
            $table->foreignId('classroom_id')
                  ->constrained('class_rooms')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('admins')
                  ->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
