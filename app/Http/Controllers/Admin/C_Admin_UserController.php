<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Your User model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // At the top

class C_Admin_UserController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Manage Users']
        ];
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.V_Index', compact('users', 'breadcrumbs')); // Create this view
    }

    public function edit(User $user)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Manage Users', 'url' => route('admin.users.index')],
            ['name' => 'Edit: ' . Str::limit($user->name, 20)]
        ];
        return view('admin.users.V_Edit', compact('user', 'breadcrumbs'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'sometimes|boolean',
            'is_banned' => 'sometimes|boolean'
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->has('is_admin')) {
            $user->is_admin = (bool)$validated['is_admin'];
        }
        // if ($request->has('is_banned')) {
        //     $user->is_banned = (bool)$validated['is_banned'];
        // }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) { // Prevent admin from deleting themselves
            return back()->with('error', 'You cannot delete your own account.');
        }
        // Add checks to prevent deleting the last admin, etc.
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
