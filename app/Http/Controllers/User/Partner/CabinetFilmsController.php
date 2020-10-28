<?php

namespace App\Http\Controllers\User\Partner;

use App\Http\Controllers\User\UserController;
use App\Models\User;
use App\Models\Users\Accesses;
use App\Models\Users\Films;
use App\Models\Users\Mobiles;
use App\Models\Users\Programs;
use App\Repositories\Films\FilmsRepository;
use Auth;
use Composer\DependencyResolver\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabinetFilmsController extends UserController
{
    public $request = null;
    public $user = null;

    public $roles = null;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth');

        $this->request = $request;
    }

    public function redirect($url = null){
        return ($url == null) ? redirect('/users') : redirect($url);
    }

    public function changeProgram(){

        $request = $this->request();
        $inputs = $this->inputs();
        return $this->update($request, $inputs['user_id']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilmsRepository $filmsRepository)
    {

        if($result = $this->isRole()){

            $data_films = $filmsRepository->getFilms();

            return view($result['role']['dir'] . '.films.list', [
                'user' => $result['user'],
                'role' => $result['role'],
                'data_films' => $data_films
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
        if($result = $this->isRole()){

            //$data_users = $this->users()->getForSelect();

            return view($result['role']['dir'] . '.films.create', [
                'user' => $result['user'],
                'role' => $result['role'],
                //'data_users' => $data_users
            ]);

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($result = $this->isRole()){

            $input = $request->input();

            $response = $this->response()->Json();

            DB::beginTransaction();

            $mobiles = $this->mobiles();
            $mobiles->name = $input['phone_name'];
            $mobiles->secret_key = $input['secret_key'];
            $mobiles->enable = ($input['phone_enable'] == "true") ? 1 : 0;
            $mobiles->created_at = date("Y-m-d H:i:s");
            $mobiles->save();

            DB::commit();

            $response->setData('error_status', 'false');
            $response->setData('id', $mobiles->id);

            return $response->jsonEncode();

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($result = $this->isRole()){



        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
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

            DB::beginTransaction();

            $film = Films::find($id);

            $order = $this->order();
            $order->film_id = $id;
            $order->amount = $film->film_amount;
            $order->enable = 1;
            $order->status = 1;
            $order->updated_at = date("Y-m-d H:i:s");
            $order->save();

            DB::commit();

            $response->setData('error_status', 'false');
            $response->setData('id', $order->id);

            return $response->jsonEncode();


        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }

    public function enableProgram(Request $request){

        if($result = $this->isRole()){

            $input = $request->input();
            $response = $this->response()->Json();

            $program = Programs::find($input['program_id']);
            $program->enable = ($program->enable == "1") ? 0 : 1;
            $program->updated_at = date("Y-m-d H:i:s");
            $program->save();

            $response->setData('error_status', 'false');
            $response->setData('program_id', $input['program_id']);
            $response->setData('program_class', ($program->enable == "1") ? "default" : "table-danger");

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
