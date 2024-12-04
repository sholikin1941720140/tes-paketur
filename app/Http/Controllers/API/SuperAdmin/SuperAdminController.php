<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        $data = Company::with(['users.roles'])->paginate(2);

        $paginatedData = $data->getCollection()->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
                'phone_number' => $company->phone_number,
                'users' => $company->users->map(function ($user) {
                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone_number' => $user->phone_number,
                        'address' => $user->address,
                        'role' => $user->roles ? $user->roles->name : null,
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

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->roles->id != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only SuperAdmins can create companies'
            ], 403);
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255|unique:companies,email',
            'company_phone_number' => 'required|string|max:15',
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|email|max:255|unique:users,email',
            'manager_phone_number' => 'required|string|max:15',
            'manager_address' => 'required|string|max:255',
            'manager_password' => 'required|string|min:8',
        ]);

        $company = new Company();
        $company->name = $request->company_name;
        $company->email = $request->company_email;
        $company->phone_number = $request->company_phone_number;
        $company->save();

        $manager = new User();
        $manager->name = $request->manager_name;
        $manager->email = $request->manager_email;
        $manager->phone_number = $request->manager_phone_number;
        $manager->address = $request->manager_address;
        $manager->password = Hash::make($request->manager_password);
        $manager->role_id = 2;
        $manager->company_id = $company->id;
        $manager->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Company and Manager created successfully',
            'data' => [
                'company' => $company,
                'manager' => $manager
            ]
        ], 201);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        
        if ($user->roles->id != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only SuperAdmins can delete companies'
            ], 403);
        }

        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Company deleted successfully'
        ], 200);
    }
}
