<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Egideailhami\Menu\Models\Menu as DataMenu;
use Egideailhami\Menu\Models\AksesUsr as DataRole;
use Egideailhami\Menu\Models\AksesHak as DataPermission;

use Illuminate\Support\Facades\Crypt;

class FormController extends Controller
{
    public function getAppName()
    {
        $option='<option value=""> All </option>';
        foreach (DataMenu::groupBy('app')->select('app')->get() as $key => $value) {
            $option .='<option value="'.$value->app.'">'.$value->app.'</option>';
        
        }
        return response()->json(["data" => $option]);
    }
    
    public function getPreview()
    {
        $html = preg_replace("/\r\n|\r|\n/",'',\GritTekno::header(env('nama_app')));
        return response()->json(["data" => $html]);
    }
    
    public function menu($id = null, Request $request)
    {
        try {
            
            if ($request->isMethod('get')) {
                $model = DataMenu::find($id);

                return compact('model');
            }

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