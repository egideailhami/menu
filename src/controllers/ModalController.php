<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Egideailhami\Menu\Models\Menu as DataMenu;

use Illuminate\Support\Facades\Crypt;

class ModalController extends Controller
{
    public function modal($name,$type, $id = null, Request $request)
    {
        switch ($name) {
            case 'menu':
                switch ($type) {
                    case 'add':
                    $option = '';
                    foreach (DataMenu::where('id_parent',0)->get() as $key => $value) {
                        $option .='<option value="'.$value->id_mnu.'">'.$value->menu_ut.'</option>';
                    }
                    $size = 'modal-md';
                    $title = '<i class="fa fa-plus orange"></i><span class="orange"> Tambah</span> Menu';
                    $form = '<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Menu Utama</label>
                                        <input type="text" name="menu_ut" class="form-control " placeholder="Menu Utama" maxlength="50" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Menu Parent</label>
                                        <select name="id_parent" class="form-control"><option value="" disabled selected>Menu Parent</option>'.$option.'</select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Menu Utama</label>
                                        <input type="text" name="menu_ut" class="form-control " placeholder="Menu Utama" maxlength="50" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="email">Ikon :</label>
                                        <div class="input-group">
                                        <input data-placement="bottomRight" maxlength="25" class="form-control icp icp-auto" id="ikon" value="fa-archive"
                                            type="text" readonly />
                                        <span class="input-group-addon"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    $footer = '<button type="submit" class="btn btn-default btn-orange pull-right" data-ref="'.Crypt::encryptstring('saveMenu').'"><i class="fa fa-check"></i> Simpan</span></button>';
                    return response()->json(['form' => $form,'title' => $title, 'size' => $size, 'footer'=>$footer]);
                        break;
                    
                    default:
                        # code...
                        break;
                }
           
                break;
            
            default:
                # code...
                break;
        }
    }
}