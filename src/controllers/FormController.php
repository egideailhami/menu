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
    
    public function getPreview()
    {
        $html = preg_replace("/\r\n|\r|\n/",'',\GritTekno::header(env('menu_app')));
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
                $model = DataMenu::Find(Crypt::decryptstring($request->ref));
                $count=\DB::table('menu')->select(\DB::raw('count(id_parent) as parent_count'))->where('id_parent', $model->id_mnu)->first();
                if ($count->parent_count > 0) {
                    return response()->json(["error" => "Delete failed. Child relationship exists!"]);
                }
                $model->delete();
                return 'success';
            }

            if ($request->isMethod('post')) {
                $model = new DataMenu;
                $model->app = env('menu_app');
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
                $id=Crypt::decryptstring($request->ref);
                $model = DataMenu::where('id_mnu',$id)->first();
                $model->app = env('menu_app');
                $model->app = env('menu_app');
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
}