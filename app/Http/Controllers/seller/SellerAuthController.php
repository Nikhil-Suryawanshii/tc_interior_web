<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;

class SellerAuthController extends Controller
{

    /**
     * Show the seller login form.
     */
    public function showLoginForm()
    {
        return view('seller.login.login');
    }

    /**
     * Handle a seller login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('seller')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/seller/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Logout the seller.
     */
    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/seller/login');
    }

    public function showProfile()
    {
        $sellerData = Auth::guard('seller')->user();
        return view('seller.login.seller_profile_view',compact('sellerData'));
    }
    
    public function storeProfile(Request $request): RedirectResponse {
   
        $sellerData = Auth::guard('seller')->user();
        $sellerData->username = $request->username;
        $sellerData->name = $request->name;
        $sellerData->email = $request->email;
        $sellerData->phone = $request->phone;
        $sellerData->address = $request->address;

        $oldImagePath = $sellerData->photo;

        if($request->hasFile("photo")) {
            if (!is_null($oldImagePath)) {
                $oldImagePath = public_path("upload/seller_upload") . '/' . $oldImagePath;
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
            $file = $request->file("photo");
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("upload/seller_upload"), $imageName);
            $sellerData->photo = $imageName;
        }
        $sellerData->save();

        return redirect()->back();
    }


    public function changePassword() {
        return view('seller.login.seller_change_password');
    }

    public function updatePassword(Request $request) {
        // Validation
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8|confirmed', // Ensure password has a minimum length and matches confirmation
    ]);

    // Get the authenticated seller
    $seller = Auth::guard('seller')->user();

    // Check if the old password matches
    if (!Hash::check($request->old_password, $seller->password)) {
        return back()->with("error", "The old password doesn't match our records.");
    }

    // Update the password
    $seller->password = Hash::make($request->new_password);
    $seller->save();

    // Return with success message
    return back()->with("status", "Password changed successfully.");
    }

}