<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Egideailhami\Menu\Models\Menu as DataMenu;

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
    public function menu($id = null, Request $request)
    {
        try {
            
            if ($request->isMethod('get')) {
                $model = DataMenu::find($id);

                return compact('model');
            }

            if ($request->isMethod('delete')) {
                $model = DataMenu::Find($request->id);
                $model->name = $model->name.'_'.$request->id;
                $model->save();
                $model->delete();
                return 'success';
            }

            if ($request->isMethod('post')) {
                $cek = DataMenu::where('menu_ut',$request->menu_ut)->first();
                if ($cek != NULL) {
                    if ($cek->deleted_at != null) {
                        $cek->deleted_at = NULL;
                        $cek->save(); 
                        return 'Success';   
                    }else {
                        return response()->json(["error" => "Menu utama sudah terdaftar."]);
                    }
                } else {
                    $model = new DataMenu;
                    $model->app = env('menu_app');
                    $model->menu_ut = $request->menu_ut;
                    $model->id_parent = $request->id_parent ;
                    $model->divider = $request->divider ? 1 : 0 ;
                    $model->header = $request->header ? 1 : 0 ;
                    $model->icon = 'fa '.$request->icon;
                    $model->routename = $request->routename;
                    $model->url = $request->routename == '#' ? '#':route($request->routename);
                    $model->urut = $request->urut ? $request->urut : 100;
                    $model->save();
                    return 'Success';
                }
            }

            if ($request->isMethod('put')) {
                $id=Crypt::decryptstring($request->ref);
                $model = DataMenu::where('id_mnu',$id)->first();
                if ($model->menu_ut != $request->menu_ut) {
                    $cek = DataMenu::where('menu_ut',$request->menu_ut)->first();
                    if ($cek != NULL) {
                        return response()->json(["error" => "Menu utama sudah terdaftar."]);
                    }
                }
                $model->app = env('menu_app');
                $model->app = env('menu_app');
                $model->menu_ut = $request->menu_ut;
                $model->id_parent = $request->id_parent ;
                $model->divider = $request->divider ? 1 : 0 ;
                $model->header = $request->header ? 1 : 0 ;
                $model->icon = 'fa '.$request->icon;
                $model->routename = $request->routename;
                $model->url = $request->routename == '#' ? '#':route($request->routename);
                $model->urut = $request->urut ? $request->urut : 100;
                $model->save();
                return 'Success';
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}