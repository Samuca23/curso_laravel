<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
        $aArray = [10,20,30,40,50,60,70];
        $aNome = ['Samuel', 'Isadora', 'Marilucia'];
    
        return view('welcome', ['array' => $aArray, 'nome' => $aNome]);
    }

    public function create() {
        return view('events.create');
    }
}
