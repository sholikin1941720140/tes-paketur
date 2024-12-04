<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $data = Company::with(['users' => function($query) {
                            $query->where('role_id', 3);
                        }, 'users.roles'])
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
                }),
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
        $companyId = auth()->user()->company_id;

        $user = User::with(['roles'])
                    ->where('company_id', $companyId)
                    ->where('id', $id)
                    ->where('role_id', 3)
                    ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found or not authorized',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone_number' => $user->phone_number,
                'user_address' => $user->address,
                'user_role' => $user->roles ? $user->roles->name : null,
            ],
        ], 200);
    }

    public function profile()
    {
        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone_number' => $user->phone_number,
                'user_address' => $user->address,
                'user_role' => $user->roles ? $user->roles->name : null,
            ],
        ], 200);
    }
}
