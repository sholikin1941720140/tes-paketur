<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use DB;

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
}
