<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }
    
    public function index()
    {
        
        $users = User::where('role', 'user')
            ->with('customer')
            ->latest()
            ->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function edit(User $user)
    {
       
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot edit admin from customers page!');
        }
        
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
       
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot update admin from customers page!');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);
        
        $data = $request->only(['name', 'email', 'phone']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Customer updated successfully!');
    }
    
    public function destroy(User $user)
    {
       
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin from customers page!');
        }
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }
        
        $user->delete();
        return back()->with('success', 'Customer deleted successfully!');
    }
}