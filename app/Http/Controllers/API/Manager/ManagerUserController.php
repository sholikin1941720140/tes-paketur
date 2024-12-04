<?php

namespace App\Http\Controllers\API\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Hash;

class ManagerUserController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $data = Company::with(['users.roles'])
                        ->where('id', $companyId)
                        ->paginate(2);

        $paginatedData = $data->getCollection()->map(function ($company) {
            return [
                'id' => $company->id,
                'company_name' => $company->name,
                'company_email' => $company->email,
                'company_phone_number' => $company->phone_number,
                'users' => $company->users->map(function ($user) {
                    return [
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'user_phone_number' => $user->phone_number,
                        'user_address' => $user->address,
                        'user_role' => $user->roles ? $user->roles->name : null,
                    ];
                })
            ];
        });

        $data->setCollection($paginatedData);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = User::with(['companies', 'roles'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $data->id,
                'name' => $data->name,
                'email' => $data->email,
                'phone_number' => $data->phone_number,
                'address' => $data->address,
                'role' => $data->roles ? $data->roles->name : null,
                'company' => [
                    'company_name' => $data->companies->name,
                    'company_email' => $data->companies->email,
                    'company_phone_number' => $data->companies->phone_number,
                ]
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $companyId = auth()->user()->company_id;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->role_id = 3;
        $user->company_id = $companyId;
        $user->password = Hash::make('password');
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'role_id' => 'nullable|exists:roles,id'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;

        if ($request->has('role_id')) {
            $user->role_id = $request->role_id;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $manager = auth()->user();
        if ($manager->roles->id != 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only Managers can delete employees'
            ], 403);
        }

        $data = User::findOrFail($id);
        if ($data->company_id != $manager->company_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only delete employees from your own company'
            ], 403);
        }
    
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ], 200);
    }
}
