<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index() {
        $sSearch = request('search');
        if ($sSearch) {
            $events = Event::where([['title', 'like', '%' . $sSearch . '%' ]])->get();
        } else {
            $events = Event::all();
        }
        return view('welcome', ['events' => $events, 'search' => $sSearch]);

    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $oRequest) {
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

    public function show($id) {
        $oEvent = Event::findOrFail($id);

        return view('events.show', ['event' => $oEvent]);
    }
}
