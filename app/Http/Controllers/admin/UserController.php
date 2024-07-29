<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserCreate()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        // Create a new user
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('12345678');
        $user->role = 'admin';
        $user->save();

        // Redirect to a desired route with success message
        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }

    public function list()
    {
        $result = User::where('role', 'admin')->get();
        return view('admin.user.list', compact('result'));
    }

    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->status = $request->status;
            $user->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
