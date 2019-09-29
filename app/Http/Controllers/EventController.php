<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $event = new Event();
        $event->title = $request->title;
        $event->start = $request->date.' '.$request->startTime;
        $event->end = $request->date.' '.$request->endTime;
        
        $event->save();

        return response()->json(array(
            'success'=>true,
            'msg' => $event
        ));
    }

    public function getAll()
    {
        $events = Event::all();
        return $events;
    }

    public function getEventsOnDate(Request $request)
    {
        $date = $request->post('date');

        $events = Event::whereDate('start','=',$date)->get();

        return $events;
    }

    public function deleteEvent(Request $request)
    {   
        $id = $request->input('id');
        $id = Event::find($id)->delete();
    
    }

    public function editEvent(Request $request)
    {   
        $id = $request->post('id');
        $event = Event::findOrFail($id);

        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();

        return response()->json(
            array(
                'success'=> true
            )
        );
        
        
    }
}
