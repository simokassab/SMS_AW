<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function users (){
        return view('users.index');
    }
    public function campaigns (){
        return view('campaigns.index');
    }
    public function sender (){
        return view('sender.index');
    }
    public function credits (){
        return view('credits.index');
    }

}
