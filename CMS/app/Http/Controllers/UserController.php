<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\users;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use  Auth;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $fullname;
    private $user;
    private $email;
    private $pass;

    public function index()
    {
        if (Auth::check()) {
            $users = DB::table("users")->get();
            return view('users.index')->with("users", $users);

        } else {
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
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'company' => 'required',
            'filter' => 'required'
        ]);
        $username = $request->input('username');
        $this->fullname = $request->input('fname');
        $this->user = $request->input('username');
        $this->email = $request->input('email');
        $this->pass = $request->input('pass');
        $file = $request->file('image');
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $nameimg = $file->getClientOriginalName();
        $file->move('../../uploads/', $nameimg);
        DB::table('users')->insert([
            'full_name' => $this->fullname,
            'username' => $username,
            'email' => $request->input('email'),
            'password' => hash("sha256", $request->input('pass')),
            'phone' => $request->input('phone'),
            'photo' => './uploads/' . $nameimg,
            'company' => $request->input('company'),
            'address' => $request->input('address'),
            'filter' => $request->input('filter'),
            'active' => 1,
            'created_at' => Carbon::now()
        ]);
        $id = DB::getPdo()->lastInsertId();
        $contact = "CREATE TABLE `contacts_" . $id . "` (
                `id` int(10) NOT NULL AUTO_INCREMENT, `firstname` varchar(191) DEFAULT NULL,
                `lastname` varchar(191)  DEFAULT NULL,
                `email` varchar(191)  DEFAULT NULL,
                `gender` varchar(191)  DEFAULT NULL,
                `address` varchar(191) DEFAULT NULL,
                `MSISDN` BIGINT(20) NOT NULL,
                `GRS_ID_FK` varchar(191) NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `active` int(11) NOT NULL, PRIMARY KEY (`id`))
                ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;";
        DB::statement($contact);
        DB::table('credits')->insert([
            'credit' => '0',
            'US_ID_FK' => $id,
            'active' => 1,
            'created_at' => Carbon::now()
        ]);
        //$data = DB::table('users')->where('id', $id)->get();
        Mail::send([], [], function ($message) {
            $message->from('mohammad.kassab@mediaworldiq.com', 'M KASSAB');
            $message->sender('mohammad.kassab@mediaworldiq.com', 'mohammad.kassab@mediqworldiq.com');
            $message->to($this->email, $this->user);
            $message->subject('ADVANCED BULK SMS');
            $message->setBody('<h1>Hi, ' . $this->fullname . '</h1><br/>
                            <p><i>Your Account has been successfully created, please find your credentials Below:</i></p><br/>
                            <ul>
                                <li>Email: ' . $this->email . ' <b> OR </b> Username: ' . $this->user . '</li>
                                <li>Password: ' . $this->pass . '</li></ul>
                            <h5>You can Sign in here: http://mediaworldiq.org:8008/SMS    </h5><br/><br/>
                            <h2>MEDIA WORLD TEAM</h2><br/><br/>
                            <h6>Kindly, Do not reply to this email</h6>', 'text/html');
        });
        return redirect('/users')->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function downloadZip($id)
    {
        return response()->download(public_path('new_users/user_' . $id . '.zip'));
    }

    public function show($id)
    {
        $user = DB::table('users')->join('users_status', 'users.id', '=', 'users_status.US_ID')
            ->select('users.*', 'users_status.US_ID', 'users_status.notes')
            ->where('users.id', $id)->get();
        return view('users.view')->with('users', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request, $id)
    {
        $s = DB::table('users_status')->select('id')->where('US_ID', $id)->get();
        $user = DB::table('users')->select('phone')->where('id', $id)->get();
        foreach ($s as $ss) {
            if ($ss->id != "") {
                DB::table('users_status')->where('US_ID', $id)->update([
                    'status' => -1,
                    'notes' => $request->input('notes')
                ]);
                DB::table('users')->where('id', $id)->update([
                    'doc_uploaded' => -1,
                ]);
                $body = "Your signup process has been rejected, Please contact zain for more details";
                $sender = 'ZAIN_ADMIN';
                $number = '';
                foreach ($user as $uss) {
                    $number = $uss->phone;
                }
                $response = file_get_contents("http://localhost:8800/PhoneNumber=" . $number . "&sender=" . $sender . "&text=" . urlencode($body) . "&SMSCROute=SMPP%20-%20172.16.36.50:31113");
                echo "OK";
            } else {
                DB::table('users_status')->insert([
                    'US_ID' => $id,
                    'status' => -1,
                    'notes' => $request->input('notes')
                ]);
                DB::table('users')->where('id', $id)->update([
                    'doc_uploaded' => -1,
                ]);
                $body = "Your signup process has been rejected, Please contact Zain for more details";
                $sender = 'ZAIN_ADMIN';
                $number = '';
                foreach ($user as $uss) {
                    $number = $uss->phone;
                }
                $response = file_get_contents("http://localhost:8800/PhoneNumber=" . $number . "&sender=" . $sender . "&text=" . urlencode($body) . "&SMSCROute=SMPP%20-%20172.16.36.50:31113");
                echo "OK";
            }
        }
        return redirect()->back()->with('success', 'Rejected');
    }

    public function approveDocs($id)
    {
        $user = DB::table('users')->select('phone')->where('id', $id)->get();
        DB::table('users')->where('id', $id)->update([
            'doc_uploaded' => 1,
        ]);
        DB::table('users_status')->where('US_ID', $id)->update([
            'status' => 1,
            'notes' => 'Approved'
        ]);
        $body = "Your signup process has been approved, You can login from here https://smscorp.iq.zain.com/SMS/";
        $sender = 'ZAIN_ADMIN';
        $number = '';
        foreach ($user as $uss) {
            $number = $uss->phone;
        }
        $response = file_get_contents("http://localhost:8800/PhoneNumber=" . $number . "&sender=" . $sender . "&text=" . urlencode($body) . "&SMSCROute=SMPP%20-%20172.16.36.50:31113");
        echo "OK";

        return redirect('./users')->with('success', 'Docs Approved, now you can activate the user..');
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('id', $id)->get();
        return view('users.edit')->with('users', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required',
            'fullname' => 'required',
            'email' => 'required',
            'address' => 'required',
            'company' => 'required',
            'phone' => 'required'
        ]);
        $username = $request->input('username');
        $file = $request->file('image');
        if ($file != '') {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            ]);
            $nameimg = $file->getClientOriginalName();
            $file->move('../../uploads/', $nameimg);

            DB::table('users')
                ->where('id', $id)
                ->update(['username' => $username,
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'company' => $request->input('company'),
                    'phone' => $request->input('phone'),
                    'photo' => './uploads/' . $nameimg,
                    'filter' => $request->input('filter')
                ]);
        } else {
            DB::table('users')
                ->where('id', $id)
                ->update(['username' => $username,
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'company' => $request->input('company'),
                    'phone' => $request->input('phone'),
                    'filter' => $request->input('filter')
                ]);
        }

        return redirect('/users')->with('success', 'user UPDATED !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->update(['active' => 0]);
        return redirect('/users')->with('success', 'user has been desactivated !');
    }

    public function deleteUser($id)
    {
        DB::insert("insert into deleted_users (`full_name`, `id`, `username`, `email`, `password`, `address`, `phone`, `company`, `photo`, `filter`, `active`, `doc_uploaded`, `created_at`)
        select * from users where id=$id");
        DB::table('users')->where('id', $id)->delete();
        return redirect('/users')->with('success', 'user has been Deleted successfully !');
    }

    public function activate($id)
    {
        DB::table('users')->where('id', $id)->update(['active' => 1]);
        return redirect('/users')->with('success', 'user has been Activated !');
    }
}
