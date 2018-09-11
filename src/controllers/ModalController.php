<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Egideailhami\Menu\Models\Menu as DataMenu;
use Egideailhami\Menu\Models\AksesUsr as DataRole;
use Egideailhami\Menu\Models\AksesHak as DataPermission;

use Illuminate\Support\Facades\Crypt;

class ModalController extends Controller
{
    public function addmodal($name)
    {
        switch ($name) {
            case 'user':
                $size = 'modal-md';
                $option='';
                $option2='';
                // dd(explode(',',env('tabel_sumber')));
                foreach (explode(',',env('tabel_sumber')) as $key => $value) {
                    $option .='<option value="'.$key.'">'.$value.'</option>';
                }
                foreach (DataRole::where('nama_app',env('nama_app'))->where('usr_akses','!=','superuser')->get() as $key => $value) {
                    $option2 .='<option value="'.$value->id_uaks.'">'.$value->usr_akses.'</option>';
                }
                $title = '<i class="fa fa-plus text-primary"></i><span class="text-primary"> Tambah</span> User ';
                $form = '<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe User</label>
                                    <select name="tabel_sumber" id="tabel_sumber" class="form-control" required="required"><option value="" disabled selected>Tipe User</option>'.$option.'</select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" id="role" style="width: 100%;" class="form-control" required="required"><option value="" disabled selected>Pilih Role</option>'.$option2.'</select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama User</label>
                                    <input type="text" name="namauser" class="form-control " placeholder="Nama User" maxlength="50" required="required">
                                    <span class="help-block has-error namauser_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <select name="nama_lkp" id="nama_lkp" style="width: 100%;" class="form-control" required="required">'.$option2.'</select>
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="POST" data-type="user"><i class="fa fa-check"></i> Simpan</span></button>';
                return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
            break;
            case 'role':
                $size = 'modal-sm';
                $title = '<i class="fa fa-plus text-primary"></i><span class="text-primary"> Tambah</span> Peran User (Role)';
                $form = '<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Peran (Role)</label>
                                    <input type="text" name="usr_akses" class="form-control " placeholder="Nama Peran (Role)" maxlength="50" required="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan Peran (Role)</label>
                                    <input type="text" name="ket_akses" class="form-control " placeholder="Keterangan Peran (Role)" maxlength="50" required="required">
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="POST" data-type="role"><i class="fa fa-check"></i> Simpan</span></button>';
                return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
            break;
            case 'permission':
                $size = 'modal-sm';
                $title = '<i class="fa fa-plus text-primary"></i><span class="text-primary"> Tambah</span> Ijin User';
                $form = '<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Ijin (Permission)</label>
                                    <input type="text" name="jns_hak" class="form-control " placeholder="Nama Ijin (Permission)" maxlength="50" required="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan Ijin (Permission)</label>
                                    <input type="text" name="ket_hak" class="form-control " placeholder="Keterangan Ijin (Permission)" maxlength="50" required="required">
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="POST" data-type="permission"><i class="fa fa-check"></i> Simpan</span></button>';
                return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
            break;
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
                                    <input type="text" name="menu_ut" class="form-control " placeholder="Display Menu" maxlength="50" required="required">
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
                                    <div class="c-checkbox" style="margin-top:10px">
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
                                    <label>Sort</label>
                                    <input type="text" name="urut" class="form-control " placeholder="Sort" maxlength="50">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Divider
                                    <div class="c-checkbox" style="margin-top:10px">
                                    <label>
                                        <input type="checkbox" name="divider">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Ya
                                    </label>
                                    </div>
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="POST"><i class="fa fa-check"></i> Simpan</span></button>';
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
            case 'role':
                $model = DataRole::find(explode('&',Crypt::decryptstring($id))[0]);
                $size = 'modal-sm';
                $title = '<i class="fa fa-plus text-primary"></i><span class="text-primary"> Edit</span> Peran User (Role)';
                $form = '<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Peran (Role)</label>
                                    <input type="hidden" name="ref" value="'.$id.'" required="required">
                                    <input type="text" name="usr_akses" class="form-control " placeholder="Nama Peran (Role)" value="'.$model->usr_akses.'" maxlength="50" required="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan Peran (Role)</label>
                                    <input type="text" name="ket_akses" class="form-control " placeholder="Keterangan Peran (Role)" value="'.$model->ket_akses.'" maxlength="50" required="required">
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="PUT" data-type="role"><i class="fa fa-check"></i> Simpan</span></button>';
                return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
            break;
            case 'permission':
                $model = DataPermission::find(explode('&',Crypt::decryptstring($id))[0]);
                $size = 'modal-sm';
                $title = '<i class="fa fa-plus text-primary"></i><span class="text-primary"> Edit</span> Ijin User';
                $form = '<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Ijin (Permission)</label>
                                    <input type="hidden" name="ref" value="'.$id.'" required="required">
                                    <input type="text" name="jns_hak" class="form-control " placeholder="Nama Ijin (Permission)" value="'.$model->jns_hak.'"  maxlength="50" required="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan Ijin (Permission)</label>
                                    <input type="text" name="ket_hak" class="form-control " placeholder="Keterangan Ijin (Permission)" value="'.$model->ket_hak.'" maxlength="50" required="required">
                                </div>
                            </div>
                        </div>';
                $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="PUT" data-type="permission"><i class="fa fa-check"></i> Simpan</span></button>';
                return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
            break;
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
                                        <input type="text" name="menu_ut" class="form-control " placeholder="Display Menu" value="'.$model->menu_ut.'" maxlength="50" required="required">
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
                                        <div class="c-checkbox" style="margin-top:10px">
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
                                        <label>Sort</label>
                                        <input type="text" name="urut" class="form-control " value="'.$model->urut.'" placeholder="Sort" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Divider
                                        <div class="c-checkbox" style="margin-top:10px">
                                        <label>
                                            <input type="checkbox" name="divider">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Ya
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    $footer = '<button type="submit" id="btn-submit" class="btn btn-default btn-primary pull-right" data-ref="PUT"><i class="fa fa-check"></i> Simpan</span></button>';
                    return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
                    break;
            
            default:
                # code...
                break;
        }
    }
}