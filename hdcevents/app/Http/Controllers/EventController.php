<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index() {
        $events = Event::all();
        return view('welcome', ['events' => $events]);
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $oRequest) {
        $oEvent = new Event;

        $oEvent->title = $oRequest->title;
        $oEvent->city = $oRequest->city;
        $oEvent->private = $oRequest->private;
        $oEvent->description = $oRequest->description;

        $oEvent->save();

        return  redirect('/')->with('msg', 'Evento criado com sucesso!');
    }
}
