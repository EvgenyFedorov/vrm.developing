<?php

namespace App\Http\Controllers\User\Partner;

use App\Http\Controllers\User\UserController;
use App\Models\User;
use App\Models\Users\Accesses;
use App\Models\Users\Programs;
use App\Models\Users\Seances;
use App\Repositories\Films\FilmsRepository;
use App\Repositories\Mobiles\MobilesRepository;
use App\Repositories\Seances\SeancesRepository;
use Auth;
use Composer\DependencyResolver\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabinetSeancesController extends UserController
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
        return ($url == null) ? redirect('/users') : redirect($url);
    }

    public function changeProgram(){

        $request = $this->request();
        $inputs = $this->inputs();
        return $this->update($request, $inputs['user_id']);

    }

    public function updatePlay($id){

        $response = $this->response()->Json();

        DB::beginTransaction();

        $seance = Seances::find($id);
        $seance->status = 2;
        $seance->save();

        DB::commit();

        $response->setData('error_status', 'false');
        $response->setData('id', $seance->id);

        return $response->jsonEncode();

    }

    public function updatePause($id){

        $response = $this->response()->Json();

        DB::beginTransaction();

        $seance = Seances::find($id);
        $seance->status = 3;
        $seance->save();

        DB::commit();

        $response->setData('error_status', 'false');
        $response->setData('id', $seance->id);

        return $response->jsonEncode();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SeancesRepository $seancesRepository, FilmsRepository $filmsRepository, MobilesRepository $mobilesRepository)
    {

        if($result = $this->isRole()){

            $data_seances = $seancesRepository->getSeances($result['user']->id);
            $data_films = $filmsRepository->getFilms();
            $data_mobiles = $mobilesRepository->getMobilesSelected($result['user']->id);

            return view($result['role']['dir'] . '.seances.list', [
                'user' => $result['user'],
                'role' => $result['role'],
                'data_seances' => $data_seances,
                'data_films' => $data_films,
                'data_mobiles' => $data_mobiles
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

            $data_users = $this->users()->getForSelect();

            return view($result['role']['dir'] . '.seances.create', [
                'user' => $result['user'],
                'role' => $result['role'],
                'data_users' => $data_users
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
    public function store(Request $request, MobilesRepository $mobilesRepository)
    {
        if($result = $this->isRole()){

            $input = $request->input();
            $response = $this->response()->Json();

            DB::beginTransaction();

            $seance = $this->seances();
            $seance->user_id = $result['user']->id;
            $seance->film_id = $input['film_id'];
            $seance->status = 1;
            $seance->enable = 1;
            $seance->created_at = date("Y-m-d H:i:s");
            $seance->save();

            $data_mobiles = $mobilesRepository->getMobiles($result['user']->id);

            if($data_mobiles !== false){

                foreach ($data_mobiles as $data_mobile){

                    if($data_mobile->status == 1){

                        $data_mobile->seances_id = $seance->id;
                        $data_mobile->save();

                    }

                }

                $response->setData('error_status', 'false');
                $response->setData('id', $seance->id);

            }else{

                $response->setData('error_status', 'true');

            }

            DB::commit();

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

            $program = Programs::find($id);
            $data_users = $this->users()->getForSelect();

            return view($result['role']['dir'] . '.seances.edit', [
                'user' => $result['user'],
                'role' => $result['role'],
                'data_users' => $data_users,
                'program' => $program,
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

            // Запрос отправлен Ajax хелпером, это значит что быстрое добавление или удаление прилы у юзера
            if(isset($input['response_type']) AND $input['response_type'] == "json"){

                $edit_user = $this->users()->getEdit($id);
                $edit_user[0]->privileges = json_decode($edit_user[0]->privileges);

                // Грузим объект
                //$program = $this->programs();

                // Ищем прилу по переданному ID
                //$search_program = $program::find(['id', $inputs['program_id']]);

                // Если прила уже есть у юзера
                if(in_array($input['program_id'], $edit_user[0]->privileges->show_programs)){
                    // Значит удаляем ее

                    // Различные манипуляции с массивом что бы удалить ID
                    $edit_user[0]->privileges->show_programs = array_flip($edit_user[0]->privileges->show_programs);
                    unset($edit_user[0]->privileges->show_programs[$input['program_id']]);
                    $edit_user[0]->privileges->show_programs = array_flip($edit_user[0]->privileges->show_programs);

                }else{
                    // Иначе добавляем
                    $edit_user[0]->privileges->show_programs[] = $input['program_id'];
                }

                $programs = [];

                // Обновляем массив
                foreach ($edit_user[0]->privileges->show_programs as $id){
                    $programs[] = $id;
                }

                // Сораняем данные
                $accesses = Accesses::find($edit_user[0]->accesses_id);
                $accesses->privileges = json_encode(["show_programs" => $programs]);;
                $accesses->updated_at = date("Y-m-d H:i:s");
                $accesses->save();

                $response->setData('error_status', 'false');
                $response->setData('id', $input['program_id']);

                return $response->jsonEncode();

            }else{

                $program = Programs::find($input['program_id']);

                $program->name = $input['program_name'];
                $program->bot_name = $input['program_bot_name'];
                $program->enable = ($input['program_enable'] == "true") ? 1 : 0;
                $program->updated_at = date("Y-m-d H:i:s");
                $program->save();

                if(isset($input['users_id']) && !empty($input['users_id'])) {

                    $users_ids = explode(",", $input['users_id']);

                    if (in_array("[all]", $users_ids)) {

                        $users = $this->users()->getForSelect();

                        DB::beginTransaction();

                        foreach ($users as $user) {

                            $privileges = $user->privileges;
                            $accesses_program = json_decode($privileges);
                            $programs_array = $accesses_program->show_programs;

                            // Если прила уже есть у юзера (проверяем на всякий случай что бы небыло двойных)
                            if (in_array($program->id, $programs_array)) {
                                // Значит удаляем ее

                                // Различные манипуляции с массивом что бы удалить ID
                                $programs_array = array_flip($programs_array);
                                unset($programs_array[$program->id]);
                                $programs_array = array_flip($programs_array);

                            } else {
                                // Иначе добавляем
                                $programs_array[] = $program->id;
                            }

                            if ($programs_array) {

                                $new_programs = [];

                                // Обновляем массив
                                foreach ($programs_array as $id) {
                                    $new_programs[] = $id;
                                }

                                // Сораняем данные
                                $accesses = Accesses::find($user->accesses_id);
                                $accesses->privileges = json_encode(["show_programs" => $new_programs]);
                                $accesses->updated_at = date("Y-m-d H:i:s");
                                $accesses->save();

                            }

                        }

                        DB::commit();

                        $response->setData('error_status', 'false');
                        $response->setData('id', $program->id);

                        return $response->jsonEncode();

                    } else {

                        DB::beginTransaction();

                        foreach ($users_ids as $users_id) {

                            $id = str_replace("[", "", str_replace("]", "", $users_id));

                            $accesses = $this->accesses()->getAccess($id);

                            foreach ($accesses as $accesse) {

                                $privileges = $accesse->privileges;
                                $accesses_program = json_decode($privileges);
                                $programs_array = $accesses_program->show_programs;

                                // Если прила уже есть у юзера (проверяем на всякий случай что бы небыло двойных)
                                if (in_array($program->id, $programs_array)) {
                                    // Значит удаляем ее

                                    // Различные манипуляции с массивом что бы удалить ID
                                    $programs_array = array_flip($programs_array);
                                    unset($programs_array[$program->id]);
                                    $programs_array = array_flip($programs_array);

                                } else {
                                    // Иначе добавляем
                                    $programs_array[] = $program->id;
                                }

                                $new_programs = [];

                                // Обновляем массив
                                foreach ($programs_array as $id) {
                                    $new_programs[] = $id;
                                }

                                // Сораняем данные
                                $accesses = Accesses::find($accesse->id);
                                $accesses->privileges = json_encode(["show_programs" => $new_programs]);;
                                $accesses->updated_at = date("Y-m-d H:i:s");
                                $accesses->save();


                            }

                        }

                        DB::commit();

                    }

                }

                $response->setData('error_status', 'false');
                $response->setData('id', $input['program_id']);

                return $response->jsonEncode();

            }

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
