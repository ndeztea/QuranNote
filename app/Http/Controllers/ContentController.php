<?php

namespace App\Http\Controllers;

use DB;
use App\Notes;
use App\Users;
use App\Quran;
use App\Content;
use App\Subscriptions;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Hubungi Kami';
        $dataHTML['modal_body'] = view('content_contact')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function subscription()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Daftar Santri Aktif';
        $dataHTML['modal_body'] = view('subscription_info')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function about()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Tentang QuranMemo';
        $dataHTML['modal_body'] = view('content_about')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function donasi()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Donasi, Infaq dan Sedekah';
        $dataHTML['modal_body'] = view('content_donasi')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function umroh()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Program Umroh';
        $dataHTML['modal_body'] = view('content_umroh')->render();
        $dataHTML['modal_footer'] = '<a href="https://api.whatsapp.com/send?phone=6285956331813&text=Assalamu\'alaikum%20wr%20wb,%20mau%20tanya%20perihal%20umroh" class="btn btn-green-small" style="font-size: 16px;margin-top: 10px;" target="_blank" onclick="fbq(\'track\', \'clickTanyaUmroh\');">Tanya via WA
    085956331813</a> ';

        return response()->json($dataHTML);
    }

    public function partners()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Partners';
        $dataHTML['modal_body'] = view('content_partners')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function promo()
    {
        /*$SubscriptionsModel = new Subscriptions();
        $sessRole = session('sess_role');
        $counter = $SubscriptionsModel->getPendingSubscriptions(session('sess_id'));

        $data['havePending'] = count($counter)>=1?true:false;*/

        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'News';
        $dataHTML['modal_body'] = view('content_promo')->render();
        $dataHTML['modal_footer'] = '<a href="https://api.whatsapp.com/send?phone=6285956331813" class="btn btn-green-small"  target="_blank" onclick="fbq(\'track\', \'clickContactTShirtWomb\');">Contact via WA
    085956331813</a> ';
        return response()->json($dataHTML);
    }

    public function alkahfi()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Baca Al-Kahfi';
        $dataHTML['modal_body'] = view('content_alkahfi')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function faq()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Tanya Jawab';
        $dataHTML['modal_body'] = view('content_faq')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function buku(Request $request)
    {
        $email = $request->input('email');
        $clientId = $request->input('clientId');
        if(!empty($email)){
            mail('quranmemo.id@gmail.com, ndeztea@gmail.com', 'Email buku', $email.' - '.$clientId);

            return redirect('mushaf/page/1')->with('messageSuccess', 'Terima kasih, kami akan memproses email antum :)');
        }

        $dataHTML['modal_class'] = '';
        //$dataHTML['modal_title'] = 'Berbagi Buku';
        $dataHTML['modal_title'] = 'Program Buku';
        $dataHTML['modal_body'] = view('content_buku')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function info()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Info';
        $dataHTML['modal_body'] = view('content_info')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';
        return response()->json($dataHTML);
    }

    public function info_memoz()
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Info';
        $dataHTML['modal_body'] = view('content_info_memoz')->render();
        $dataHTML['modal_footer'] = '<span class="cont_hide_memoz_info"> <input type="checkbox" name="hide_memoz_info" onclick="hideInfo()" value="1"> Jangan tampilkan lagi <br></span><button  data-dismiss="modal" class="btn btn-green-small info">Bismillah mulai menghafal</button></div>';
        return response()->json($dataHTML);
    }

    public function muratal(Request $request)
    {
        $dataHTML['modal_class'] = '';
        $dataHTML['modal_title'] = 'Fitur Muratal';
        $dataHTML['modal_body'] = view('content_muratal')->render();
        $dataHTML['modal_footer'] = '<button class="btn btn-green-small" data-dismiss="modal">Tutup</button>';

        return response()->json($dataHTML);
    }

    public function learning(){
        $data['header_top_title'] = $data['header_title'] = 'Konten';

        $Users = new Users;
        $level = $Users->checkLevel(session('sess_id'));

        $contentModel = new Content;
        $listFolder = $contentModel->getAssetsContent();
        $data['listFolder'] = $listFolder;
        $data['level'] = $level;
        return view('content_learning',$data);
    }

    public function file_learning($folder){
        $data['header_top_title'] = $data['header_title'] = ucfirst($folder);

        $Users = new Users;
        $level = $Users->checkLevel(session('sess_id'));

        $contentModel = new Content;
        $detail  = $contentModel->getAssetDetail($folder);
        if($level<$detail->level){
            return redirect('learning')->with('messageError', 'Tidak mempunyai akses')->withInput();
        }

        $directory = public_path('learning/'.$folder);
        $listFiles = File::allFiles($directory);

        $data['listFiles'] = $listFiles;
        $data['detail'] = $detail;
        $data['folder'] = $folder;
        return view('content_learning_file',$data);
    }
}
