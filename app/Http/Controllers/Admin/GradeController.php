<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Grade\StoreRequest;
use App\Http\Requests\Admin\Grade\UpdateRequest;
use App\Models\Grade;
use App\Services\GradeService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GradeController extends Controller implements HasMiddleware
{

    public function __construct(protected GradeService $gradeService)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_grades', only: ['index']),
            new Middleware('permission:create_grades', only: ['create']),
            new Middleware('permission:edit_grades', only: ['update']),
            new Middleware('permission:delete_grades', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = $this->gradeService->getAll();
        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->gradeService->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.grades.messages.success.add')
            ],200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => __('admin.grades.messages.failed.add')
            ],500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Grade $grade)
    {
        try {
            $this->gradeService->update($grade, $request->validated());
            return response()->json([
                'status' => 'success',
                'message' => __('admin.grades.messages.success.update')
            ],200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => __('admin.grades.messages.failed.update')
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        try {
            $this->gradeService->delete($grade);
            return response()->json([
                'status' => 'success',
                'message' => __('admin.grades.messages.success.delete')
            ],200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => __('admin.grades.messages.failed.delete')
            ]);
        }
    }
}
