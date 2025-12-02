<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class CaseController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'loan_id'       => 'required|unique:cases,loan_id',
                'full_name'     => 'required|string|max:255',
                'email'         => 'required|email',
                'amount'        => 'required|numeric',
                'due_date'      => 'nullable|date',
                'loan_agreement' => 'required|string',
                'phone'         => 'nullable|string|max:20',

                'category'      => 'nullable|in:credit_card,vehicale,life_insurance,agriculture',
                'title'         => 'nullable|string',
                'description'   => 'nullable|string',
                'loan_amount'   => 'nullable|numeric',
                'recovered_loan_amount' => 'nullable|numeric',
                'file'          => 'nullable|string',
                'assigned_to'   => 'nullable|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Get authenticated user
            $user = Auth::user();
            // Set user_id
            $request->merge(['user_id' => $user->id]);
            // Create Case
            $case = CaseModel::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Case created successfully',
                'data'    => $case
            ], 201);
        } catch (QueryException $e) {
            // SQL / DB errors
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred',
                'error'   => $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            // Any general error
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
