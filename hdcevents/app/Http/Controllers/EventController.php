<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $sSearch = request('search');
        if ($sSearch) {
            $events = Event::where([['title', 'like', '%' . $sSearch . '%']])->get();
        } else {
            $events = Event::all();
        }
        return view('welcome', ['events' => $events, 'search' => $sSearch]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $oRequest)
    {
        $oEvent = new Event;

        $oEvent->title = $oRequest->title;
        $oEvent->date = $oRequest->date;
        $oEvent->city = $oRequest->city;
        $oEvent->private = $oRequest->private;
        $oEvent->description = $oRequest->description;
        $oEvent->items = $oRequest->items;

        if ($oRequest->hasFile('image') && $oRequest->file('image')->isValid()) {
            $oRequestImage = $oRequest->image;

            $oExtension = $oRequestImage->extension();
            $sImageName = md5($oRequestImage->getClientOriginalName() . strtotime("NOW()") . "." . $oExtension);
            $oRequestImage->move(public_path('img/event'), $sImageName);

            $oEvent->image = $sImageName;
        }

        $user = auth()->user();
        $oEvent->user_id = $user->id;
        $oEvent->save();

        return  redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id)
    {
        $oEvent = Event::findOrFail($id);
        $user = auth()->user();
        $hasUserJoined = false;

        if ($user) {
            $userEvents = $user->eventsAsParticipant->toArray();
            foreach($userEvents as $userEvent) {
                if ($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        $eventOwner = User::where('id', $oEvent->user_id)->first()->toArray();

        return view('events.show', ['event' => $oEvent, 'eventOwener' => $eventOwner, 'hasuserjoined' => $hasUserJoined]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $event = $user->events;
        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $event, 'eventsasparticipant' => $eventsAsParticipant]);
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        if ($user->id != $event->user->id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $oRequestImage = $request->image;

            $oExtension = $oRequestImage->extension();
            $sImageName = md5($oRequestImage->getClientOriginalName() . strtotime("NOW()") . "." . $oExtension);
            $oRequestImage->move(public_path('img/event'), $sImageName);

            $data['image'] = $sImageName;
        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento alterado com sucesso!');
    }

    public function joinEvent($id)
    {
        $user = auth()->user();
        $user->eventsAsParticipant()->attach($id);
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
    }

    public function leaveEvent($id)
    {
        $user = auth()->user();
        $user->eventsAsParticipant()->detach($id);
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu do evento ' . $event->title);
    }
}
