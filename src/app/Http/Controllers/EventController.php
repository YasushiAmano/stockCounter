<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Services\EventServices;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = DB::table('events')
            ->orderBy('start_date', 'asc') //開始日時順
            ->paginate(10); // 10件ずつ
        return view(
            'manager.events.index',
            compact('events')
        ); //変数をViewに渡す
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $check = EventServices::checkEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if($check){
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
        }

        $start_date  = EventServices::joinDateAndTime(
            $request['event_date'],
            $request['start_time']
        );
        $end_date = EventServices::joinDateAndTime(
            $request['event_date'],
            $request['end_time']
        );

        Event::create([
            'name' => $request->event_name,
            'information' => $request->information,
            'max_people' => $request->max_people,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'is_visible' => $request->is_visible
        ]);

        session()->flash('status', '登録しました。');

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        // dd($eventDate, $startTime, $endTime);
        return view('manager.events.show', compact(
            'event',
            'eventDate',
            'startTime',
            'endTime'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
