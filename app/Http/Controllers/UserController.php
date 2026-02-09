<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $roles = Role::all();
        $categories = Category::where('status', 0)->get();
        $users = User::with(['roles', 'categories'])->get();
        return view('user.index', compact('categories','roles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'role'       => 'required|exists:roles,name',
            'categories' => 'nullable|array',
        ]);

        // 1. Create the User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Assign the Spatie Role
        $user->assignRole($request->role);

        // 3. Save Assigned Categories to the pivot table
        if ($request->has('categories')) {
            // sync() handles inserting into the category_user table
            $user->categories()->sync($request->categories);
        }

        return redirect()->route('users.index')->with('success', 'User created and categories assigned!');
    }

    public function destroy(User $user){
// 1. Prevent Admin from deleting themselves
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        // 2. Detach categories (if not using cascade delete in migration)
        $user->categories()->detach();

        // 3. Remove Spatie Roles
        $user->roles()->detach();

        // 4. Delete the User
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User and their assignments deleted successfully.');
    }

    public function edit(User $user){
        $roles = Role::all();
        $categories = Category::where('status', 0)->get();
        $users = User::with(['roles', 'categories'])->where('id', $user->id)->get();
        return view('user.edit', compact('user', 'roles', 'categories'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'categories' => 'array'
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;

        // Only update password if the user typed something
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Sync Roles (Spatie method)
        $user->syncRoles([$request->role]);

        // Sync Categories (Pivot table method)
        // This removes categories not in the array and adds new ones
        $user->categories()->sync($request->categories);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
