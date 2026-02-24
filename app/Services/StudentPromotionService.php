<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentPromotionService
{
    public function getLookups()
    {
        return [
            'grades' => Grade::all(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
        ];
    }

    public function hasPromotionFilters(array $filters): bool
    {
        return !empty($filters['from_grade_id'])
            && !empty($filters['from_classroom_id'])
            && !empty($filters['from_section_id'])
            && !empty($filters['from_academic_year_id']);
    }

    public function getStudentsForPromotion(array $filters)
    {
        if (!$this->hasPromotionFilters($filters)) {
            return collect();
        }

        $fromYearName = $this->getAcademicYearName($filters['from_academic_year_id']);

        return Student::with(['grade', 'classroom', 'section', 'guardian'])
            ->where('grade_id', $filters['from_grade_id'])
            ->where('classroom_id', $filters['from_classroom_id'])
            ->where('section_id', $filters['from_section_id'])
            ->where('academic_year', $fromYearName)
            ->where('status', 1)
            ->orderBy('student_code')
            ->get();
    }

    public function promote(array $data)
    {
        return DB::transaction(function () use ($data) {
            $promoteIds = $this->normalizeIds($data['promote_student_ids'] ?? []);
            $graduateIds = $this->normalizeIds($data['graduate_student_ids'] ?? []);

            if ($data['from_academic_year_id'] == $data['to_academic_year_id']) {
                throw new \Exception(__('admin.promotions.messages.failed.same_year'));
            }

            if ($this->isSameDestination($data) && !empty($promoteIds)) {
                throw new \Exception(__('admin.promotions.messages.failed.same_place'));
            }

            if (!empty(array_intersect($promoteIds, $graduateIds))) {
                throw new \Exception(__('admin.promotions.messages.failed.conflict'));
            }

            $fromYearName = $this->getAcademicYearName($data['from_academic_year_id']);
            $toYear = AcademicYear::find($data['to_academic_year_id']);
            if (!$toYear) {
                throw new \Exception(__('admin.promotions.messages.failed.invalid_year'));
            }

            $students = Student::where('grade_id', $data['from_grade_id'])
                ->where('classroom_id', $data['from_classroom_id'])
                ->where('section_id', $data['from_section_id'])
                ->where('academic_year', $fromYearName)
                ->where('status', 1)
                ->lockForUpdate()
                ->get();

            $allIds = $students->pluck('id')->all();
            $invalidPromote = array_diff($promoteIds, $allIds);
            $invalidGraduate = array_diff($graduateIds, $allIds);

            if (!empty($invalidPromote) || !empty($invalidGraduate)) {
                throw new \Exception(__('admin.promotions.messages.failed.mismatch'));
            }

            $repeatIds = array_values(array_diff($allIds, $promoteIds, $graduateIds));
            $targetIds = array_values(array_unique(array_merge($promoteIds, $repeatIds, $graduateIds)));

            if (!empty($targetIds)) {
                $existing = StudentEnrollment::where('academic_year_id', $data['to_academic_year_id'])
                    ->whereIn('student_id', $targetIds)
                    ->pluck('student_id')
                    ->all();

                if (!empty($existing)) {
                    throw new \Exception(__('admin.promotions.messages.failed.already_enrolled'));
                }
            }

            $now = now();
            $adminId = Auth::id();
            $enrollmentRows = [];

            foreach ($promoteIds as $studentId) {
                $enrollmentRows[] = [
                    'student_id' => $studentId,
                    'academic_year_id' => $data['to_academic_year_id'],
                    'grade_id' => $data['to_grade_id'],
                    'classroom_id' => $data['to_classroom_id'],
                    'section_id' => $data['to_section_id'],
                    'enrollment_status' => StudentEnrollment::STATUS_PROMOTED,
                    'admin_id' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach ($repeatIds as $studentId) {
                $enrollmentRows[] = [
                    'student_id' => $studentId,
                    'academic_year_id' => $data['to_academic_year_id'],
                    'grade_id' => $data['from_grade_id'],
                    'classroom_id' => $data['from_classroom_id'],
                    'section_id' => $data['from_section_id'],
                    'enrollment_status' => StudentEnrollment::STATUS_REPEATING,
                    'admin_id' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach ($graduateIds as $studentId) {
                $enrollmentRows[] = [
                    'student_id' => $studentId,
                    'academic_year_id' => $data['to_academic_year_id'],
                    'grade_id' => $data['from_grade_id'],
                    'classroom_id' => $data['from_classroom_id'],
                    'section_id' => $data['from_section_id'],
                    'enrollment_status' => StudentEnrollment::STATUS_GRADUATED,
                    'admin_id' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (!empty($enrollmentRows)) {
                StudentEnrollment::insert($enrollmentRows);
            }

            if (!empty($promoteIds)) {
                Student::whereIn('id', $promoteIds)
                    ->update([
                        'grade_id' => $data['to_grade_id'],
                        'classroom_id' => $data['to_classroom_id'],
                        'section_id' => $data['to_section_id'],
                        'academic_year' => $toYear->name,
                    ]);
            }

            if (!empty($repeatIds)) {
                Student::whereIn('id', $repeatIds)
                    ->update([
                        'academic_year' => $toYear->name,
                    ]);
            }

            if (!empty($graduateIds)) {
                Student::whereIn('id', $graduateIds)
                    ->update([
                        'status' => 0,
                    ]);
            }

            return [
                'promoted' => count($promoteIds),
                'repeating' => count($repeatIds),
                'graduated' => count($graduateIds),
            ];
        });
    }

    private function isSameDestination(array $data): bool
    {
        return $data['from_grade_id'] == $data['to_grade_id']
            && $data['from_classroom_id'] == $data['to_classroom_id']
            && $data['from_section_id'] == $data['to_section_id']
            && $data['from_academic_year_id'] == $data['to_academic_year_id'];
    }

    private function normalizeIds(array $ids): array
    {
        return array_values(array_unique(array_filter(array_map('intval', $ids))));
    }

    private function getAcademicYearName($id): string
    {
        $year = AcademicYear::find($id);
        if (!$year) {
            throw new \Exception(__('admin.promotions.messages.failed.invalid_year'));
        }

        return $year->name;
    }
}
