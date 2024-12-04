<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = User::with('roles')->findOrFail($user->id);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'password' => 'nullable|string|min:8',
        ]);

        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
        ], 200);
    }
}
