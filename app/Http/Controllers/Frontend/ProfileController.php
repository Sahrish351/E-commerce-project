<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $customer = $user->customer;
        
        $recentOrders = Order::where('user_id', Auth::id())
            ->latest()
            ->limit(5)
            ->get();
        
        $totalOrders = Order::where('user_id', Auth::id())->count();
        
        // FIXED: Temporarily use 0 until orders table has grand_total column
        $totalSpent = 0;
        
        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
        
        return view('frontend.profile.dashboard', compact(
            'user', 
            'customer', 
            'recentOrders', 
            'totalOrders', 
            'totalSpent', 
            'wishlistCount'
        ));
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);
        
        $user = Auth::user();
        $user->update($request->only(['name', 'phone', 'address', 'city', 'postal_code']));
        
        return back()->with('success', 'Profile updated successfully!');
    }
    
    // ============ UPDATED - NO CURRENT PASSWORD ============
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);
        
        return back()->with('success', 'Password updated successfully!');
    }
    
    public function updateCustomerProfile(Request $request)
    {
        $request->validate([
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);
        
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if ($customer) {
            $customer->update($request->only(['date_of_birth', 'gender']));
        } else {
            Customer::create(array_merge(
                ['user_id' => Auth::id()],
                $request->only(['date_of_birth', 'gender'])
            ));
        }
        
        return back()->with('success', 'Customer profile updated!');
    }
    
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('frontend.profile.orders', compact('orders'));
    }
    
    // ============ OLD ADDRESSES METHOD (Replace with new) ============
    public function addresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('frontend.profile.addresses', compact('addresses'));
    }
    
    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);
        
        Auth::user()->update($request->only(['address', 'city', 'state', 'postal_code', 'country']));
        
        return back()->with('success', 'Address updated successfully!');
    }
    
    // ============ NEW ADDRESS METHODS ============
    
    // Store new address
    public function storeAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'label' => 'nullable|string|max:50',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'label' => $request->label ?? 'Home',
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'is_default' => false,
        ]);

        return back()->with('success', 'Address added successfully!');
    }

    // Delete address
    public function deleteAddress($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        
        return back()->with('success', 'Address deleted successfully!');
    }
    
    // ============ PROFILE EDIT METHODS ============
    
    // Show Edit Profile Form
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.profile.edit', compact('user'));
    }
    
    // Show Change Password Form
    public function editPassword()
    {
        return view('frontend.profile.change-password');
    }
}