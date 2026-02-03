<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function create()
    {
        return view('admin.auth.login');
    }

    public function store(LoginRequest $request)
    {
        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            $request->session()->regenerate();

            return response()->json([
                'status' => true,
                'message' => 'Login Successful',
                'redirect' => route('admin.dashboard')
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Do Not Match Our Record',
        ], 401);
    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function forgetPassword(Request $request) {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->route('admin.login');
    }
}
