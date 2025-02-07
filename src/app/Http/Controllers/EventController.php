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
        $today = Carbon::today();
        $events = DB::table('events')
            ->where('start_date', '>=', $today)
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

        if ($check) {
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
            'name' => $request->name,
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
            'endTime'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $today = Carbon::today()->format('Y年m月d日');
        if ($event->eventDate < $today) {
            return abort(404);
        }
        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view('manager.events.edit', compact(
            'event',
            'eventDate',
            'startTime',
            'endTime'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $count = EventServices::countEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if ($count > 1) {
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            $event = Event::findOrFail($event->id);
            $eventDate = $event->editEventDate;
            $startTime = $event->startTime;
            $endTime = $event->endTime;
            return view('manager.events.edit',compact(
                'event',
                'eventDate',
                'startTime',
                'endTime'
            ));
        }

        $start_date  = EventServices::joinDateAndTime(
            $request['event_date'],
            $request['start_time']
        );
        $end_date = EventServices::joinDateAndTime(
            $request['event_date'],
            $request['end_time']
        );

        $event = Event::findOrFail($event->id);

        $event->name = $request['name'];
        $event->information = $request['information'];
        $event->max_people = $request['max_people'];
        $event->start_date = $start_date;
        $event->end_date = $end_date;
        $event->is_visible = $request['is_visible'];
        $event->save();

        session()->flash('status', '更新しました。');

        return redirect()->route('events.index');
    }

    public function past()
    {
        $today = Carbon::today();
        $events = DB::table('events')
            ->where('start_date', '<', $today)
            ->orderBy('start_date', 'desc')
            ->paginate(10);
        return view('manager.events.past', compact('events'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
