<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreRequest;
use App\Http\Requests\Admin\Admin\UpdateRequest;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct(protected AdminService $adminService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // We get admins and roles (for the add/edit modals)
        $admins = $this->adminService->getAll()->get();
        $roles = Role::get();

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->adminService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.admins.messages.success.add')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.admins.messages.failed.add')
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage via AJAX.
     */
    public function update(UpdateRequest $request, Admin $admin): JsonResponse
    {
        try {
            $this->adminService->update($admin, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.admins.messages.success.update')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.admins.messages.failed.update')
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage via AJAX.
     */
    public function destroy(Admin $admin): JsonResponse
    {
        try {
            $this->adminService->delete($admin->id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.admins.messages.success.delete')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.admins.messages.failed.delete')
            ], 500);
        }
    }
}
