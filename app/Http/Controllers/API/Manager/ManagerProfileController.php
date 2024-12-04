<?php

namespace App\Http\Controllers\API\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
                'role' => $user->roles ? $user->roles->name : null,
                'company' => [
                    'company_name' => $user->companies->name,
                    'company_email' => $user->companies->email,
                    'company_phone_number' => $user->companies->phone_number,
                ],
            ],
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
        ]);

        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
        ], 200);
    }
}
