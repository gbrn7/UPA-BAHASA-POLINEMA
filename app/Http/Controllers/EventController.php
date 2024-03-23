<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = EventModel::all();

        $activeEvent = $events->where('status', true)->first();

        if (isset($activeEvent)) {
            $dateNow = Carbon::now();
            $registerEnd = Carbon::parse($activeEvent->register_end);
    
            if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0)
            {    
            $activeEvent->update(['status' => false]);
        
            }
        }

        return view('admin.data-event.data-event', ['events' => $events]);
    }

    public function createEvent()
    {
        $activeEvent = EventModel::where('status', true)->first();

        if (!isset($activeEvent)) {
            return view('admin.data-event.create-data-event');
        }

        return back()->with('toast_warning', 'Terdapat Event yang masih aktif, untuk menambahkan event pastikan semua event Non-Aktif');

    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'registration_range' => 'required',
            'execution' => 'required',
            'quota' => 'required',
            'status' => 'required',
        ]);

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();
        $execution = Carbon::parse($request->execution);

        $newEvent = EventModel::create([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $execution,
            'quota' => $request->quota,
            'remaining_quota' => $request->quota,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Ditambahkan');

    }   

    public function editEvent($eventId)
    {   
        $event = EventModel::where('event_id', $eventId)->first();
        $registerStart = date('d-m-Y', strtotime($event->register_start));
        $registerEnd = date('d-m-Y', strtotime($event->register_end));
        $execution = date('d-m-Y', strtotime($event->execution));

        return view('admin.data-event.edit-data-event', [
            'event' => $event,
            'registerStart' => $registerStart,
            'registerEnd' => $registerEnd,
            'execution' => $execution,
        ]);

    }

    public function updateEvent($eventId, Request $request)
    {
        $request->validate([
            'registration_range' => 'required',
            'execution' => 'required',
            'quota' => 'required',
            'status' => 'required|boolean',
        ]);

        if($request->status == 1 ){
            $activeEvent = EventModel::where('status', true)->first();

            if (isset($activeEvent) ) return back()->with('toast_warning', 'Terdapat Event yang masih aktif, untuk mengaktifkan event pastikan semua event Non-Aktif');
            
        }

        $oldEvent = EventModel::where('event_id', $eventId)->first();

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();
        $execution = Carbon::parse($request->execution);

        $oldEvent->update([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $execution,
            'quota' => $request->quota,
            'remaining_quota' => $request->quota,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Diedit');
    }

    public function deleteEvent(Request $request)
    {

        $request->validate([
            'eventId' => 'required',
        ]);

        $event = EventModel::find($request->eventId);

        $event->delete();

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Dihapus');

    }
}
