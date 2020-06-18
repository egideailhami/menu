<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Egideailhami\Menu\Models\Menu as DataMenu;
use Egideailhami\Menu\Models\AksesUsr as DataRole;
use Egideailhami\Menu\Models\AksesHak as DataPermission;
use Egideailhami\Menu\Models\UsrWeb as DataUser;
use Egideailhami\Menu\Models\AksesDet;
use DB;
use Illuminate\Support\Facades\Crypt;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAppName()
    {
        $option='<option value=""> All </option>';
        foreach (DataMenu::groupBy('app')->select('app')->get() as $key => $value) {
            $option .='<option value="'.$value->app.'">'.$value->app.'</option>';
        
        }
        return response()->json(["data" => $option]);
    }

    public function getRoleMenu()
    {
        $option='';
        foreach (DataRole::where('nama_app',env('nama_app'))->where('usr_akses','!=','superuser')->get() as $key => $value) {
            $option .='<option value="'.Crypt::encryptString($value->id_uaks).'">'.$value->ket_akses.'</option>';
        
        }
        return response()->json(["data" => $option]);
    }
    
    public function postRoleMenu(Request $request)
    {   
        $id_mnu = Crypt::decryptString($request->ref);
        $id_uaks = Crypt::decryptString($request->role);
        $cek = AksesDet::where('id_mnu',$id_mnu)->where('id_uaks',$id_uaks)->withTrashed()->first();
        if($cek == NULL){
            $AksesDet = new AksesDet;
            $AksesDet->id_uaks = $id_uaks;
            $AksesDet->id_mnu = $id_mnu;
            $AksesDet->id_akk = 0;
            $AksesDet->rec_usr = Auth::user()->id_usr;
            $AksesDet->save();
        }else{
            if ($cek->deleted_at == NULL) {
                $cek->delete();

            }else {
                $cek->deleted_at=NULL;
                $cek->save();   
            }
            
        }
        return 'Success';
    }

    public function getNamaUser(Request $request)
    {
        $tabel_sumber = explode(',',env('tabel_sumber'))[$request->key];
        $kolom_nama = explode(',',env('kolom_nama'))[$request->key];
        $kolom_id = explode(',',env('kolom_id'))[$request->key];
    
        $option='<option value="" disabled selected>Nama Lengkap </option>';
        foreach (DB::table($tabel_sumber)->get() as $key => $value) {
            $option .='<option value="'.Crypt::encryptString($value->$kolom_id).'">'.$value->$kolom_nama.'</option>';
        
        }
        return response()->json(["data" => $option]);
    }
    
    public function getPreview()
    {
        $html = preg_replace("/\r\n|\r|\n/",'',\GritTekno::header(env('nama_app')));
        return response()->json(["data" => $html]);
    }
    
    public function userAktif(Request $request)
    {
        $model = DataUser::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
        $model->status = !$model->status;
        $model->save();
        return 'Success';
    }
    
    public function user($id = null, Request $request)
    {

        try {
            
            if ($request->isMethod('get')) {
                $model = DataUser::find($id);

                return compact('model');
            }

            if ($request->isMethod('delete')) {
                $model = DataUser::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
                $count=\DB::table('menu')->select(\DB::raw('count(id_parent) as parent_count'))->where('id_parent', $model->id_mnu)->first();
                if ($count->parent_count > 0) {
                    return response()->json(["error" => "Delete failed. Child relationship exists!"]);
                }
                $model->delete();
                return 'success';
            }

            if ($request->isMethod('post')) {
                $cek = DataUser::where('nama_app',env('nama_app'))->where('namauser',$request->namauser)->first();
                if ($cek != null) {
                    return response()->json(["message"=> "The given data was invalid.","errors" => ['namauser' => ["Nama User sudah terdaftar"]]],422);
                }
                $tabel_sumber = explode(',',env('tabel_sumber'))[$request->tabel_sumber];
                $kolom_nama = explode(',',env('kolom_nama'))[$request->tabel_sumber];
                $kolom_id = explode(',',env('kolom_id'))[$request->tabel_sumber];
                $cek = DB::table($tabel_sumber)->where($kolom_id,Crypt::decryptString($request->nama_lkp))->first();
                $model = new DataUser;
                $model->namauser = $request->namauser;
                $model->status = 1;
                $model->nama_app = env('nama_app');
                $model->password = bcrypt(env('password'));
                $model->tbl_sumber = $tabel_sumber;
                $model->key_relasi = $cek->$kolom_id;
                $model->nama_lkp = $cek->$kolom_nama;
                $model->id_uaks = $request->role;
                $model->email_usr = $cek->email;
                $model->save();
                return 'Success';
            }

            if ($request->isMethod('put')) {
                $id=explode('&',Crypt::decryptstring($request->ref))[0];
                $cek = DataUser::where('nama_app',env('nama_app'))->where('namauser',$request->namauser)->first();
                if ($cek != null && $cek->id_usr != $id) {
                    return response()->json(["message"=> "The given data was invalid.","errors" => ['namauser' => ["Nama User sudah terdaftar"]]],422);
                }
                $tabel_sumber = explode(',',env('tabel_sumber'))[$request->tabel_sumber];
                $kolom_nama = explode(',',env('kolom_nama'))[$request->tabel_sumber];
                $kolom_id = explode(',',env('kolom_id'))[$request->tabel_sumber];
                $cek = DB::table($tabel_sumber)->where($kolom_id,Crypt::decryptString($request->nama_lkp))->first();
                $model = DataUser::where('id_usr',$id)->first();
                $model->namauser = $request->namauser;
                $model->status = 1;
                $model->nama_app = env('nama_app');
                $model->password = bcrypt(env('password'));
                $model->tbl_sumber = $tabel_sumber;
                $model->key_relasi = $cek->$kolom_id;
                $model->nama_lkp = $cek->$kolom_nama;
                $model->id_uaks = $request->role;
                $model->email_usr = $cek->email;
                $model->save();
                return 'Success';
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function menu($id = null, Request $request)
    {
        try {
            
            // if ($request->isMethod('get')) {
            //     $model = DataMenu::find($id);

            //     return compact('model');
            // }

            if ($request->isMethod('delete')) {
                $model = DataMenu::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
                $count=\DB::table('menu')->select(\DB::raw('count(id_parent) as parent_count'))->where('id_parent', $model->id_mnu)->first();
                if ($count->parent_count > 0) {
                    return response()->json(["error" => "Delete failed. Child relationship exists!"]);
                }
                $model->delete();
                return 'success';
            }

            if ($request->isMethod('post')) {
                $model = new DataMenu;
                $model->app = env('nama_app');
                $model->menu_ut = $request->menu_ut;
                $model->id_parent = $request->id_parent ;
                $model->divider = $request->divider ? 1 : 0 ;
                $model->header = $request->header ? 1 : 0 ;
                $model->icon = 'fa '.$request->icon;
                $model->routename = $request->routename;
                $model->url = $request->routename == '#' ? '#':\URL::route($request->routename, array(), false);
                $model->urut = $request->urut ? $request->urut : 100;
                $model->save();
                return 'Success';
            }

            if ($request->isMethod('put')) {
                $id=explode('&',Crypt::decryptstring($request->ref))[0];
                $model = DataMenu::where('id_mnu',$id)->first();
                $model->app = env('nama_app');
                $model->menu_ut = $request->menu_ut;
                $model->id_parent = $request->id_parent ;
                $model->divider = $request->divider ? 1 : 0 ;
                $model->header = $request->header ? 1 : 0 ;
                $model->icon = 'fa '.$request->icon;
                $model->routename = $request->routename;
                $model->url = $request->routename == '#' ? '#':\URL::route($request->routename, array(), false);
                $model->urut = $request->urut ? $request->urut : 100;
                $model->save();
                return 'Success';
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function rolePermission($id = null, Request $request)
    {
        try {
            
            if ($request->isMethod('delete')) {
                switch ($request->type) {
                    case 'role':
                        $model = DataRole::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
                    break;
                    case 'permission':
                        $model = DataPermission::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
                    break;
                }
                $count=\DB::table('menu')->select(\DB::raw('count(id_parent) as parent_count'))->where('id_parent', $model->id_mnu)->first();
                if ($count->parent_count > 0) {
                    return response()->json(["error" => "Delete failed. Child relationship exists!"]);
                }
                $model->delete();
                return 'success';
            }

            if ($request->isMethod('post')) {
                switch ($request->type) {
                    case 'role':
                        $model = new DataRole;
                        $model->nama_app = env('nama_app');
                        $model->usr_akses = $request->usr_akses;
                        $model->ket_akses = $request->ket_akses;    
                    break;
                    case 'permission':
                        $model = new DataPermission;
                        $model->jns_hak = $request->jns_hak;
                        $model->ket_hak = $request->ket_hak;    
                    break;
                }
                    $model->save();
                    return 'Success';
            }

            if ($request->isMethod('put')) {
                switch ($request->type) {
                    case 'role':
                        $model = DataRole::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
                        $model->usr_akses = $request->usr_akses;
                        $model->ket_akses = $request->ket_akses;  
                    break;
                    case 'permission':
                        $model = DataPermission::Find(explode('&',Crypt::decryptstring($request->ref))[0]);
                        $model->jns_hak = $request->jns_hak;
                        $model->ket_hak = $request->ket_hak;    
                    break;
                }
                $model->save();
                return 'Success';
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}