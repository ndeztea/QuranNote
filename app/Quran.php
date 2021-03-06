<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
    //

    /**
    * get list page
    *
    */
    public function getPage(){
    	$pages = DB::table('quran')
    			->select('page')
                ->groupBy('page')
                ->get();


        return $pages;
    }

    /**
    * get ayat on the page
    * 
    * @param $page INT
    */
    public function getAyat($page){
    	$ayats = DB::table('quran as qar')
                ->join('surah as s', 's.id', '=', 'qar.surah')
    			->select('qar.surah','qar.surah_name','qar.text_english','qar.text_indo','qar.text_arabic as text','qar.ayat','qar.surah','qar.page','s.ayat as count_ayat','s.type','s.order','qar.juz','qar.juz_header')
                ->where('page',$page);
                //dd($ayats->toSql());

        return $ayats->get();
    }

    /**
    * get range surah for hafalan
    *
    */
    public function getRangeAyat($surah_start,$ayat_start,$surah_end,$ayat_end){
        $ayats = DB::table('quran as qar')
                ->join('surah as s', 's.id', '=', 'qar.surah')
                ->select('qar.surah','qar.surah_name','qar.text_english','qar.text_indo','qar.text_arabic as text','qar.ayat','qar.surah','qar.page','s.ayat as count_ayat','s.type','s.order','qar.juz','qar.juz_header');
        if($surah_start==$surah_end){
            $ayats->where('qar.surah','=',$surah_start)
                    ->where('qar.ayat','>=',$ayat_start)
                    ->where('qar.ayat','<=',$ayat_end);
        }elseif($surah_start!=$surah_end){
            $ayats->where('qar.surah','>=',$surah_start)
                    ->where('qar.ayat','>=',$ayat_start);
                    /*->orWhere(function ($subQuery){
                            global $surah_end,$ayat_end;
                            $subQuery->where('surah','<=',$surah_end)
                                        ->where('ayat','<=',$ayat_end);
                            });*/
        }       

        return $ayats->get();
    }

    public function getAyatSurah($surah,$limit=''){
        $ayats =  DB::table('quran')
                     ->selectRaw('*');
        if(is_array($surah)){
            $ayats->whereIn('surah',$surah)->limit(3)->orderByRaw('RAND()');

        }else{
            $ayats->where('surah',$surah);
        }
        return $ayats->get();
    }

    /**
    * get range surah for hafalan
    *
    */
    public function getOneAyat($id_surah,$ayat){
        $ayats = DB::table('quran as qar')
                ->join('surah as s', 's.id', '=', 'qar.surah')
                ->select('qar.surah','qar.surah_name','qar.text_english','qar.text_indo','qar.text_arabic as text','qar.ayat','qar.surah','qar.page','s.ayat as count_ayat','s.type','s.order','qar.juz','qar.juz_header');
        
        $ayats->where('qar.surah','=',$id_surah)
                ->where('qar.ayat','=',$ayat);

        return $ayats->get();
    }

    /**
    * get surah list
    * 
    */
    public function getSurah($id_surah=0){
        $surah = DB::table('surah')
                ->select('id','name_indonesia as surah_name','type','ayat','muqodimah');

        if($id_surah!=0){
            $surah->where('id','=',$id_surah);
        }
        $surah->groupBy('id')
                ->orderBy('id','asc');
        //dd($surah->toSql());
        return $surah->get();
    }

    /**
    * get list search depend the keyword
    *
    */
    public function searchKeyword($keyword,$surah='',$page=1){
        $skip = $page==1?0:($page - 1) *10;
        
        $ayats = DB::table('quran')->select('surah','surah_name','text_indo','text_arabic','ayat','page')
                ->where('text_indo','LIKE','%'.$keyword.'%');
        if(!empty($surah)){
            $ayats->where('surah','=',$surah);
        }

        $ayats->skip($skip)->take(10);

        return $ayats->get();
    } 

    /**
    * count keyword
    *
    */
    public function countSearchKeyword($keyword,$surah=''){
        $ayats = DB::table('quran')->select('surah','surah_name','text_indo','text_arabic','ayat','page')
                ->where('text_indo','LIKE','%'.$keyword.'%');

        if(!empty($surah)){
            $ayats->where('surah','=',$surah);
        }
        

        return $ayats->count();
    }  

    /**
    * list surah depend the keyword
    *
    */
    public function surahSearchKeyword($keyword){
        $surahs = DB::table('quran')->select('surah','surah_name',DB::raw('count(*) as count'))
                ->where('text_indo','LIKE','%'.$keyword.'%');
        $surahs->orderBy('surah','asc')->groupBy('surah');

        return $surahs->get();
    }  

    /**
    * get surah page
    * 
    */
    public function getSurahPage($surah){
        $page = DB::table('quran')
                ->select('page')
                ->where('surah',$surah)
                ->groupBy('surah')
                ->orderBy('id','asc')
                ->get();


        return $page[0]->page;
    }

    public function getJuz(){
        $juz = DB::table('juz')
                ->select('*')
                ->orderBy('id','asc')
                ->get();


        return $juz;
    }

    public function getJuzPage($juz){
        $juz = DB::table('juz')
                ->select('*')
                ->where('id','=',$juz)
                ->orderBy('id','asc')
                ->get();


        return $juz;
    }

    public function getCurrentJuz($page){
         $juz = DB::table('juz')
                ->select('*')
                ->where('page','>=',$page)
                ->where('page','<',$page)
                ->get();
                //dd($juz->toSql());
        return $juz[0]->id;
    }

    public function getTafsir($surah,$ayat){
        $juz = DB::table('tafsir')
                ->select('tafsir')
                ->where('surah','=',$surah)
                ->where('ayat','=',$ayat)
                ->get();
        return  $juz[0]->tafsir;
    }

    public function getQuranLine($surah_start,$ayat_start,$ayat_end){
        $line = DB::table('quran_line')->select('halaman','baris')
                ->where('id_surah',$surah_start)
                ->groupBy('halaman')
                ->groupBy('baris');
        if($ayat_end==0){
            $line = $line->where('id_ayat',$ayat_start);
        }else{
            $line = $line->where('id_ayat','>=',$ayat_start)
                 ->where('id_ayat','<=',$ayat_end);
        }
        return count($line->get());
    }
}
