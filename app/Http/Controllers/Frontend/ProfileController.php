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
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $user = Auth::user();
        $customer = $user->customer;
        
        $recentOrders = Order::where('user_id', Auth::id())
            ->latest()
            ->limit(5)
            ->get();
        
        $totalOrders = Order::where('user_id', Auth::id())->count();
        
        // ✅ FIXED: total_spent sahi se calculate karo
        $totalSpent = Order::where('user_id', Auth::id())->sum('total_amount');
        
        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
        
        // ✅ ADDED: Returns aur Cancellations dashboard ke liye
        $returns = Order::where('user_id', Auth::id())
            ->where('status', 'refunded')
            ->latest()
            ->limit(5)
            ->get();
        
        $cancellations = Order::where('user_id', Auth::id())
            ->where('status', 'cancelled')
            ->latest()
            ->limit(5)
            ->get();
        
        return view('frontend.profile.dashboard', compact(
            'user', 
            'customer', 
            'recentOrders', 
            'totalOrders', 
            'totalSpent', 
            'wishlistCount',
            'returns',
            'cancellations'
        ));
    }
    
    // ===== UPDATE PROFILE =====
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
    
    // ===== UPDATE PASSWORD ===== ✅ FIXED
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],  // ✅ ADDED
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);
        
        return back()->with('success', 'Password updated successfully!');
    }
    
    // ===== UPDATE CUSTOMER PROFILE =====
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
    
    // ===== SHOW EDIT PROFILE FORM =====
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.profile.edit', compact('user'));
    }
    
    // ===== SHOW CHANGE PASSWORD FORM =====
    public function editPassword()
    {
        return view('frontend.profile.change-password');
    }
    
    // ===== ADDRESS BOOK =====
    public function addresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('frontend.profile.addresses', compact('addresses'));
    }
    
    // ===== STORE ADDRESS =====
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

    // ===== DELETE ADDRESS =====
    public function deleteAddress($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        
        return back()->with('success', 'Address deleted successfully!');
    }
    
    // ===== UPDATE ADDRESS =====
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
    
    // ===== PAYMENT OPTIONS =====
    public function payment()
    {
        return view('frontend.profile.payment');
    }
    
    // ===== RETURNS PAGE ===== ✅ FIXED
    public function returns()
    {
        $returns = Order::where('user_id', Auth::id())
            ->where('status', 'refunded')
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.returns', compact('returns'));
    }
    
    // ===== CANCELLATIONS PAGE ===== ✅ FIXED
    public function cancellations()
    {
        $cancellations = Order::where('user_id', Auth::id())
            ->where('status', 'cancelled')
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.cancellations', compact('cancellations'));
    }
}