<?php

namespace GritTekno\Menu\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use GritTekno\Menu\Models\Menu as DataMenu;
use GritTekno\Menu\Models\AksesUsr as DataRole;
use GritTekno\Menu\Models\AksesHak as DataPermission;
use GritTekno\Menu\Models\AksesDet;
use GritTekno\Menu\Models\UsrWeb as DataUser;
use Illuminate\Support\Facades\Crypt;
use Auth;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tableMenu($app = null)
    {
        $data=DataMenu::orderBy('app','asc')->orderBy('id_parent','asc')->orderBy('urut','asc');
        if ($app) {
            $data=DataMenu::where('app',$app)->orderBy('id_parent','asc')->orderBy('urut','asc');
        }
        $result = Datatables::of($data);

        $result->addColumn('action', function ($data) {
            return '<div class="btn-toolbar">
            <div class="btn-group">
            <a href="javascript:;" class="btn btn-default btn-xs" data-toggle="dropdown">
            <i class="fa fa-cog"> &nbsp; <i class="fa fa-caret-down"></i></i></a>
            <ul class="dropdown-menu">
            <li><a href="javascript:;" data-type="menu" data-ref="'.Crypt::encryptstring($data->id_mnu.'&20tekNo17').'" class="btn-edit"><i class="fa fa-pencil"></i> Edit </a></li>
            <li><a href="javascript:;" data-type="menu" data-ref="'.Crypt::encryptstring($data->id_mnu.'&20tekNo17').'" class="btn-delete"><i class="fa fa-trash-o delete-tag"></i> Delete </a></li>
            </ul>
            </div>
            </div>
            ';
        });
        $result->addColumn('name_parent', function ($data) {
            $name_parent = '-';
            if ($data->id_parent != 0) {
                $name_parent =  DataMenu::Find($data->id_parent)->menu_ut;
            }
            return $name_parent;
        });

        $result->addColumn('header', function ($data) {
            return $data->header == 1 ? '<i class="fa fa-check-square-o"></i>':'<i class="fa fa-square-o"></i>';
        });
        $result->addColumn('divider', function ($data) {
            return $data->divider == 1 ? '<i class="fa fa-check-square-o"></i>':'<i class="fa fa-square-o"></i>';
        });
        $result->addColumn('icon', function ($data) {
            return '<i class="'.$data->icon.'"></i>';
        });

        $result->rawColumns(['action','name_parent','header','divider','icon']);

        return $result->addindexcolumn()->make(true);
    }

    public function tableRoleMenu($filter = null)
    {
        $data = DataMenu::where('app',env('nama_app'))->orderBy('id_parent','asc')->orderBy('urut','asc');

        $result = Datatables::of($data);

        $result->addColumn('action', function ($data) use ($filter) {
            $checked = '';
            if ($filter != null) {
                $id_uaks = Crypt::decryptString($filter);
                $akses_det = AksesDet::where('id_mnu',$data->id_mnu)->where('id_uaks',$id_uaks)->first();
                if($akses_det != NULL){
                    $checked = 'checked';
                }
                // dd($id_uaks);
            }
            return '<input type="checkbox"  name="akses_menu[]" data-ref="'.Crypt::encryptString($data->id_mnu).'" '.$checked.'>';
        });

        $result->addColumn('menu_ut', function ($data) {
            return '<i class="'.$data->icon.'"></i> '.$data->menu_ut;
        });

        $result->addColumn('menu_parent', function ($data) {
            $menu_parent = '-';
            if ($data->id_parent != 0) {
                $menu_parent =  DataMenu::Find($data->id_parent)->menu_ut;
            }
            return '<i class="'.$data->icon.'"></i> '.$menu_parent;
        });


        $result->rawColumns(['action','menu_parent','menu_ut']);

        return $result->addindexcolumn()->make(true);
    }

    public function tableRole()
    {
        $data=DataRole::where('usr_akses','!=','superuser');
        $result = Datatables::of($data);

        $result->addColumn('action', function ($data) {
            return '<div class="btn-toolbar">
            <div class="btn-group">
            <a href="javascript:;" class="btn btn-default btn-xs" data-toggle="dropdown">
            <i class="fa fa-cog"> &nbsp; <i class="fa fa-caret-down"></i></i></a>
            <ul class="dropdown-menu">
            <li><a href="javascript:;" data-type="role" data-ref="'.Crypt::encryptstring($data->id_uaks.'&20tekNo17').'" class="btn-edit"><i class="fa fa-pencil"></i> Edit </a></li>
            <li><a href="javascript:;" data-type="role" data-ref="'.Crypt::encryptstring($data->id_uaks.'&20tekNo17').'" class="btn-delete"><i class="fa fa-trash-o delete-tag"></i> Delete </a></li>
            </ul>
            </div>
            </div>
            ';
        });

        $result->rawColumns(['action']);

        return $result->addindexcolumn()->make(true);
    }
    
    public function tablePermission()
    {
        $data=DataPermission::query();
        $result = Datatables::of($data);

        $result->addColumn('action', function ($data) {
            return '<div class="btn-toolbar">
            <div class="btn-group">
            <a href="javascript:;" class="btn btn-default btn-xs" data-toggle="dropdown">
            <i class="fa fa-cog"> &nbsp; <i class="fa fa-caret-down"></i></i></a>
            <ul class="dropdown-menu">
            <li><a href="javascript:;" data-type="permission" data-ref="'.Crypt::encryptstring($data->id_akk.'&20tekNo17').'" class="btn-edit"><i class="fa fa-pencil"></i> Edit </a></li>
            <li><a href="javascript:;" data-type="permission" data-ref="'.Crypt::encryptstring($data->id_akk.'&20tekNo17').'" class="btn-delete"><i class="fa fa-trash-o delete-tag"></i> Delete </a></li>
            </ul>
            </div>
            </div>
            ';
        });

        $result->rawColumns(['action']);

        return $result->addindexcolumn()->make(true);
    }
    
    public function tableUser()
    {
        $data=DataUser::where('namauser','!=','superuser');
        $result = Datatables::of($data);

        $result->addColumn('action', function ($data) {
            return '<div class="btn-toolbar">
            <div class="btn-group">
            <a href="javascript:;" class="btn btn-default btn-xs" data-toggle="dropdown">
            <i class="fa fa-cog"> &nbsp; <i class="fa fa-caret-down"></i></i></a>
            <ul class="dropdown-menu">
            <li><a href="javascript:;" data-type="permission" data-ref="'.Crypt::encryptstring($data->id_akk.'&20tekNo17').'" class="btn-edit"><i class="fa fa-pencil"></i> Edit </a></li>
            <li><a href="javascript:;" data-type="permission" data-ref="'.Crypt::encryptstring($data->id_akk.'&20tekNo17').'" class="btn-delete"><i class="fa fa-trash-o delete-tag"></i> Delete </a></li>
            </ul>
            </div>
            </div>
            ';
        });
        $result->addColumn('status', function ($data) {
            if ($data->status == 1) {
                $status='<span class="btn btn-primary aktif" data-val="'.Crypt::encryptstring('0').'" data-ref="'.Crypt::encryptstring($data->id_usr).'" style="width:94.08px;">Aktif</span>';
            } else {
                $status='<span class="btn btn-danger aktif" data-val="'.Crypt::encryptstring('1').'" data-ref="'.Crypt::encryptstring($data->id_usr).'">Tidak Aktif</span>';
            }
            return $status;
        });
        $result->addColumn('role', function ($data) {
            return $data->role->usr_akses;
        });

        

        $result->rawColumns(['action','status','role']);

        return $result->addindexcolumn()->make(true);
    }
}
