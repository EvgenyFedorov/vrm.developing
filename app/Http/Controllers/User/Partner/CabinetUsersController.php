<?php

namespace App\Http\Controllers\User\Partner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\RolesController;
use App\Http\Controllers\User\UserController;
use App\Models\User;
use App\Models\Users\Accesses;
use App\Models\Users\Programs;
use App\Models\Users\Roles;
use App\Repositories\Filter\FilmsRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CabinetUsersController extends UserController
{
    public $request = null;
    public $user = null;

    public $roles = null;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth');
    }

    public function redirect($url = null){
        return ($url == null) ? redirect('/logs') : redirect($url);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if($result = $this->isRole()){

            $response = $this->response()->Json()->getResult();

            $edit_user = $this->users()->getEdit($result['user']->id);
            $edit_user[0]->privileges = json_decode($edit_user[0]->privileges);

            return view($result['role']['dir'] . '.users.edit', [
                'user' => $result['user'],
                'role' => $result['role'],
                'edit_user' => $edit_user[0],
            ]);

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($result = $this->isRole()){

            $edit_user = $this->users()->getEdit($id);
            $edit_user[0]->privileges = json_decode($edit_user[0]->privileges);

            $time_zones = $this->time_zones()->getAll();

            $programs = $this->programs()->getEditUser();

            $jobs = $this->jobs()->getEdit($id);

            return view($result['role']['dir'] . '.users.edit', [
                'user' => $result['user'],
                'role' => $result['role'],
                'edit_user' => $edit_user[0],
                'programs' => $programs,
                'jobs' => $jobs,
                'time_zones' => $time_zones
            ]);

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
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
        if($result = $this->isRole()){

            $input = $request->input();
            $response = $this->response()->Json();

            if(isset($input['name']) && isset($input['email'])){

                $user = User::find($id);
                $user->name = $input['name'];
                $user->email = $input['email'];
                $user->updated_at = date("Y-m-d H:i:s");

                if(isset($input['password']) && isset($input['password_confirm']) && ($input['password'] == $input['password_confirm'])) {

                    $user->password = bcrypt($input['password']);
                    $user->save();
                    $response->setData('error_status', 'false');
                    $response->setData('user_id', $id);

                }elseif(isset($input['password']) && isset($input['password_confirm']) && ($input['password'] != $input['password_confirm'])){

                    $response->setData('error_status', 'true');
                    $response->setData('error_message', 'Введенные пароли не совпадают!');

                }else{

                    $user->save();
                    $response->setData('error_status', 'false');
                    $response->setData('user_id', $id);

                }

            }else{

                $response->setData('error_status', 'true');
                $response->setData('error_message', 'Заполнены не все обязательные поля!');

            }

            return $response->jsonEncode();

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }

    public function enableUser(Request $request){

        if($result = $this->isRole()){

            $input = $request->input();
            $response = $this->response()->Json();

            $user = User::find($input['user_id']);
            $user->enable = ($user->enable == "1") ? 0 : 1;
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();

            $response->setData('error_status', 'false');
            $response->setData('user_id', $input['user_id']);
            $response->setData('user_class', ($user->enable == "1") ? "default" : "table-danger");

            return $response->jsonEncode();

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($result = $this->isRole()){



        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }
}
