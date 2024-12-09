<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFromRequest;
use App\Http\Requests\UserStore;
use App\Http\Resources\MemberResource;
use App\Http\Resources\MemberCollection;
use App\Models\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use http\Client\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $userId = auth()->id();

        $member = DB::table('members')->where('id', $userId)->first();
        if ($member->role === 'A') {
            return new MemberCollection(Member::all());
        }

        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
       //return new MemberCollection(Member::all());
    }

    public function login(LoginFromRequest $request){

        $request->validated();
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
               'message' => 'Unauthorized'
            ],401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',

        ]);

    }

    public function logout(\Illuminate\Http\Request $request){
        $token = $request->user()->token();
        $token->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
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
    public function store(UserStore $request)
    {

        $request->validated();
        $user = Member::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
        ]);
        if($user){
            return response()->json([
                'message' => 'Successfully created user!',
                'user' => $user
            ]);
        }else{
            return response()->json([
                'message' => 'Fail created user!'
            ]);
        }



        /* $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $member = Member::create($data);
        return new MemberResource($member); */

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        $userId = auth()->id();
        $isAdmin = DB::table('members')->where('id', $userId)->first();
        $member = DB::table('members')->where('id', $id)->first();
        if($isAdmin->role === 'A'){
            return response()->json(['member' => $member], 200);

        }else{
            return response()->json([
                'message' => 'You are not allowed to view this member!',
            ]);
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $user = Auth::user();
        $userid = Auth::id();

        $request->validated();
        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        //hash if password updated
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        $memberID = $isAdmin->id;
        if (!$memberID) {
            return response()->json(['message' => 'Member not found'], 404);
        }
        if ($isAdmin->role === 'A') {
            $member->update($data);
            return response()->json(['message' => 'Member updated successfully']);
        }
        if($isAdmin->id == $memberID){
            $member->update($data);
            return response()->json(['message' => 'Member updated successfully!']);
        }


        //$member->update($data);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return response()->json([
                'message' => 'Member deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
