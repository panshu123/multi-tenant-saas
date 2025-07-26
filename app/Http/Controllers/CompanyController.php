<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\UserActiveCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $companies = $user->companies()->get();

        return response()->json($companies, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
        ]);

        $company = new Company($validated);
        $company->user_id = Auth::id();
        $company->save();

        return response()->json($company, 201);
    }

    public function show($id)
    {
        $company = Auth::user()->companies()->findOrFail($id);

        return response()->json($company, 200);
    }

    public function update(Request $request, $id)
    {
        //$company = Auth::user()->companies()->findOrFail($id);
      try {
        $company = Auth::user()->companies()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'No company Found'
            ], 400);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
        ]);

        $company->update($validated);

        return response()->json($company, 200);
    }

    public function destroy($id)
    {
        $company = Auth::user()->companies()->findOrFail($id);

        $company->delete();

        return response()->json(null, 204);
    }
}
