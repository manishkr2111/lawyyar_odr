<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function AllUsers(Request $request)
    {
        try {
            $data = $request->validate([
                'role' => 'nullable|exists:roles,name',
            ]);
            if (isset($data['role'])) {
                $users = User::whereHas('roles', function ($query) use ($data) {
                    $query->where('name', $data['role']);
                })->get();
            } else {
                $users = User::all();
            }

            return response()->json([
                'success' => true,
                'message' => 'All users retrieved successfully.',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function UserDetails($user_id)
    {
        try {
            $user = User::where('id', $user_id)->first();
            return response()->json([
                'success' => true,
                'message' => 'User details retrieved successfully.',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function CreateUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|exists:roles,name',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $role = Role::where('name', $request->role)->first();
            $user->assignRole($role);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function UpdateUser(Request $request, $user_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'role' => 'required|exists:roles,name',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            if(Auth::user()->id == $user_id){
                return response()->json([
                    'success' => false,
                    'message' => 'you can not update your own account.',
                ], 401);
            }
            $user = User::where('id', $user_id)->first();
            if(!$user){
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }
            $user->name = $request->name;
            $user->save();

            $role = Role::where('name', $request->role)->first();
            $user->syncRoles([$role->id]);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
