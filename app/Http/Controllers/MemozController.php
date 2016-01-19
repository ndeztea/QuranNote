<?php

namespace App\Http\Controllers;

use DB;
use App\Notes;
use App\Quran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;

class MemozController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get data hafalan
        $surah_start = $request->input('surah_start');
        $ayat_start = $request->input('ayat_start');
        $surah_end = $request->input('surah_end');
        $ayat_end = $request->input('ayat_end');

        // validation
        $errorMessages = [
            'surah_start.required' => 'Surah awal harus di isi',
            'surah_end.required' => 'Surah akhir harus di isi',
            'ayat_start.numeric'   => 'Ayat pada surah awal harus berupa angka',
            'ayat_end.numeric'   => 'Ayat pada surah awal harus berupa angka'
        ];

        $validator = Validator::make($request->all(), [
            'surah_start' => 'required',
            'ayat_start' => 'required|numeric',
            'surah_end' => 'required',
            'ayat_end' => 'required|numeric'
        ],$errorMessages);

        if($validator->fails()){
            $messageErrors = $validator->errors();
        }
        // end validation


         // get surah
        $QuranModel = new Quran;
        $surahs = $QuranModel->getSurah();

        $data['surahs'] = $surahs;
        $data['surah_start'] = $surah_start;
        $data['ayat_start'] = $ayat_start;
        $data['surah_end'] = $surah_end;
        $data['ayat_end'] = $ayat_end;
        $data['messageErrors'] = $messageErrors;

        return view('memoz',$data);
    }

    public function create(){
        // get surah
        $QuranModel = new Quran;
        $surahs = $QuranModel->getSurah();

        $NotesModel = new Notes;


        // send to view 
        $data['surahs'] = $surahs;
        $data['notesDetail'] = $NotesModel->get();

        return view('notes_form',$data);
    }


    
}
