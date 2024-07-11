<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::middleware(['guest:karyawan,user'])->group(function(){
    Route::get('/', function () {
        return view('auth.loginadmin');
    })->name('login');
    Route::post('/proseslogin',[AuthController::class,'proseslogin']);
    Route::post('/prosesloginadmin',[AuthController::class,'proseslogin']);
});

Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/proseslogout',[AuthController::class,'proseslogout']);
    //Presensi
    Route::get('/presensi/create',[PresensiController::class,'create']);
    Route::post('/presensi/store',[PresensiController::class,'store']);
    //edit profile
    Route::get('/editprofile',[PresensiController::class,'editprofile']);
    Route::post('/presensi/{nik}/updateprofile',[PresensiController::class,'updateprofile']);
    //histori 
    Route::get('/presensi/histori',[PresensiController::class,'histori']);
    //gethistori
    Route::post('/gethistori',[PresensiController::class,'gethistori']);
    //izin
    Route::get('/presensi/izin',[PresensiController::class,'izin']);
    Route::get('/presensi/buatizin',[PresensiController::class,'buatizin']);
    Route::post('/presensi/storeizin',[PresensiController::class,'storeizin']);
    Route::post('/presensi/cekpengajuanizin',[PresensiController::class,'cekpengajuanizin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin',[AuthController::class,'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin',[DashboardController::class, 'dashboardadmin']);

    //karyawan
    Route::get('/karyawan',[KaryawanController::class, 'index']);
    Route::post('/karyawan/store',[KaryawanController::class, 'store']);  
    Route::post('/karyawan/edit',[KaryawanController::class, 'edit']);   
    Route::post('/karyawan/{nik}/update',[KaryawanController::class, 'update']);  
    Route::post('/karyawan/{nik}/delete',[KaryawanController::class, 'delete']); 

    //departemen
    Route::get('/departemen',[DepartemenController::class, 'index']);
    Route::post('/departemen/store',[DepartemenController::class, 'store']);
    Route::post('/departemen/edit',[DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update',[DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete',[DepartemenController::class, 'delete']);

    //monitoring
    Route::get('/panel/monitoring',[PresensiController::class,'monitoring']);
    Route::post('/getpresensi',[PresensiController::class,'getpresensi']);

    //perizinan
    Route::get('/panel/perizinan',[PresensiController::class,'perizinan']);
    Route::post('/panel/approveizin',[PresensiController::class,'approveizin']);
    Route::get('/panel/{id}/batalkan-perizinan',[PresensiController::class,'batalkanizinsakit']);
    Route::post('/panel/{id}/deleteizin',[PresensiController::class,'deleteizin']);

    //laporan
    Route::get('/panel/laporan',[PresensiController::class,'laporan']);
    Route::post('/panel/cetaklaporan',[PresensiController::class,'cetaklaporan']);
    //rekap
    Route::get('/panel/rekap',[PresensiController::class,'rekap']);
    Route::post('/panel/cetakrekap',[PresensiController::class,'cetakrekap']);

    //Konfigurasi set-lokasi
    Route::get('/panel/set-lokasi',[KonfigurasiController::class,'setlokasi']);
    Route::post('/panel/update-lokasi',[KonfigurasiController::class,'updatelokasi']);
});



