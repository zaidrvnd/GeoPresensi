<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\warning;

class AuthController extends Controller
{
    public function proseslogin(Request $request){
        if(Auth::guard('karyawan')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/dashboard');
        }elseif(Auth::guard('user')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/panel/dashboardadmin');
        }else{
            return redirect('/')->with(['warning'=>'Email atau Password salah!']);
        }
    }
    public function proseslogout(){
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }
        public function proseslogoutadmin(){
            if(Auth::guard('user')->check()){
                Auth::guard('user')->logout();
                return redirect('/');
            }    
    }
}
