<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;

class AdminAuthController extends Controller
{

    public function showLoginForm()
    {
        return view('admin.login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function adminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function showProfile()
    {
        $adminData = Auth::guard('admin')->user();
        return view('admin.login.admin_profile_view',compact('adminData'));
    }


    public function storeProfile(Request $request): RedirectResponse {
   
        $adminData = Auth::guard('admin')->user();
        $adminData->username = $request->username;
        $adminData->name = $request->name;
        $adminData->email = $request->email;
        $adminData->phone = $request->phone;
        $adminData->address = $request->address;

        $oldImagePath = $adminData->photo;

        if($request->hasFile("photo")) {
            if (!is_null($oldImagePath)) {
                $oldImagePath = public_path("upload/admin_upload") . '/' . $oldImagePath;
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
            $file = $request->file("photo");
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("upload/admin_upload"), $imageName);
            $adminData->photo = $imageName;
        }
        $adminData->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function changePassword() {
        return view('admin.login.admin_change_password');
    }

    public function updatePassword(Request $request) {
        // Validation
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8|confirmed', // Ensure password has a minimum length and matches confirmation
    ]);

    // Get the authenticated admin
    $admin = Auth::guard('admin')->user();

    // Check if the old password matches
    if (!Hash::check($request->old_password, $admin->password)) {
        return back()->with("error", "The old password doesn't match our records.");
    }

    // Update the password
    $admin->password = Hash::make($request->new_password);
    $admin->save();

    // Return with success message
    return back()->with("status", "Password changed successfully.");
    }

}
