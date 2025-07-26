<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveCompanyController extends Controller
{
    public function switch(Request $request, Company $company): JsonResponse
    {
        $user = Auth::user();

        if ($company->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->active_company_id = $company->id;
        $user->save();

        return response()->json([
            'message' => 'Active company switched successfully.',
            'active_company_id' => $company->id,
        ]);
    }
}
