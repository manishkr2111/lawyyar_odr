<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function addBankAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'client_name' => 'required|string|max:255',
                'client_address' => 'required|string|max:255',
                'client_email' => 'required|string|email|max:255|unique:users,email',
                'client_phone' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error.',
                    'data' => $validator->errors()
                ], 422);
            }
            $data = $request->all();
            $data['role'] = 'bank_admin';
            $user = User::create([
                'name' => $data['client_name'],
                'email' => $data['client_email'],
                'password' => Hash::make(Str::random(10)),
                'phone' => $data['client_phone'],
            ]);

            $details = $user->details()->firstOrCreate([]);
            $details->address = $data['client_address'];
            $details->save();

            $user->assignRole($data['role']);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully.',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => [],
            ], 422);
        }
    }
    public function addMediator(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'mediator_name' => 'required|string|max:255',
                'mediator_address' => 'required|string|max:255',
                'mediator_email' => 'required|string|email|max:255|unique:users,email',
                'mediator_phone' => 'required|string',
                'mediator_password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error.',
                    'data' => $validator->errors()
                ], 422);
            }
            $data = $request->all();
            $data['role'] = 'bank_admin';
            $user = User::create([
                'name' => $data['mediator_name'],
                'email' => $data['mediator_email'],
                'password' => Hash::make($data['mediator_password']),
                'phone' => $data['mediator_phone'],
            ]);
            $details = $user->details()->firstOrCreate([]);
            $details->address = $data['mediator_address'];
            $details->save();

            $user->assignRole($data['role']);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully.',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => [],
            ], 422);
        }
    }

    public function getBankAdmin(Request $request)
    {
        try {
            $authUser = Auth::user();
            if (!$authUser->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access.',
                    'data' => [],
                ], 422);
            }
            $perPage = $request->input('per_page', 10); // default 10

            $bankAdmins = User::whereHas('roles', function ($query) {
                $query->where('name', 'bank_admin');
            })->paginate($perPage, ['*'], 'bank_admin_page');

            return response()->json([
                'success' => true,
                'message' => 'Users fetched successfully.',
                'data' => $bankAdmins,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => [],
            ], 422);
        }
    }
    public function getMediator(Request $request)
    {
        try {
            $authUser = Auth::user();
            if (!$authUser->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access.',
                    'data' => [],
                ], 422);
            }

            $perPage = $request->input('per_page', 10); // default 10

            $bankAdmins = User::whereHas('roles', function ($query) {
                $query->where('name', 'mediator');
            })->paginate($perPage, ['*'], 'bank_admin_page');

            return response()->json([
                'success' => true,
                'message' => 'Users fetched successfully.',
                'data' => $bankAdmins,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => [],
            ], 422);
        }
    }

    public function updateBankAdminOrMediator(Request $request, $user_id)
    {
        try {
            $authUser = Auth::user();

            if (!$authUser->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized access.',
                    'data' => [],
                ], 422);
            }

            $user = User::with('details')->find($user_id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                    'data' => [],
                ], 404);
            }

            // Detect role
            $role = $user->roles->pluck('name')->first();

            if (!in_array($role, ['bank_admin', 'mediator'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not Bank Admin or Mediator.',
                    'data' => [],
                ], 422);
            }

            // Validation rules
            $rules = [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user_id,
                'phone' => 'sometimes|string',
                'address' => 'sometimes|string|max:255',
                'password' => 'sometimes|string|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error.',
                    'data' => $validator->errors()
                ], 422);
            }

            // Update user table
            if ($request->has('name')) $user->name = $request->name;
            if ($request->has('email')) $user->email = $request->email;
            if ($request->has('phone')) $user->phone = $request->phone;
            if ($request->has('password')) $user->password = Hash::make($request->password);

            $user->save();

            // Update details table
            $details = $user->details()->firstOrCreate([]);
            if ($request->has('address')) $details->address = $request->address;
            $details->save();

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => [],
            ], 422);
        }
    }
}
