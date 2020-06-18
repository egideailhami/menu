<?php


namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Egideailhami\Menu\Models\UsrWeb;

class LoginController extends Controller
{

    public function login(Request $request){
        
            if ($request->namauser == '' || $request->password == '') {
                return response()->json(["errors" => 'Nama user dan password tidak boleh kosong']);
            }

            $check_table = UsrWeb::where('namauser',$request->namauser)->where('status',1)->first();

            if ($check_table == null) {
                return response()->json(["errors" => 'Maaf user tidak terdaftar']);
            }else{
                if (\Auth::attempt(['namauser' => $request->namauser, 'password' => $request->password], $request->remember)) {
                    return response()->json(["link" => route($check_table->tbl_sumber.'.dashboard')]);
                }
                return response()->json(["errors" => 'Nama user atau password yang anda masukan salah']);
            }
    }


}
