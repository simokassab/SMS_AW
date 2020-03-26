<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\campaign;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use  Auth;

class SenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sender=DB::table('sender')
        ->join('users', 'sender.US_ID_FK', 'users.id')
            ->select('sender.*', 'users.full_name as US_NAME', 'users.company as CMP')->get();
        return view('sender.index')->with('sender', $sender);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $users = DB::table('users')->get();
       return view('sender.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' =>'required',
            'user' => 'required'
        ]);
        DB::table('sender')->insert([
            'name' => $request->input('name'),
            'US_ID_FK' => $request->input('user'),
        ]);
        return redirect('/sender')->with('success', 'Sender Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sender = DB::table('sender')->where('id', $id)->get();
        $users = DB::table('users')->get();
        return view('sender.edit')->with('sender',$sender)->with('users', $users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('sender')
            ->where('id', $id)
            ->update(['name' => $request->input('name'),
                'active' => $request->input('active'),
                'US_ID_FK' => $request->input('user')
            ]);
        return redirect('/sender')->with('success', 'sender UPDATED !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sender')->where('id', $id)->update(['active'=>0]);
        return redirect('/sender')->with('success', 'sender has been desactivated !');
    }
}
