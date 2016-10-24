<?php

namespace App\Http\Controllers;

use DB;
use App\Notes;
use App\Quran;
use App\Memo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Crypt;
use File;

class MemozController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($surah_start='',$ayat_range='',$id='')
    {   

        $messageErrors = $ayats = '';
        // get data hafalan
        $QuranModel = new Quran;
        $ayat_start = '';
        $ayat_end = '';
        if(strpos($ayat_range,'-')!==false){
            $ayatArr = explode('-', $ayat_range);
            $ayats = $QuranModel->getRangeAyat($surah_start,$ayatArr[0],$surah_start,$ayatArr[1]);
            $ayat_start = $ayatArr[0];
            $ayat_end = $ayatArr[1];
        }else{
            $ayats = $QuranModel->getOneAyat($surah_start,$ayat_range);
            $ayat_start = $ayat_range;
        }

        // get surah
        $surahs = $QuranModel->getSurah();

        // data header
        $data['header_title'] = 'Menghafal';
        $data['body_class'] = 'body-memo';
        $data['on_memo'] = true;

        // data header
        if(!empty($ayats)){
            $data['header_title'] = 'Menghafal Surah '. $ayats[0]->surah_name.' : '.$ayat_range;
            $data['header_description'] = 'Menghafal Surah '. $ayats[0]->surah_name.' : '.$ayat_range.' '.$ayats[0]->text_indo;
        }

        if($id){
            // get detail memo
        }
        

        //$data['fill_ayat_end'] = $fill_ayat_end;
        $data['ayats'] = $ayats;
        $data['id'] = $id;
        $data['surahs'] = $surahs;
        $data['surah_start'] = $surah_start;
        $data['ayat_start'] = $ayat_start;
        $data['ayat_range'] = $ayat_range;
        //$data['surah_end'] = $surah_end;
        $data['ayat_end'] = $ayat_end;
        $data['curr_page'] = 0;

        return view('memoz',$data);
    }


    public function search(Request $request){
        $surah_start = $request->input('surah_start');
        $ayat_start = $request->input('ayat_start');
        $ayat_end = $request->input('ayat_end');
        $fill_ayat_end = $request->input('fill_ayat_end');

        $QuranModel = new Quran;
        $surah_detail = $QuranModel->getSurah($surah_start);
        // ayat checking
        if(isset($ayat_start) || isset($ayat_end)){
            if($surah_detail[0]->ayat < $ayat_start){
                return redirect('memoz')->with('messageError', 'Surah '.$surah_detail[0]->surah_name.' ada '.$surah_detail[0]->ayat.' ayat, ayat '.$ayat_start.' tidak ada!');
            }elseif($surah_detail[0]->ayat < $ayat_end){
                return redirect('memoz')->with('messageError', 'Surah '.$surah_detail[0]->surah_name.' ada '.$surah_detail[0]->ayat.' ayat, ayat '.$ayat_end.' tidak ada!');
            }
        }

        if($surah_start && !empty($ayat_start) && !empty($ayat_end)){
            setcookie('coo_last_memoz',url('memoz/surah/'.$surah_start.'/'.$ayat_start.'-'.$ayat_end));
            return redirect('memoz/surah/'.$surah_start.'/'.$ayat_start.'-'.$ayat_end);
        }elseif($surah_start && !empty($ayat_start)){
            setcookie('coo_last_memoz',url('memoz/surah/'.$surah_start.'/'.$ayat_start.'-'.$ayat_end));
            return redirect('memoz/surah/'.$surah_start.'/'.$ayat_start);
        }else{
            return redirect('memoz');
        }
    }

    public function config(){
        $repeat = $_GET['repeat'];
        $muratal = $_GET['muratal'];

        $data['arr_muratal_list'] = \Config::get('custom.muratal_list');
        $data['muratal'] = $muratal;
        $data['repeat'] = $repeat;


        $dataHTML['modal_title'] = 'Setting Memoz';
        $dataHTML['modal_body'] = view('memoz_config',$data)->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small info" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

     public function list(Request $request){
        $MemoModel = new Memo();

        $data['list']  = $MemoModel->getList($request->session()->get('sess_id'));
        $dataHTML['modal_title'] = 'Daftar Hafalan';
        $dataHTML['modal_body'] = view('memoz_list',$data)->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small info" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    /**
    * to show memoz form on modal
    *
    */
    public function form(Request $request){
        $data['surah_start'] = $request->input('surah_start');
        $data['ayat_start'] = $request->input('ayat_start');
        $data['ayat_end'] = $request->input('ayat_end');

        $QuranModel = new Quran;
        $surahs = $QuranModel->getSurah();
        $data['surahs'] = $surahs;
        $data['date_start'] = '';
        $data['date_end'] = '';
        $data['note'] = '';

        $id = $request->input('id');
        $data['id'] = $id;
        if(!empty($id)){
            $MemoModel = new Memo();
            $memoDetail = $MemoModel->getDetail($id);
            $data['surah_start'] = $memoDetail->surah_start;
            $data['ayat_start'] = $memoDetail->ayat_start;
            $data['ayat_end'] = $memoDetail->ayat_end;
            $data['date_start'] = $memoDetail->date_start;
            $data['date_end'] = $memoDetail->date_end;
            $data['note'] = $memoDetail->note;
        }

        $dataHTML['modal_title'] = 'Simpan Hafalan';
        $dataHTML['modal_body'] = view('memoz_form',$data)->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small info" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    /**
    * save memoz
    *
    */
    public function save(Request $request){
        $dataRecord['id'] = $request->input('id');
        $dataRecord['surah_start'] = $request->input('surah_start');
        $dataRecord['ayat_start'] = $request->input('ayat_start');
        $dataRecord['ayat_end'] = $request->input('ayat_end');
        $dataRecord['date_start'] = $request->input('date_start');
        $dataRecord['date_end'] = $request->input('date_end');
        $dataRecord['note'] = $request->input('note');
        $dataRecord['id_user'] = $request->session()->get('sess_id');

        // saving to DB
        $Memo = new Memo;
        if(empty($dataRecord['id'])){
            $save = $Memo->store($dataRecord);
        }else{
            $save = $Memo->edit($dataRecord);
        }

        // check the process and send as json
        if($save){
            $dataHTML['id'] = $save;
            $dataHTML['status'] = true;
            $dataHTML['message'] = 'Hafalan berhasil disimpan';
        }else{
            $dataHTML['id'] = '';
            $dataHTML['status'] = false;
            $dataHTML['message'] = 'Hafalan gagal disimpan';
        }

        return response()->json($dataHTML);
    }

    public function remove(Request $request){
        $id = $request->input('id');
         $MemoModel = new Memo();
        $memoDetail = $MemoModel->getDetail($id);

       
        $dataHTML['message'] = 'Hafalan gagal dihapus';
        $dataHTML['status'] = false;
        if($memoDetail->id_user == $request->session()->get('sess_id')){
            if($MemoModel->remove($id)){
                $dataHTML['message'] = 'Hafalan berhasil dihapus';
                $dataHTML['status'] = true;
                $dataHTML['id'] = $id;
            }
        }
        return response()->json($dataHTML);
    }

    public function uploadRecorded(Request $request){
        $audio = $request->input('audioBase64');
        $id = $request->input('id');
        $MemoModel = new Memo();

        $audio = str_replace('data:audio/wav;base64,', '', $audio);
        $decoded = base64_decode($audio);
        $fileName = 'rec_'.$request->session()->get('sess_id').'_'.$id.'.wav';
        $fileName = "recorded/".$fileName;
        $fileName = public_path($fileName);
        $dataHTML['status'] = false;
        $dataHTML['message'] = 'Hasil rekaman gagal di upload.';
        if(file_put_contents($fileName, $decoded)){
            $dataRecord['id'] = $id;
            $dataRecord['record'] = $fileName;
            $save = $MemoModel->edit($dataRecord);
            if($save){
                $dataHTML['status'] = true;
                $dataHTML['message'] = 'Hasil rekaman berhasil di upload';
                // remove the old file
                $memoDetail = $MemoModel->getDetail($id);
                File::delete(public_path($memoDetail->record));
            }

        }
        return response()->json($dataHTML);
    }   
    
}
