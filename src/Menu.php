<?php 
namespace Egideailhami\Menu;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
use Egideailhami\Menu\Models\Menu as DataMenu;

class Menu
{

   /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
    private $m_SampleProperty = '';

    /**
    * Sample method
    *
    * Always create a corresponding docblock for each method, describing what it is for,
    * this helps the phpdocumentator to properly generator the documentation
    *
    * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
    *
    * @return string
    */
    public static function header($app)
    {
        $html ='<ul class="nav navbar-nav">';
        $classMenuActive='';
        foreach (DataMenu::where('id_parent',0)->where('header',0)->where('divider',0)->orderBy('urut','asc')->get() as $key => $menu) {
            $classSubMenuActive='';
            $sub='';
            $tagUl='';
            $count = DataMenu::where('id_parent',$menu->id_mnu)->count();
            if ($count == 0) {
                $classMenuActive = (\Request::is(ltrim($menu->url,'/')) ? 'active' : '');
            }
            foreach (DataMenu::where('id_parent',$menu->id_mnu)->orderBy('urut','asc')->get() as $key => $submenu) {
                $classSubMenuActive .= (\Request::is(ltrim($submenu->url,'/'))  ? 'active' : '');
                $sub .= ($submenu->header == 1 ? "<li class='dropdown-header ".(\Request::is(ltrim($submenu->url,'/')) ? 'active' : '')."'> ".$submenu->menu_ut."</li>":'<li aria-haspopup="true" class="'.(\Request::is(ltrim($submenu->url,'/')) ? "active" : '').'">
                <a href="'.($submenu->url !=  '#' ? $submenu->url :"javascript:;").'" class="nav-link  "><i class="'.$submenu->icon.'"></i> '.$submenu->menu_ut.' </a>
            </li>').($submenu->divider == 1 ? "<li class=\"divider\"> </li>":"");
                        
            $tagUl='<ul class="dropdown-menu pull-left">
            '.$sub.'</ul>';
            }

            $html .='<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown '.$classMenuActive.$classSubMenuActive.'" >
            <a href="'.($menu->url != '#' ? $menu->url :"javascript:;").'"><i class="'.$menu->icon.'"></i> '.$menu->menu_ut.'<span class="arrow"></span>
            </a>
           '.$tagUl.'
        </li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function sidebar($app)
    {
        $html ='<ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu">';
        $classMenuActive='';
        $classSubMenuActive='';
        foreach (DataMenu::where('id_parent',0)->where('header',0)->where('divider',0)->get() as $key => $menu) {
            $sub='';
            $tagUl='';            
            if ($count == 0) {
                $classMenuActive = (\Request::is(ltrim($menu->url,'/')) ? 'active' : '');
            }
            foreach (DataMenu::where('id_parent',$menu->id_mnu)->get() as $key => $submenu) {
                $classSubMenuActive .= (\Request::is(ltrim($submenu->url,'/')) ? 'active' : '');
                $sub .= ($submenu->header == 1 ? "<li class='dropdown-header ".(\Request::is(ltrim($submenu->url,'/')) ? 'active' : '')."'> ".$submenu->menu_ut."</li>":'<li aria-haspopup="true" class="'.(\Request::is(ltrim($submenu->url,'/')) ? "active" : '').'">
                <a href="'.($submenu->url != null ? '/'.$submenu->url :"javascript:;").'" class="nav-link  "><i class="'.$submenu->icon.'"></i> <span class="title">'.$submenu->menu_ut.'</span></a>
            </li>').($submenu->divider == 1 ? "<li class='divider'> </li>":"");
                        
            $tagUl='<ul class="sub-menu">
            '.$sub.'</ul>';
            }

            $html .='<li class="nav-item start '.$classMenuActive.$classSubMenuActive.'" >
            <a href="'.($menu->url != null ? '/'.$menu->url :"javascript:;").'"><i class="'.$menu->icon.'"></i>
            <span class="title"> '.$menu->menu_ut.'</span>
            <span class="arrow"></span>
            </a>
           '.$tagUl.'
        </li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public function tableMenu()
    {
        $html = ' <table class="table table-hover" id="tblMenu">
        <thead>
            <tr>
            <th class="w25">No</th>
            <th class="w25 text-center">
                <a href="javascript:;" class="btn btn-info btn-xs blue add" data-type="menu">
                    <i class="fa fa-plus fa-fw"></i>
                </a>
            </th>
            <th class="w150 ">Menu Utama</th>
            <th class="w150">Menu Parent</th>
            <th class="w75 text-center">Header</th>
            <th class="w75 text-center">Divider</th>
            <th class="w75 text-center">Icon</th>
            <th class="">Url</th>
            </tr>
        </thead>
    </table>';
        return $html;
    }

    public function scriptSettingMenu()
    {
        $html = "
<script type=\"text/javascript\" src=\"".asset('vendor/fontawesome-iconpicker/js/fontawesome-iconpicker.js')."\"></script>
<script type=\"text/javascript\" src=\"".asset('vendor/js/main.js')."\"></script>
<script type=\"text/javascript\" src=\"".asset('vendor/select2/js/select2.full.min.js')."\"></script>
        <script>
        
    $(document).ready(function() {
            var tabelMenu = $('#tblMenu').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '".route('tableMenu')."',
                columns: [
                    { data: 'DT_Row_Index', name: 'DT_Row_Index', class:'text-center', orderable: false, searchable: false},
                    { data: 'action', name: 'action', class:'text-center', orderable: false, searchable: false},
                    { data: 'menu_ut', name: 'menu_ut' },
                    { data: 'name_parent', name: 'name_parent' },
                    { data: 'header', name: 'header', class:'text-center', orderable: false, searchable: false},
                    { data: 'divider', name: 'divider', class:'text-center', orderable: false, searchable: false},
                    { data: 'icon', name: 'icon', class:'text-center', orderable: false, searchable: false},
                    { data: 'url', name: 'url' },
                ],
                language:{
                    'decimal':        '',
                    'emptyTable':     'Tak ada data yang tersedia pada tabel ini',
                    'info':           'Tampil _START_ s/d _END_ dari _TOTAL_ baris',
                    'infoEmpty':      'Menampilkan 0 sampai 0 dari 0 entri',
                    'infoFiltered':   '(difiler dari total entri _MAX_)',
                    'infoPostFix':    '',
                    'thousands':      ',',
                    'lengthMenu':     '_MENU_ Baris',
                    'loadingRecords': 'Loading...',
                    'processing':     '<div class=\"loadingoverlay\" style=\"background-color: rgba(255, 255, 255, 0.8); position: fixed; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2147483647; background-image: url(&quot;http:".env('imgLoading_path')."&quot;); background-position: center center; background-repeat: no-repeat; top: 0px; left: 0px; width: 100%; height: 100%; background-size: 100px;\"></div>',
                    'search':         'Pencarian :',
                    'zeroRecords':    'Tidak ada record yang cocok ditemukan',
                },
            });

    (function () {
        $('.table-scrollable').on('shown.bs.dropdown', function (e) {
            var table = $(this),
                menu = $(e.target).find('.dropdown-menu'),
                tableOffsetHeight = table.offset().top + table.height(),
                menuOffsetHeight = menu.offset().top + menu.outerHeight(true);

            if (menuOffsetHeight > tableOffsetHeight)
            table.css('padding-bottom', menuOffsetHeight - tableOffsetHeight);
        });

        $('.table-scrollable').on('hide.bs.dropdown', function () {
            $(this).css('padding-bottom', 0);
        })
    })();

    $(document).on('click', '.add', function() {
        showLoading();
        removeClassModal();
        $.ajax({
            url: '/grit/addmodal/'+$(this).data('type'),
            type: 'GET',
        })
        .done(function(data) {
            $('.modal-dialog').addClass(data.size);
            $('.modal-title').html(data.title);
            $('.modal-body').html(data.form);
            $('.modal-footer').html(data.footer);
            $('#myModal').modal({'backdrop': 'static'});
            $('#myModal').modal('show');
            console.log(\"success\");
        })
        .fail(function(data) {
            console.log(\"error\");
        })
        .always(function(data) {
            hideLoading();
            console.log(\"complete\");
        });
    });

    $(document).on('click', '.btn-edit', function() {
        showLoading();
        removeClassModal();
        $.ajax({
            url: '/grit/editmodal/'+$(this).data('type')+'/'+$(this).data('ref'),
            type: 'GET',
        })
        .done(function(data) {
            $('.modal-dialog').addClass(data.size);
            $('.modal-title').html(data.title);
            $('.modal-body').html(data.form);
            $('.modal-footer').html(data.footer);
            $('#myModal').modal({'backdrop': 'static'});
            $('#myModal').modal('show');
            console.log(\"success\");
        })
        .fail(function(data) {
            console.log(\"error\");
        })
        .always(function(data) {
            hideLoading();
            console.log(\"complete\");
        });
    });

    $.getJSON('".route('routeAppName')."', function(json) {
        $('select[name=name_app]').append(json.data);
    });

    $('select[name=name_app]').on('change', function(){
        tabelMenu.ajax.url('".env('menu_url')."/api/table/menu/'+$(this).val()).load();
    });
    
    $('#myModal').on('show.bs.modal',function() {
        $('.icp-auto').iconpicker();
        $('select[name=routename]').select2({
            dropdownParent: $('#myModal')
        });
    });

    $('#form').submit( function(e) {
        e.preventDefault();
        showLoading();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
            }
        });
        $.ajax({
            url: '".route('routeMenu')."',
            type: $(\"button:submit\").data('ref'),
            data:$('#form').serialize(),
            success: function(data) {
                if ((data.error)) {
                    swal('Maaf !',data.error,'error');
                    console.log(\"error\");
                    hideLoading();
                } else {
                    $('#tblMenu').DataTable().ajax.reload(null,false);
                    $('#myModal').modal('hide');
                    swal('Success!','Your Menu has been saved','success');
                    console.log(\"success\");
                    hideLoading();
                }
            },                
        });   
        console.log(\"complete\");
    });

    $(document).on('click', '.btn-delete', function() {
        ref = $(this).data('ref');
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class=\"fa fa-trash\"></i> Yes',
            cancelButtonText: '<i class=\"fa fa-times\"></i> No',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
        }).then(function() {
            showLoading();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                    }
                });
                $.ajax({
                    url: '".route('routeMenu')."',
                    type: 'delete',
                    data: {ref: ref},
                    success: function(data) {
                        if ((data.error)) {
                            swal('Sorry!',data.error,'error');
                            console.log(\"error\");
                            hideLoading();
                        } else {
                            $('#tblMenu').DataTable().ajax.reload(null,false);
                            swal('Success!','Your Menu has been deleted!','success');
                            console.log(\"success\");
                            hideLoading();
                        }
                    },               
                });   
        });
    });

    function preview(){
        $.getJSON('".route('routePreviewMenu')."', function(json) {
            $('#preview').html(json.data);
            $('.fa-refresh').removeClass('fa-spin');
        });
    };

    preview();

    $(document).on('click', '#btn-preview', function() {
        $('#preview').html('');
        $('.fa-refresh').addClass('fa-spin');
        preview();
    });
    
});
        </script>";
        return $html;
    }

    public function headerPreview()
    {
        $html='<div class="page-header" style="height:51px !important;">
                <div class="page-header-menu">  
                    <div class="container-fluid">
                        <div class="hor-menu  " id="preview">
                        </div>
                    </div>
                </div>
            </div>';
        return $html;
    }
}