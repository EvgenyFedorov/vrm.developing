<?php

namespace App\Http\Controllers\User\Partner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\RolesController;
use App\Http\Controllers\User\UserController;
use App\Models\Bot\Jobs;
use App\Models\User;
use App\Models\Users\Accesses;
use App\Repositories\Job\JobRepository;
use Auth;
use Illuminate\Http\Request;

class CabinetLogsController extends UserController
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

    public function index(JobRepository $jobRepository)
    {

        if($result = $this->isRole()){

            //$data_jobs = $this->jobs()->getEdit($result['user']->id);
            //$time_zone = TimeZones::find($result['user']->time_zone_id);

            $data_jobs = $jobRepository->getData(null, $result['user']->id);
            $job_statuses = $jobRepository->getStatuses();

            return view($result['role']['dir'] . '.logs.list', [
                'user' => $result['user'],
                'role' => $result['role'],
                'data_jobs' => $data_jobs,
                //'time_zone' => $time_zone,
                'job_statuses' => $job_statuses
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

            $accesses = User::find($result['user']->id)->accesses;
            $privileges = json_decode($accesses->privileges);

            $programs = $this->programs()->getEditJob($privileges->show_programs);

            return view($result['role']['dir'] . '.logs.create', [
                'user' => $result['user'],
                'role' => $result['role'],
                'programs' => $programs,
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

            $error_codes = "";

            if(isset($input['program_id']) && !empty($input['program_id'])) {

                if (isset($input['job_code']) && !empty($input['job_code'])) {

                    $array_codes = explode(",", $input['job_code']);

                    $response->setData('error_status', 'false');

                    foreach ($array_codes as $array_code) {

                        if (preg_match('/^\+?\d+$/', $array_code)) {

                            $job = new Jobs();
                            $job->user_id = $input['user_id'];
                            $job->code_id = $array_code;
                            $job->program_id = $input['program_id'];
                            $job->save();

                        } else {

                            $error_codes .= $array_code . ',';

                            $response->setData('error_status', 'true');
                            $response->setData('error_message', 'Один из кодов содержит запрещенные символы: ');

                        }

                    }

                }else{

                    $response->setData('error_status', 'true');
                    $response->setData('error_message', 'Вы должны ввести хотя бы 1 код!');

                }

            }else{

                $response->setData('error_status', 'true');
                $response->setData('error_message', 'Приложение не выбрано!');

            }

            if($response->getData('error_status') == "true"){
                $response->setData('error_code', $error_codes);
            }else{
                $response->setData('success_message', 'Расшаривание будет проведено через 10 минут!');
            }

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

//            $accesses = User::find($result['user']->id)->accesses;
//            $privileges = json_decode($accesses->privileges);
//
//            $programs = $this->programs()->getEditJob($privileges->show_programs);
//
//            $edit_job = $this->jobs()->getEditOne($id);
//
//            return view($result['role']['dir'] . '.logs.edit', [
//                'programs' => $programs,
//                'edit_job' => $edit_job[0],
//            ]);

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

            $job = Jobs::find($id);
            $job->code_id = $input['job_code'];
            $job->program_id = $input['program_id'];
            $job->updated_at = date("Y-m-d H:i:s");
            $job->save();

            $response->setData('error_status', 'false');
            $response->setData('job_id', $id);

            return $response->jsonEncode();

        }else{
            Auth::logout();
            return redirect('/access-denied');
        }
    }

    public function enableLog(Request $request){

        if($result = $this->isRole()){

            $input = $request->input();
            $response = $this->response()->Json();

            $job = Jobs::find($input['job_id']);
            $job->enable = ($job->enable == "1") ? 0 : 1;
            $job->updated_at = date("Y-m-d H:i:s");
            $job->save();

            $response->setData('error_status', 'false');
            $response->setData('job_id', $input['job_id']);
            $response->setData('job_class', ($job->enable == "1") ? "default" : "table-danger");

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
