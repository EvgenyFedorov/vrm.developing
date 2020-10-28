<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users\Roles;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $request = null;
    public $user = null;
    public $response = array();

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        print "<pre>";

        $this->user = $this->request->user();
        $user = User::find($this->user->roles_id)->roles;
        //$user = Roles::find(1)->user;

        //
        //$this->user->roles =
        //print $this->user->roles_id;

        print_r($user);

    }
}
