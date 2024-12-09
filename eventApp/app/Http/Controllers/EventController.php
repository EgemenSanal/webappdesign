<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberCollection;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use App\Models\Member;
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
    public function store(StoreEventRequest $request)
    {
        return new EventResource(Event::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event);

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
        $event->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
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
    }
}
