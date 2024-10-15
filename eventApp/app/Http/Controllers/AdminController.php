<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\AdminCollection;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AdminCollection(Admin::all());

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
    public function store(StoreAdminRequest $request)
    {

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $admin = Admin::create($data);

        return new AdminResource($admin);

        //return new AdminResource(Admin::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $admin->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        try {
            $admin->delete();
            return response()->json([
                'message' => 'Admin deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
