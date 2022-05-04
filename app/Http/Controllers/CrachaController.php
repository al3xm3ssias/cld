<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use DB;

class CrachaController extends Controller
{
    public function index(){
        

        $data = \Auth::user()->id;

        $sql = DB::table('academicos')->select('academicos.*')->where('academicos.user_id','=', $data);

        $qrcode =$data;


         return response()->json($data);

       // $data = "1236555";
       /* $pdf = Pdf::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf = Pdf::loadView('cracha.index',compact('qrcode'));


        return $pdf->stream($data.'.pdf');
        */


    }
}
