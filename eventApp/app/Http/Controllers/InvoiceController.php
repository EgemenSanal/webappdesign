<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceCollection;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        $userid = auth()->id();

        $member = DB::table('invoices')->where('memberID', $userid)->first();
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        if ($isAdmin->role === 'A') {
            return new InvoiceCollection(Invoice::all());
        }
        if (!$member) {
            return response()->json([
                'message' => 'No events found for the user',
                'data' => []
            ], 404);
        }
        if ($member->memberID == $userid) {
            return new InvoiceResource($member);
        }


        return response()->json([
            'message' => 'INVOICES',
            'data' => $user
        ]);

        //return new InvoiceCollection(Invoice::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->all()));

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            return response()->json([
                'message' => 'Invoice deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
