<?php

namespace App\Http\Controllers;

use DB;
use Image;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Memo;
use App\Libraries\Points;

use File;

class ProfileController extends Controller
{
  public function detail(Request $request){
    $UsersModel = new Users;
    $MemoModel = new Memo;
    $id_user = $request->segment(3);
    $data['header_top_title'] = $data['header_title'] = 'Profile Hafizh';
    $data['detailProfile'] = $UsersModel->getDetail($id_user)[0];

    $classDetail = $UsersModel->getClassDetail($data['detailProfile']->id_class);
    $data['classDetail'] = $classDetail;
    $data['needCorrections'] = $MemoModel->getNeedCorrection(0,20,$id_user);
    $data['listMemoz'] = $MemoModel->getAnotherList(session('sess_id'),0,0,20,$id_user);
    $data['listDone'] = $MemoModel->getAnotherList(session('sess_id'),1,0,20,$id_user);

    if($data['detailProfile']->id_sub_class){
      $data['subClassDetail'] = $UsersModel->getClassDetail($data['detailProfile']->id_sub_class);
    }

    $objPoints = new Points();
    $total_points = $objPoints->totalPoints($id_user,'all');
    $data['countMemoz'] = $MemoModel->getCountList($id_user,'all');
    $data['countPoints'] = $total_points;
    return view('profile_detail',$data);
  }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $userId = $request->segment(3)?$request->segment(3):session('sess_id');
        $addUrl = $request->segment(3)?'/'.$request->segment(3):'';
        $data['header_top_title'] = $data['header_title'] = 'Edit Profile';
        $data['body_class'] = 'body-editprofile';
        $UsersModel = new Users;

        if($request->get('action')!=''){
            // change password
            $password = $request->get('password');
            $password_confirmation = $request->get('password');
            if($password!=''){
                if($password==$password_confirmation){
                    if (session('sess_role')==4){
                      $dataPass['password2'] = Hash::make($password);
                    }else{
                      $dataPass['password'] = Hash::make($password);
                    }

                    $dataPass['id'] = $userId;
                    $UsersModel->edit($dataPass);

                }else{
                    return redirect('profile/edit'.$addUrl)->with('messageError', 'Password tidak sama')->withInput();
                }
            }

            // change profile data
            $dataProfile['id'] = $userId;
            $dataProfile['name'] = $request->get('name');
            $dataProfile['city'] = $request->get('city');
            $dataProfile['address'] = $request->get('address');
            $dataProfile['gender'] = $request->get('gender');
            $dataProfile['hp'] = $request->get('hp');
            $dataProfile['dob'] = $request->get('dob');
            $dataProfile['id_class'] = $request->get('id_class');
            $UsersModel->edit($dataProfile);

            assignPoints($userId,'profile.edit');
            return redirect('profile/edit'.$addUrl)->with('messageSuccess', 'Profile berhasil disimpan')->withInput();

        }

        // avatar
        $data['detailUser'] = $UsersModel->getDetail($userId)[0];
        $listClasses = $UsersModel->getClass();
        $data['listClasses'] = $listClasses;
        $data['listSubClasses'] = $UsersModel->getSubClass(session('sess_id_class'));

        return view('profile_edit',$data);
    }

    public function delete(Request $request)
    {
      $UsersModel = new Users;
      $userId = $request->segment(3);
      $data['detailUser'] = $UsersModel->getDetail($userId)[0];
      $UsersModel->remove($userId);

      return redirect('profile/list?id_class='.$data['detailUser']->id_class)->with('messageSuccess', 'Profile berhasil dihapus')->withInput();

    }

    public function resetPassword(Request $request){
      $UsersModel = new Users;
      $id_user = $request->segment(3);
      $type = $request->segment(4);
      if($type=='parent'){
        $dataPass['password2'] = Hash::make('passwordortu');
      }else{
        $dataPass['password'] = Hash::make('password');
      }

      $dataPass['id'] = $id_user;
      $UsersModel->edit($dataPass);
      return redirect('profile/list')->with('messageError', 'Password sudah direset');
    }

    public function uploadAvatar(Request $request){
        $UsersModel = new Users;
        $detailUser = $UsersModel->getDetail(session('sess_id'))[0];

        if(!empty($request->file('avatar'))){
            if ($request->file('avatar')->isValid()) {
                $fileName = session('sess_id').uniqid('_avatar_').'.jpg';
                $path = $request->file('avatar')->move(public_path('assets/images/avatar'), $fileName);
                // make sure upload sucess
                if(File::exists($path)){
                    // resize
                    Image::make($path)->resize(null,200, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path);

                    // remove old photo
                    File::delete(public_path('assets/images/avatar/'.$detailUser->avatar));

                    // store to DB
                    $dataProfile['avatar'] = $fileName;
                    $dataProfile['id'] = session('sess_id');
                    $UsersModel->edit($dataProfile);
                    assignPoints(session('sess_id'),'profile.avatar');
                    return redirect('profile/edit')->with('messageSuccess', 'Profile avatar berhasil disimpan')->withInput();
                }else{
                    return redirect('profile/edit')->with('messageError', 'Profile avatar gagal disimpan')->withInput();
                }
            }else{
                return redirect('profile/edit')->with('messageError', 'Profile avatar gagal disimpan')->withInput();
            }
        }else{
            return redirect('profile/edit')->with('messageError', 'Profile avatar gagal disimpan')->withInput();
        }

    }

    public function listing(Request $request){
        $data['header_top_title'] = $data['header_title'] = 'Daftar Siswa';
        $data['body_class'] = 'body-editprofile';

        $UsersModel = new Users;
        $id_class = session('sess_role')==2?session('sess_id_class'):$request->input('id_class');
        $id_sub_class = empty($request->input('id_sub_class'))?session('sess_id_sub_class'):$request->input('id_sub_class');
        $keyword = $request->input('keyword');
        $gender = $request->input('gender','');
        // show all
        $gender = '';
        $page = $request->input('page',1);

        $listClasses = $UsersModel->getClass();
        $listUsers = $classDetail =  array();
        $countTotalUsers = $UsersModel->getCountList();
        $countUsers = 0;
        if($id_class){
            $listUsers = $UsersModel->getList($id_class,$gender,$keyword,$page);
            $countUsers = $UsersModel->getCountList($id_class,$gender,$keyword);
            $classDetail = $UsersModel->getClassDetail($id_class);

            if(is_int($countUsers)){
                $pages = round($countUsers / 10);
                $data['pages'] = $pages;
                $data['page'] = $page;
            }
        }

        $rolesManual = array('Adab','Ahlak','LA','Keaktifan','Lainnya');

        $data['no'] = (($page-1)*10)+1;
        $data['id_class'] = $id_class;
        $data['keyword'] = $keyword;
        $data['classDetail'] = $classDetail;
        $data['listUsers'] = $listUsers;
        $data['listClasses'] = $listClasses;
        $data['rolesManual'] = $rolesManual;
        $data['countUsers'] = $countUsers;
        $data['countTotalUsers'] = $countTotalUsers;
        $data['gender'] = $gender;
        $data['listSubClasses'] = $UsersModel->getSubClass(session('sess_id_class'));

        return view('profile_list',$data);
    }

    public function addPointsManual(Request $request){
        $id_users = $request->input('id_users');
        $action = $request->input('action');
        $points = $request->input('points');

        if(!empty($id_users) && !empty($points) && !empty($action)){
            foreach ($id_users as $id_user) {
                addPoints($id_user,$action,$points);
            }
            return redirect()->back()->with('messageSuccess', 'Points berhasil ditambahkan')->withInput();
        }
        return redirect()->back()->with('messageError', 'Points gagal ditambahkan')->withInput();



    }

    public function updateClass(Request $request){
        $id_users = $request->input('id_users');
        $id_class_target = $request->input('id_class_target');
        $id_class = $request->input('id_class');

        if(!empty($id_users) && !empty($id_class_target)){
            $UsersModel = new Users;
            foreach ($id_users as $id_user) {
                $data['id'] = $id_user;
                $data['id_class'] = $id_class_target;

                $UsersModel->edit($data);
            }
        }


        return redirect()->back()->with('messageSuccess', 'Data berhasil diupdate');
    }

    public function top_user(Request $request){
        $type = $request->input('type','pekanan');
        $gender = $request->input('gender','');

        $data['header_top_title'] = $data['header_title'] = 'Top Santri';
        $data['body_class'] = 'body-editprofile';
        $UsersModel = new Users;
        $arrType = array('pekanan'=>7,'bulanan'=>30,'tahunan'=>356);
        $days = '';
        if($type!='seluruhnya'){
            $days = $arrType[$type];
        }
        $data['list'] = $UsersModel->topUser($days,$gender);
        $data['type'] = $type;
        $data['gender'] = $gender;

        return view('profile_top',$data);
    }


}
