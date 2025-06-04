<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class C_User extends Controller
{
    // Display a listing of all users.
    // Paginated for easy viewing.
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['name' => 'Manage Users']
        ];
        $users = User::orderBy('name')->paginate(\App\Configuration::$pagination);
        return view('admin.users.V_Index', compact('users', 'breadcrumbs'));
    }

    // Show the form for editing a specific user.
    // Populates the form with the user's existing data.
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

    // Update the specified user in storage.
    // Validates input and handles admin status.
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

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage.
    // Prevents self-deletion of the authenticated user.
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
