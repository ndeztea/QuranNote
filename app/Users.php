<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Users extends Model
{
    //
    protected $table = 'users';
    public $id;
    public $name;
    public $email;
    public $password;
    public $state;
    public $id_surah;
    public $id_ayat;
    public $is_active;
    public $city;
    public $address;

    protected $fillable = array('name', 'email', 'password','city','address','hp','device_id');

    public function login($data){
    	// login code
         $juz = DB::table('users')
                ->select('*')
                ->where('username','=',$data['username'])
                ->where('password','=', Hash::make($data['password']))
                ->orderBy('id','asc')
                ->get();


        return $juz;
    }

    public function getUsersDevicetId($deviceId){
         $juz = DB::table('users')
                ->select('*')
                ->where('device_id','=',$deviceId)
                ->orderBy('id','asc')
                ->get();


        return $juz;
    }
}
