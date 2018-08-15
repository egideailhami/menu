<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Egideailhami\Menu\Models\Menu as DataMenu;

use Illuminate\Support\Facades\Crypt;

class ModalController extends Controller
{
    public function addmodal($name)
    {
        switch ($name) {
            case 'menu':
                $routeCollection = \Route::getRoutes();
                $route = '';
                foreach ($routeCollection as $value) {
                    if ($value->getName() != null) {
                        // dd(route($value->getName()));
                        $route .= '<option value="'.$value->getName().'">'.$value->getName().'</option>';
                    }
                }
                $option = '';
                foreach (DataMenu::where('id_parent',0)->get() as $key => $value) {
                    $option .='<option value="'.$value->id_mnu.'">'.$value->menu_ut.'</option>';
                }
                $size = 'modal-lg';
                $title = '<i class="fa fa-plus text-primary"></i><span class="text-primary"> Tambah</span> Menu';
                $form = '<div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Display Menu</label>
                                    <input type="text" name="menu_ut" class="form-control " placeholder="Menu Utama" maxlength="50" required="required">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Menu Parent</label>
                                    <select name="id_parent" class="form-control"><option value="0" > - </option>'.$option.'</select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Header
                                    <div class="c-checkbox">
                                    <label>
                                        <input type="checkbox" name="header">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Ya
                                    </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Route Name</label>
                                        <select name="routename" style="width: 100%;" class="form-control"><option value="#" > # </option>'.$route.'</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="email">Icon</label>
                                    <div class="input-group">
                                    <input data-placement="bottomRight" maxlength="25" class="form-control icp icp-auto" name="icon" value="fa-archive"
                                        type="text" readonly />
                                    <span class="input-group-addon"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Urut</label>
                                    <input type="text" name="urut" class="form-control " placeholder="Urut" maxlength="50">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Divider
                                    <div class="c-checkbox">
                                    <label>
                                        <input type="checkbox" name="divider">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Ya
                                    </label>
                                    </div>
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" class="btn btn-default btn-primary pull-right" data-ref="POST"><i class="fa fa-check"></i> Simpan</span></button>';
                return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
                    break;
           
            default:
                # code...
                break;
        }
    }
    public function editmodal($name,$id,Request $request)
    {
        switch ($name) {
            case 'menu':
                    $id_decrypt = explode('&',Crypt::decryptstring($id))[0];
                    $model = DataMenu::where('id_mnu',$id_decrypt)->first();
                    $routeCollection = \Route::getRoutes();
                    $route = '';
                    foreach ($routeCollection as $value) {
                        if ($value->getName() != null) {
                            // dd(route($value->getName()));
                            $route .= '<option value="'.$value->getName().'"  '.($value->getName() == $model->routename ? 'selected':'').'>'.$value->getName().'</option>';
                        }
                    }
                    $option = '';
                    foreach (DataMenu::where('id_parent',0)->get() as $key => $value) {
                        $option .='<option value="'.$value->id_mnu.'" '.($value->id_mnu == $model->id_parent ? 'selected':'').'>'.$value->menu_ut.'</option>';
                    }
                    $size = 'modal-lg';
                    $title = '<i class="fa fa-pencil text-primary"></i><span class="text-primary"> Edit</span> Menu';
                    $form = '<div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Menu Utama</label>
                                        <input type="text" name="menu_ut" class="form-control " placeholder="Menu Utama" value="'.$model->menu_ut.'" maxlength="50" required="required">
                                        <input type="hidden" name="ref" value="'.$id.'" required="required">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Menu Parent</label>
                                        <select name="id_parent" class="form-control"><option value="0" > - </option>'.$option.'</select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Header
                                        <div class="c-checkbox">
                                        <label>
                                            <input type="checkbox" name="header">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Ya
                                        </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Route Name</label>
                                            <select name="routename" style="width: 100%;" class="form-control"><option value="#" > # </option>'.$route.'</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                        <div class="form-group">
                                        <label for="email">Icon</label>
                                        <div class="input-group">
                                        <input data-placement="bottomRight" maxlength="25" class="form-control icp icp-auto" name="icon" value="'.substr($model->icon,3).'"
                                            type="text" readonly />
                                        <span class="input-group-addon"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Urut</label>
                                        <input type="text" name="urut" class="form-control " value="'.$model->urut.'" placeholder="Urut" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Divider
                                        <div class="c-checkbox">
                                        <label>
                                            <input type="checkbox" name="divider">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Ya
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    $footer = '<button type="submit" class="btn btn-default btn-primary pull-right" data-ref="PUT"><i class="fa fa-check"></i> Simpan</span></button>';
                    return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
                    break;
            
            default:
                # code...
                break;
        }
    }
}