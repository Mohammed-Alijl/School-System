<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\StoreRequest;
use App\Http\Requests\Admin\Student\UpdateRequest;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Section;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller implements HasMiddleware
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_students', only: ['index']),
            new Middleware('permission:create_students', only: ['store']),
            new Middleware('permission:edit_students', only: ['update']),
            new Middleware('permission:delete_students', only: ['destroy']),
            new Middleware('permission:view-archived_students', only: ['archive']),
            new Middleware('permission:restore_students', only: ['restore']),
            new Middleware('permission:force-delete_students', only: ['forceDelete']),
        ];
    }


public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->studentService->getStudentsDataTable($request);
        }
        
        $lookups = $this->studentService->getLookups();
        
        return view('admin.students.index', $lookups);
    }


    public function store(StoreRequest $request)
    {
        try {
            $this->studentService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.add')
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit(Student $student)
    {

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $student->id,
                'student_code' => $student->student_code,
                'name_ar' => $student->getTranslation('name', 'ar'),
                'name_en' => $student->getTranslation('name', 'en'),
                'email' => $student->email,
                'national_id' => $student->national_id,
                'date_of_birth' => $student->date_of_birth->format('Y-m-d'),                
                'grade_id' => $student->grade_id,
                'classroom_id' => $student->classroom_id,
                'section_id' => $student->section_id,
                'guardian_id' => $student->guardian_id,
                'blood_type_id' => $student->blood_type_id,
                'nationality_id' => $student->nationality_id,
                'religion_id' => $student->religion_id,
                'gender_id' => $student->gender_id,
                'status' => $student->status,
            ]
        ]);
    }

    public function update(UpdateRequest $request, Student $student)
    {
        try {
            $this->studentService->update($student, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.update')
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => trans('admin.students.messages.failed.update')], 500);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $this->studentService->delete($student);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.delete')
            ], 500);
        }
    }


    public function archive(Request $request)
    {
        if ($request->ajax()) {
            return $this->studentService->getArchivedDataTable($request);
        }

        $grades    = $this->studentService->getLookups()['grades'];
        return view('admin.students.archived', compact('grades'));
    }


    public function restore($id)
    {
        try {
            $this->studentService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.restore')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.restore')
            ], 404);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->studentService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.students.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.students.messages.failed.delete')
            ], 500);
        }
    }

    public function getNextStudentCode() {
        try {
            $student_code = $this->studentService->getNextStudentCode();
            return response()->json([
                'status' => 'success',
                'student_code' => $student_code
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
