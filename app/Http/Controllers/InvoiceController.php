<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Scopes\CompanyScope;

class InvoiceController extends Controller
{
    //
        public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $invoice = new Invoice($validated);
        $invoice->company_id = auth()->user()->active_company_id;
         $user = auth()->user();
        $invoice->user_id = $user->id;
        $invoice->save();
       
        return response()->json($invoice, 201);
    }
}
