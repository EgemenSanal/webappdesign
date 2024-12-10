<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Resources\MemberCollection;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {

        $user = auth()->user();
        $userid = auth()->id();

        $member = DB::table('events')->where('organizer_id', $userid)->first();
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        if ($isAdmin->role === 'A') {
            return new EventCollection(Event::all());
        }
        if (!$member) {
            return response()->json([
                'message' => 'No events found for the user',
                'data' => $member
            ], 404);
        }
        if ($member->organizer_id == $userid) {
            return new EventResource($member);
        }


        return response()->json([
            'message' => 'EVENTS',
            'data' => $user
        ]);

        //return new EventResource(Event::all());

        //return new EventCollection(Event::all());
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
    public function store(StoreEvent $request)
    {
        $user = auth()->user();
        $userid = auth()->id();

        $member = DB::table('members')->where('id', $userid)->first();
        $memberID = $member->id;
        if($member->role === 'M'){
            return response()->json([
                'message' => 'Not allowed to create an event',
            ]);
        }
        $request->validated();
        $createdEvent = Event::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'location' => $request['location'],
            'starting_date' => $request['starting_date'],
            'ending_date' => $request['ending_date'],
            'organizer_id' => $memberID,
            'capacity' => $request['capacity'],
            'status' => $request['status'],


        ]);
        if($user){
            return response()->json([
                'message' => 'Successfully created event!',
                'user' => $createdEvent
            ]);
        }else{
            return response()->json([
                'message' => 'Fail created event!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $user = auth()->user();
        $userId = auth()->id();
        $isAdmin = DB::table('members')->where('id', $userId)->first();
        $event = DB::table('events')->where('id', $id)->first();
        if($isAdmin->role === 'A'){
            return response()->json(['member' => $event], 200);

        }else{
            return response()->json([
                'message' => 'You are not allowed to view this event!',
            ]);
        }
        //return new EventResource($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {

        $user = Auth::user();
        $userid = Auth::id();


        $data = $request->all();
        //$event->update($request->all());
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        $memberID = $isAdmin->id;
        if ($isAdmin->role === 'A') {
            $event->update($request->all());
            return response()->json(['message' => 'Event updated successfully']);
        }else{
            return response()->json(['message' => 'You are not allowed to edit this event!'], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $user = auth()->user();
        $userid = auth()->id();
        $isAdmin = DB::table('members')->where('id', $userid)->first();
        if($isAdmin->role === 'A'){
            try {
                $event->delete();
                return response()->json([
                    'message' => 'Event deleted successfully!'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Something went wrong!',
                    'message' => $e->getMessage()
                ], 500);
            }
        }else{
            return response()->json(['message' => 'You are not allowed to delete this event!'], 404);

        }

    }
}
