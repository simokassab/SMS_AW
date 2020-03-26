<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\campaign;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use  Auth;

class CreditsController extends Controller
{
    public function index()
    {
        $credits=DB::table('credits')
            ->join('users', 'credits.US_ID_FK', 'users.id')
            ->select('credits.*', 'users.full_name as US_NAME', 'users.company as CMP', 'users.id as US_ID')->get();
        $logs = DB::table('credits_logs')
            ->join('users', 'credits_logs.US_ID_FK', 'users.id')
            ->select('credits_logs.*', 'users.full_name as US_NAME', 'users.company as CMP', 'users.id as US_ID')->get();
        return view('credits.index')->with('credits', $credits)->with('logs', $logs);
    }

    public function edit($id){

        $credits = DB::table('credits')->where('US_ID_FK', $id)->get();
        $users = DB::table('users')->where('id', $id)->get();
        return view('credits.edit')->with('credits',$credits)->with('users', $users);
    }

    public function update(Request $request, $id)
    {
        $old="";
        $credits = DB::table('credits')->where('id', $id)->get()->toArray();;
        foreach ($credits as $c){
            $old =$c->credit;
        }
        $new =  $request->input('credits') + $old;
        DB::table('credits')
            ->where('id', $id)
            ->update(['credit' => $new,

            ]);
        return redirect('/credits')->with('success', 'Credits have been added!');
    }
}
