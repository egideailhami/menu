<?php

namespace Egideailhami\Menu\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Egideailhami\Menu\Models\Menu as DataMenu;
use Illuminate\Support\Facades\Crypt;

class TableController extends Controller
{
    public function tableMenu()
    {
        $data=DataMenu::where('app',env('menu_app'));
        $result = Datatables::of($data);

        $result->addColumn('action', function ($data) {
            return '<div class="btn-toolbar">
            <div class="btn-group">
            <a href="javascript:;" class="btn btn-default btn-xs" data-toggle="dropdown">
            <i class="fa fa-cog"> &nbsp; <i class="fa fa-caret-down"></i></i></a>
            <ul class="dropdown-menu">
            <li><a href="javascript:;" data-ref="'.Crypt::encryptstring($data->id_mnu.'&20tekNo17').'" class="btn-edit"><i class="fa fa-pencil"></i> Edit </a></li>
            <li><a href="javascript:;" data-ref="'.Crypt::encryptstring($data->id_mnu.'&20tekNo17').'" class="btn-delete"><i class="fa fa-trash-o delete-tag"></i> Hapus </a></li>
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
}
