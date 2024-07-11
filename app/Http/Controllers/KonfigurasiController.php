<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
   public function setlokasi(){
    $lok_kantor = DB::table('set_lokasi')->where('id',1)->first();
    return view('konfigurasi.set-lokasi',compact('lok_kantor'));
   }

   public function updatelokasi(Request $request){
    $lokasi_kantor = $request->lokasi_kantor;
    $radius = $request->radius;
    if (empty($lokasi_kantor)) {
        return Redirect::back()->with(['warning' => 'Lokasi Kantor tidak boleh kosong!']);
      }
    $data = [
        'lokasi_kantor' => $lokasi_kantor,
        'radius' => $radius
    ];

    $update = DB::table('set_lokasi')->where('id',1)->update($data);

    if($update){
        return Redirect::back()->with(['success'=> 'Data Berhasil Di Update']);
    }else{
        return Redirect::back()->with(['warning'=> 'Data Gagal Di Update']);
    }

   }
}
