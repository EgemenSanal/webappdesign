<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoiceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'message' => 'No invoices found for the user',
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
        $user = auth()->user();
        $userid = auth()->id();

        $isAdmin = DB::table('members')->where('id', $userid)->first();
        if ($isAdmin->role === 'A') {
            $request->validated();
            $invoice = Invoice::create([
                'status' => $request['status'],
                'memberID' => $request['memberID'],
                'billedDate' => $request['billedDate'],
                'paidDate' => $request['paidDate'],
            ]);
            if($invoice){
                return response()->json([
                    'message' => 'Successfully created invoice!',
                    'user' => $invoice
                ]);
            }else{
                return response()->json([
                    'message' => 'Fail created invoice!'
                ]);
            }
        }else{
            return response()->json([
                'message' => 'Not allowed to create invoice!',
            ]);
        }



        //return new InvoiceResource(Invoice::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        $userId = auth()->id();
        $isAdmin = DB::table('members')->where('id', $userId)->first();
        $invoice = DB::table('invoices')->where('id', $id)->first();
        if($isAdmin->role === 'A'){
            return response()->json(['member' => $invoice], 200);

        }else{
            return response()->json([
                'message' => 'You are not allowed to view this invoice!',
            ]);
        }
        //return new InvoiceResource($invoice);
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
        $user = Auth::user();
        $userid = Auth::id();
        $data = $request->all();
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        $memberID = $isAdmin->id;
        if (!$memberID) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        if ($isAdmin->role === 'A') {
            $invoice->update($request->all());
            return response()->json(['message' => 'Invoice updated successfully']);
        }else{
            return response()->json(['message' => 'You are not allowed to edit this invoice!'], 404);
        }
        //$invoice->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $user = auth()->user();
        $userid = auth()->id();
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        if($isAdmin->role === 'A'){
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
        }else{
            return response()->json(['message' => 'You are not allowed to delete this invoice!'], 404);

        }

    }
}
