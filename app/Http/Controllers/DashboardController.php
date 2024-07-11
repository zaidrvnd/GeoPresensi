<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m")*1; // 1 atau Januari
        $tahunini = date("Y"); // 2024
        $nik = Auth::guard('karyawan')->user()->nik;
        //mengambil data presensi dari nik , tanggal hari ini
        $presensihariini = DB::table('presensi')->where('nik',$nik)->where('tgl_presensi',$hariini)->first();
        //menampilkan histori presensi bulan ini
        $historibulanini = DB::table('presensi')
            ->where('nik',$nik)
            ->whereRaw('MONTH(tgl_presensi)="'.$bulanini. '"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
            ->orderBy('tgl_presensi')
            ->get();

        //membuat rekap presensi
        // menghitung presensi pada bulan berjalan berdasarkan nik
        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanini. '"') 
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->first();

        //membuat rekap presensi
        // menghitung presensi pada bulan berjalan berdasarkan nik
        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status = "s",1,0)) as jmlsakit, SUM(IF(status = "i",1,0)) as jmlizin')
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_izin)="'.$bulanini. '"') 
        ->whereRaw('YEAR(tgl_izin)="'.$tahunini.'"')
        ->where('status_approved',1)
        ->first();

        //membuat fungsi leaderboard
        $leaderboard = DB::table('presensi')
        ->join('karyawan','presensi.nik','karyawan.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();

        //menampilkan tahun dan nama bulan ke dashboard
        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view('dashboard.dashboard', compact('presensihariini','historibulanini','namabulan','bulanini','tahunini'
        ,'rekappresensi','leaderboard','rekapizin'));
    }
    public function dashboardadmin(){
        //membuat rekap presensi
        // menghitung presensi pada bulan berjalan berdasarkan nik
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('tgl_presensi',$hariini)
        ->first();

        //membuat rekap presensi
        // menghitung presensi pada bulan berjalan berdasarkan nik
        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status = "s",1,0)) as jmlsakit, SUM(IF(status = "i",1,0)) as jmlizin')
        ->where('tgl_izin',$hariini)
        ->where('status_approved',1)
        ->first();

        return view('dashboard.dashboardadmin',compact('rekappresensi','rekapizin'));
    }
}
