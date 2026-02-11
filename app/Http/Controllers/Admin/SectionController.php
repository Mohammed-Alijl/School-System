<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\section\StoreRequest;
use App\Http\Requests\Admin\section\UpdateRequest;
use App\Models\Section;
use App\Services\ClassroomService;
use App\Services\GradeService;
use App\Services\SectionService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SectionController extends Controller implements HasMiddleware
{
    public function __construct(
        protected SectionService   $sectionService,
        protected ClassroomService $classroomService,
        protected GradeService     $gradeService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_section', only: ['index']),
            new Middleware('permission:create_section', only: ['store']),
            new Middleware('permission:edit_section', only: ['update']),
            new Middleware('permission:delete_section', only: ['destroy']),
            new Middleware('permission:view-archived_section', only: ['archive']),
            new Middleware('permission:restore_section', only: ['restore']),
            new Middleware('permission:force-delete_section', only: ['forceDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sections = $this->sectionService->getAll();
            $grades = $this->gradeService->getAllWithClassrooms();
            return view('admin.sections.index', compact('sections', 'grades'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->sectionService->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.add')
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Section $section)
    {
        try {
            $this->sectionService->update($section, $request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.sections.messages.success.update')
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.sections.messages.failed.update')
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        try {
            $this->sectionService->delete($section);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.sections.messages.success.archive')
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.sections.messages.failed.archive')
            ], 500);
        }
    }

    public function archive()
    {
        try {
            $sections = $this->sectionService->archive();
            return view('admin.classrooms.archived', compact('sections'));
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.sections.messages.failed.archive')
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $this->sectionService->restore($id);
            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.restore')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.classrooms.messages.failed.restore')
            ], 404);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->sectionService->forceDelete($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.classrooms.messages.success.delete')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.classrooms.messages.failed.delete')
            ], 500);
        }
    }

    public function getClassrooms($id)
    {
        $classrooms = $this->classroomService->getGradeClassrooms($id);
        return response()->json($classrooms);
    }
}
