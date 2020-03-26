<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\campaign;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use  Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::enableQueryLog();
        if (Auth::check())
        {
            $camp = DB::table("jobs")
             ->join('users', 'users.id', '=', 'jobs.US_ID_FK')
             ->join('groups', 'groups.id', '=', 'jobs.GRS_ID_FK')
            ->select('jobs.id as CMP_ID', 'jobs.name as CMP_NAME', 'jobs.type as CMP_TYPE',
            'jobs.sendingtype as CAMP_ST', 'jobs.sending_date as Q_DATE', 'users.username as US_NAME', 'jobs.SENDER_FK_ID as SENDER_NAME',
            'groups.name as GRS_NAME')->where('jobs.approved','0')->distinct()->get();
            $last = DB::table('jobs')->where('jobs.approved','0')->orderBy('id', 'DESC')->limit(1)->get();
           // dd(DB::getQueryLog());
            return view('campaigns.index')->with("camp", $camp)->with('last',$last);
        }
        else {
            return redirect('/login')->with('error', 'Login First');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        DB::enableQueryLog();
        $camptype =DB::table('jobs')->where('id', $id)->limit(1)->get();
        if($camptype[0]->type=='regular'){
            $camp = DB::table("jobs")
                ->join('users', 'users.id', '=', 'jobs.US_ID_FK')
                ->select('jobs.id as CMP_ID', 'jobs.name as CMP_NAME', 'jobs.type as CMP_TYPE',
                     'users.username as US_NAME', 'jobs.sendingtype as CAMP_ST', 'jobs.body as BODY' , 'jobs.SENDER_FK_ID as SENDER_NAME',
                    'jobs.GRS_ID_FK as GRS_NAME')->where('jobs.id', $id)->distinct()->get();
            $queue = DB::table('camp_'.$camptype[0]->id)->limit(1)->get();
            $land = DB::table('landing_page')->where('CAMP_ID_FK', $id)->limit(1)->get();
            //dd(DB::getQueryLog());
            //return 'regular';
        }
        else {
            $camp = DB::table("jobs")
                ->join('users', 'users.id', '=', 'jobs.US_ID_FK')
                ->select('jobs.id as CMP_ID', 'jobs.name as CMP_NAME', 'jobs.type as CMP_TYPE',
                    'jobs.sendingtype as CAMP_ST', 'users.username as US_NAME', 'jobs.SENDER_FK_ID as SENDER_NAME',
                    'jobs.GRS_ID_FK as GRS_NAME', 'jobs.sending_date as Q_DATE', 'jobs.body as BODY')->where('jobs.id', $id)->distinct()->get();
            $queue = DB::table('camp_'.$camptype[0]->id)->limit(1)->get();
            $land = DB::table('landing_page')->where('CAMP_ID_FK', $id)->limit(1)->get();
            // dd(DB::getQueryLog());

        }
        return view('campaigns.edit')->with("camp", $camp)->with('queue', $queue)->with('land', $land);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getLast(){
         $last = DB::table('campaigns')->where('campaigns.approved','0')->orderBy('id', 'DESC')->limit(1)->get();
          return $last;
    }

    public function newItem(){
         $camp = DB::table("campaigns")
             ->join('users', 'users.id', '=', 'campaigns.US_ID_FK')
             ->join('sender', 'sender.id', '=', 'campaigns.SENDER_FK_ID')
             ->join('groups', 'groups.id', '=', 'campaigns.GRS_ID_FK')
             ->leftjoin('queue', 'campaigns.id', '=', 'queue.CAMP_ID_FK')
            ->select('campaigns.id as CMP_ID', 'campaigns.name as CMP_NAME', 'campaigns.type as CMP_TYPE', 
            'campaigns.sendingtype as CAMP_ST', 'users.username as US_NAME', 'sender.name as SENDER_NAME',
            'groups.name as GRS_NAME', 'queue.date as Q_DATE')->where('campaigns.approved','0')->distinct()->get();
            $last = DB::table('campaigns')->where('campaigns.approved','0')->orderBy('id', 'DESC')->limit(1)->get();
           // dd(DB::getQueryLog());
            return view('campaigns.index')->with("camp", $camp)->with('last',$last)->with('success', 'New Campaign. check below');
    }

    public function approveIt($id){
        $camp = DB::table('jobs')->where('id', $id)
            ->get();
        $cred =  DB::table('credits')->where('US_ID_FK', $camp[0]->US_ID_FK)
            ->get();
         DB::table('jobs')
                ->where('id', $id)
                ->update(['approved' =>  1]);
        DB::table('jobs')
            ->where('id', $id)
            ->update(['status' =>  "ONGOING"]);
         DB::table('camp_'.$camp[0]->id)
            ->update(['status' => '0']);
        DB::table('credits_logs')->insert([
            'US_ID_FK' => $camp[0]->US_ID_FK,
            'credits' => $camp[0]->credits
        ]);
        DB::table('credits')
            ->where('US_ID_FK', $camp[0]->US_ID_FK)
            ->update([
                'credit' => $cred[0]->credit - $camp[0]->credits,
            ]);
        $body = "Your Message has been approved from Zain, it will be sent on:".$camp[0]->sending_date.". Thank you.";
        $sender = 'ZAIN_ADMIN';
        $number='';
        $user = DB::table('users')->select('phone')->where('id', $camp[0]->US_ID_FK)->get();
        foreach ($user as $uss) {
            $number = $uss->phone;
        }
        $response = file_get_contents("http://localhost:8800/PhoneNumber=".$number."&sender=".$sender."&text=".urlencode($body)."&SMSCROute=SMPP%20-%20172.16.36.50:31113");
        echo "OK";

    }

    public function declineIt($id){
        $camp = DB::table('campaigns')->where('id', $id)
            ->get();
         DB::table('jobs')
                ->where('id', $id)
                ->update(['approved' =>  -1]);
        DB::table('camp_'.$camp[0]->id)
            ->where('CAMP_ID_FK', $id)
            ->delete();

        $body = "Your Message has been declined from Zain, Please call them for more information. Thank you.";
        $sender = 'ZAIN_ADMIN';
        $number='';
        $user = DB::table('users')->select('phone')->where('id', $camp[0]->US_ID_FK)->get();
        foreach ($user as $uss) {
            $number = $uss->phone;
        }
        $response = file_get_contents("http://localhost:8800/PhoneNumber=".$number."&sender=".$sender."&text=".urlencode($body)."&SMSCROute=SMPP%20-%20172.16.36.50:31113");
    }
}
