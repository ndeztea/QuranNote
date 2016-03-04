<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function login(){
        $data[''] = '';
        $dataHTML['modal_class'] = 'login-mode';
        $dataHTML['modal_title'] = 'Masuk dahulu';
        $dataHTML['modal_body'] = view('auth_login',$data)->render();
        $dataHTML['modal_footer'] = 'Lupa Password ?';

        return response()->json($dataHTML);
    }

    public function registerProcess(Request $request){
        $validator = $this->validator($request->all());

        // validation
        if ($validator->fails()) {
            $messageErrors = $validator->errors();
            $errorHtml = '<ul>';
            foreach($messageErrors as $error){
                $errorHtml .= '<li>'.$error.'</li>';
            }
            $errorHtml .= '</ul>';

            $dataHTML['modal_error'] = $errorHtml;
            $dataHTML['success'] = false;

            return response()->json($dataHTML);
        }

        // save now
        Auth::login($this->create($request->all()));
        $dataHTML['success'] = true;

        return response()->json($dataHTML);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $errorMessages = [
            'name.required' => 'Nama harus di isi',
            'name.required' => 'Email harus di isi',
            'email.unique' => 'Email sudah di pakai, gunakan email yang lain',
            'password.required' => 'Email harus di isi'
        ];
        
        return Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ],$errorMessages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
