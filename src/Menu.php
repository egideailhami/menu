<?php 
namespace GritTekno\Menu;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
use GritTekno\Menu\Models\Menu as DataMenu;

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
        $menu_id = [];
        foreach (\Auth::user()->role->aksesDets as $key => $aksesDet) {
            $menu_id[] = $aksesDet->id_mnu;
        };
        // dd($menu_id);
        foreach (DataMenu::where('id_parent',0)->where('header',0)->where('divider',0)->orderBy('urut','asc')->get() as $key => $menu) {
            $classMenuActive='';
            if (\Auth::user()->role->usr_akses != 'superuser') {
                if(in_array($menu->id_mnu,$menu_id) == false){
                    continue;
                }
            }
            $classSubMenuActive='';
            $sub='';
            $tagUl='';
            $count = DataMenu::where('id_parent',$menu->id_mnu)->count();
            if ($count == 0) {
                $classMenuActive = (\Request::is(ltrim($menu->url,'/')) ? 'active' : '');
            }
            foreach (DataMenu::where('id_parent',$menu->id_mnu)->orderBy('urut','asc')->get() as $key => $submenu) {
                if (\Auth::user()->role->usr_akses != 'superuser') {
                    if(in_array($submenu->id_mnu,$menu_id) == false){
                        continue;
                    }
                }
                $classSubMenuActive .= (\Request::is(ltrim($submenu->url,'/'))  ? 'active' : '');
                $sub2='';
                $tot_sub=0;
                foreach (DataMenu::where('id_parent',$submenu->id_mnu)->orderBy('urut','asc')->get() as $key => $submenu2) {
                    $sub2 .= ($submenu2->header == 1 ? "<li class='dropdown-header ".(\Request::is(ltrim($submenu2->url,'/')) ? 'active' : '')."'> ".$submenu2->menu_ut."</li>":'<li aria-haspopup="true" class="'.(\Request::is(ltrim($submenu2->url,'/')) ? 'active' : ' ').'">
                    <a href="'.($submenu2->url !=  '#' ? $submenu2->url :"javascript:;").'" class="nav-link  '.($submenu2->url ==  '#' ? strtolower(str_replace(' ','_',$submenu2->menu_ut)) :"").'"><i class="'.$submenu2->icon.'"></i> '.$submenu2->menu_ut.' </a>
                    </li>').($submenu2->divider == 1 ? "<li class=\"divider\"> </li>":"");
                    $tot_sub++;
                    
                }
                $tagsub = '<ul class="dropdown-menu">'.$sub2.'</ul>';
                // dd($submenu2);
                $sub .= ($submenu->header == 1 ? "<li class='dropdown-header ".(\Request::is(ltrim($submenu->url,'/')) ? 'active' : '')."'> ".$submenu->menu_ut."</li>":'<li aria-haspopup="true" class="'.($tot_sub > 0 ? 'dropdown-submenu':' ').(\Request::is(ltrim($submenu->url,'/')) ? 'active' : ' ').'">
                <a href="'.($submenu->url !=  '#' ? $submenu->url :"javascript:;").'" class="nav-link  '.($submenu->url ==  '#' ? strtolower(str_replace(' ','_',$submenu->menu_ut)) :"").'"><i class="'.$submenu->icon.'"></i> '.$submenu->menu_ut.' </a>
            '.$tagsub.'</li>').($submenu->divider == 1 ? "<li class=\"divider\"> </li>":"");
                        
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
            <th class="w150 ">Display Menu</th>
            <th class="w150">Menu Parent</th>
            <th class="w75 text-center">Header</th>
            <th class="w75 text-center">Divider</th>
            <th class="w75 text-center">Icon</th>
            <th class="">Routename</th>
            </tr>
        </thead>
    </table>';
        return $html;
    }
    
    public function tableRole()
    {
        $html = '<table class="table table-hover" id="tblRole">
        <thead>
            <tr>
            <th class="w25">No</th>
            <th class="w25 text-center">
                <a href="javascript:;" class="btn btn-info btn-xs blue add" data-type="role">
                    <i class="fa fa-plus fa-fw"></i>
                </a>
            </th>
            <th class="w200 ">Peran User</th>
            <th>Keterangan Peran</th>
            </tr>
        </thead>
    </table>';
        return $html;
    }
    public function tableRoleMenu()
    {
        $html = '<table class="table table-hover" id="tblRoleMenu">
        <thead>
            <tr>
            <th class="w25">No</th>
            <th class="w25 text-center">
                <input type="checkbox"  name="all_akses">
            </th>
            <th class="w200 ">Display Menu</th>
            <th>Menu Parent</th>
            </tr>
        </thead>
    </table>';
        return $html;
    }

    public function tableUser()
    {
        $html = '<table class="table table-hover" id="tblUser">
                    <thead>
                        <tr>
                        <th class="w25">No</th>
                        <th class="w25 text-center">
                            <a href="javascript:;" class="btn btn-info btn-xs blue add" data-type="user">
                                <i class="fa fa-plus fa-fw"></i>
                            </a>
                        </th>
                        <th class="w200 ">Nama User</th>
                        <th>Nama Lengkap</th>
                        <th class="w150">Role</th>
                        <th class="w150">Status</th>
                        </tr>
                    </thead>
                </table>';
        return $html;
    }
    
    public function tablePermission()
    {
        $html = '<table class="table table-hover" id="tblPermission">
                    <thead>
                        <tr>
                        <th class="w25">No</th>
                        <th class="w25 text-center">
                            <a href="javascript:;" class="btn btn-info btn-xs blue add" data-type="permission">
                                <i class="fa fa-plus fa-fw"></i>
                            </a>
                        </th>
                        <th class="w200 ">Ijin User</th>
                        <th>Keterangan Ijin</th>
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
                            { data: 'routename', name: 'routename' },
                        ],
                        'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>', 
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
                            'processing':     '<div class=\"loadingoverlay\" style=\"background-color: rgba(255, 255, 255, 0.8); position: fixed; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2147483647; background-image: url(&quot;/assets/images/loading.gif&quot;); background-position: center center; background-repeat: no-repeat; top: 0px; left: 0px; width: 100%; height: 100%; background-size: 100px;\"></div>',
                            'search':         'Pencarian :',
                            'zeroRecords':    'Tidak ada record yang cocok ditemukan',
                            'paginate': {
                                'first':      'Pertama',
                                'last':       'Terakhir',
                                'next':       'Berikutnya',
                                'previous':   'Sebelumnya'
                            }
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
                    showLoadingMenu();
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
                        hideLoadingMenu();
                        console.log(\"complete\");
                    });
                });

                $(document).on('click', '.btn-edit', function() {
                    showLoadingMenu();
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
                        hideLoadingMenu();
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
                    showLoadingMenu();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '".route('routeMenu')."',
                        type: $('#btn-submit').data('ref'),
                        data:$('#form').serialize(),
                        success: function(data) {
                            if ((data.error)) {
                                swal('Maaf !',data.error,'error');
                                console.log(\"error\");
                                hideLoadingMenu();
                            } else {
                                $('#tblMenu').DataTable().ajax.reload(null,false);
                                $('#myModal').modal('hide');
                                console.log(\"success\");
                                swalSuccess();
                                hideLoadingMenu();
                            }
                        },                
                    });   
                    console.log(\"complete\");
                });

                $(document).on('click', '.btn-delete', function() {
                    ref = $(this).data('ref');
                    swal({
                        title: 'Apa Anda yakin akan menghapusnya?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class=\"fa fa-trash\"></i> Ya',
                        cancelButtonText: '<i class=\"fa fa-times\"></i> Tidak',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            showLoadingMenu();
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
                                        hideLoadingMenu();
                                    } else {
                                        $('#tblMenu').DataTable().ajax.reload(null,false);
                                        swalDeleted();
                                        console.log(\"success\");
                                        hideLoadingMenu();
                                    }
                                },               
                            });   
                        }
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

    public function scriptSettingUser()
    {
        $html = "
        <script type=\"text/javascript\" src=\"".asset('vendor/fontawesome-iconpicker/js/fontawesome-iconpicker.js')."\"></script>
        <script type=\"text/javascript\" src=\"".asset('vendor/js/main.js')."\"></script>
        <script type=\"text/javascript\" src=\"".asset('vendor/select2/js/select2.full.min.js')."\"></script>
        <script>
            $(document).ready(function() {
                    var tabelUser = $('#tblUser').DataTable({
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        ajax: '".route('tableUser')."',
                        columns: [
                            { data: 'DT_Row_Index', name: 'DT_Row_Index', class:'text-center', orderable: false, searchable: false},
                            { data: 'action', name: 'action', class:'text-center', orderable: false, searchable: false},
                            { data: 'namauser', name: 'namauser' },
                            { data: 'nama_lkp', name: 'nama_lkp' },
                            { data: 'role', name: 'role' },
                            { data: 'status', name: 'status', class:'text-center', orderable: false, searchable: false},
                        ],
                        'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>', 
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
                            'processing':     '<div class=\"loadingoverlay\" style=\"background-color: rgba(255, 255, 255, 0.8); position: fixed; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2147483647; background-image: url(&quot;/assets/images/loading.gif&quot;); background-position: center center; background-repeat: no-repeat; top: 0px; left: 0px; width: 100%; height: 100%; background-size: 100px;\"></div>',
                            'search':         'Pencarian :',
                            'zeroRecords':    'Tidak ada record yang cocok ditemukan',
                            'paginate': {
                                'first':      'Pertama',
                                'last':       'Terakhir',
                                'next':       'Berikutnya',
                                'previous':   'Sebelumnya'
                            }
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
                    showLoadingMenu();
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
                        hideLoadingMenu();
                        console.log(\"complete\");
                    });
                });

                $(document).on('click', '.btn-edit', function() {
                    showLoadingMenu();
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
                        hideLoadingMenu();
                        console.log(\"complete\");
                    });
                });

                $('#myModal').on('show.bs.modal',function() {
                    $('#tabel_sumber').change(function(){
                        showLoadingMenu();
                        var myObject = {key:$(this).val()};
                        $.getJSON('".route('routeNamaUser')."',myObject, function(json) {
                            $('select[name=nama_lkp').html(json.data);
                        });
                        hideLoadingMenu();
                    });

                    $('select[name=role]').select2({
                        dropdownParent: $('#myModal')
                    });
                    
                    $('select[name=nama_lkp]').select2({
                        dropdownParent: $('#myModal')
                    });
                });

                $('#form').submit( function(e) {
                    e.preventDefault();
                    showLoadingMenu();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '".route('routeUser')."',
                        type: $('#btn-submit').data('ref'),
                        data:$('#form').serialize(),
                        success: function(data) {
                            if ((data.error)) {
                                swal('Maaf !',data.error,'error');
                                console.log(\"error\");
                                hideLoadingMenu();
                            } else {
                                $('#tblUser').DataTable().ajax.reload(null,false);
                                $('#myModal').modal('hide');
                                console.log(\"success\");
                                swalSuccess();
                                hideLoadingMenu();
                            }
                        },  
                        error: function (data) {
                            $('input').on('keydown keypress keyup click change',function(){
                                $(this).parent().removeClass('has-error');                                                       

                                $(this).next('.help-block').hide() 
                            });

                            $('.form-group').removeClass('has-error');
                            $('.help-block').hide();

                            var coba = new Array();
                            $.each(data.responseJSON.errors, function(name,value){
                                $('input[name='+name+']').parent().addClass('has-error'); 
                                $('input[name='+name+']').next('.help-block').show().text(value); 
                            });
                            hideLoadingMenu();
                            $('input[name='+coba[0]+']').focus();
                        }                    
                    });   
                    console.log(\"complete\");
                });

                $(document).on('click', '.btn-delete', function() {
                    ref = $(this).data('ref');
                    swal({
                        title: 'Apa Anda yakin akan menghapusnya?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class=\"fa fa-trash\"></i> Ya',
                        cancelButtonText: '<i class=\"fa fa-times\"></i> Tidak',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            showLoadingMenu();
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
                                        hideLoadingMenu();
                                    } else {
                                        $('#tblMenu').DataTable().ajax.reload(null,false);
                                        swalDeleted();
                                        console.log(\"success\");
                                        hideLoadingMenu();
                                    }
                                },               
                            });   
                        }
                    });
                });
            });
        </script>";
        return $html;
    }

    public function scriptSettingRolePermission()
    {
        $html = "
        <script type=\"text/javascript\" src=\"".asset('vendor/fontawesome-iconpicker/js/fontawesome-iconpicker.js')."\"></script>
        <script type=\"text/javascript\" src=\"".asset('vendor/js/main.js')."\"></script>
        <script type=\"text/javascript\" src=\"".asset('vendor/select2/js/select2.full.min.js')."\"></script>
        <script>
            $(document).ready(function() {
                    var tabelRole = $('#tblRole').DataTable({
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        ajax: '".route('tableRole')."',
                        columns: [
                            { data: 'DT_Row_Index', name: 'DT_Row_Index', class:'text-center', orderable: false, searchable: false},
                            { data: 'action', name: 'action', class:'text-center', orderable: false, searchable: false},
                            { data: 'usr_akses', name: 'usr_akses' },
                            { data: 'ket_akses', name: 'ket_akses' },
                        ],
                        'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>', 
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
                            'processing':     '<div class=\"loadingoverlay\" style=\"background-color: rgba(255, 255, 255, 0.8); position: fixed; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2147483647; background-image: url(&quot;/assets/images/loading.gif&quot;); background-position: center center; background-repeat: no-repeat; top: 0px; left: 0px; width: 100%; height: 100%; background-size: 100px;\"></div>',
                            'search':         'Pencarian :',
                            'zeroRecords':    'Tidak ada record yang cocok ditemukan',
                            'paginate': {
                                'first':      'Pertama',
                                'last':       'Terakhir',
                                'next':       'Berikutnya',
                                'previous':   'Sebelumnya'
                            }
                        },
                    });
                    var tabelRole = $('#tblPermission').DataTable({
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        ajax: '".route('tablePermission')."',
                        columns: [
                            { data: 'DT_Row_Index', name: 'DT_Row_Index', class:'text-center', orderable: false, searchable: false},
                            { data: 'action', name: 'action', class:'text-center', orderable: false, searchable: false},
                            { data: 'jns_hak', name: 'jns_hak' },
                            { data: 'ket_hak', name: 'ket_hak' },
                        ],
                        'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>', 
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
                            'processing':     '<div class=\"loadingoverlay\" style=\"background-color: rgba(255, 255, 255, 0.8); position: fixed; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2147483647; background-image: url(&quot;/assets/images/loading.gif&quot;); background-position: center center; background-repeat: no-repeat; top: 0px; left: 0px; width: 100%; height: 100%; background-size: 100px;\"></div>',
                            'search':         'Pencarian :',
                            'zeroRecords':    'Tidak ada record yang cocok ditemukan',
                            'paginate': {
                                'first':      'Pertama',
                                'last':       'Terakhir',
                                'next':       'Berikutnya',
                                'previous':   'Sebelumnya'
                            }
                        },
                    });

                    var tabelRoleMenu = $('#tblRoleMenu').DataTable({
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        ajax: '".route('tableRoleMenu')."',
                        columns: [
                            { data: 'DT_Row_Index', name: 'DT_Row_Index', class:'text-center', orderable: false, searchable: false},
                            { data: 'action', name: 'action', class:'text-center', orderable: false, searchable: false},
                            { data: 'menu_ut', name: 'menu_ut' },
                            { data: 'menu_parent', name: 'menu_parent' },
                        ],
                        'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>', 
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
                            'processing':     '<div class=\"loadingoverlay\" style=\"background-color: rgba(255, 255, 255, 0.8); position: fixed; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2147483647; background-image: url(&quot;/assets/images/loading.gif&quot;); background-position: center center; background-repeat: no-repeat; top: 0px; left: 0px; width: 100%; height: 100%; background-size: 100px;\"></div>',
                            'search':         'Pencarian :',
                            'zeroRecords':    'Tidak ada record yang cocok ditemukan',
                            'paginate': {
                                'first':      'Pertama',
                                'last':       'Terakhir',
                                'next':       'Berikutnya',
                                'previous':   'Sebelumnya'
                            }
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
                    showLoadingMenu();
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
                        hideLoadingMenu();
                        console.log(\"complete\");
                    });
                });

                $(document).on('click', '.btn-edit', function() {
                    showLoadingMenu();
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
                        hideLoadingMenu();
                        console.log(\"complete\");
                    });
                });

                $('select[name=filter_role_menu]').on('change', function(){
                    tabelRoleMenu.ajax.url('".env('menu_url')."/api/table/role_menu/'+$(this).val()).load();
                });
                
                $(document).on('click', 'input[name*=akses_menu]', function() {
                    // showLoadingMenu();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '".route('route_filter_role_menu')."',
                        type: 'POST',
                        data: {
                            ref: $(this).attr('data-ref'),
                            role: $('select[name=filter_role_menu]').val()
                        },
                        success: function(data) {
                            if ((data.error)) {
                                swal('Maaf !',data.error,'error');
                                console.log(\"error\");
                                // hideLoadingMenu();
                            } else {
                                $('#tblRole').DataTable().ajax.reload(null,false);
                                $('#tblPermission').DataTable().ajax.reload(null,false);
                                $('#myModal').modal('hide');
                                console.log(\"success\");
                                swalSuccess();
                                // hideLoadingMenu();
                            }
                        },                
                    });   
                    console.log(\"complete\");
                });

                $('#myModal').on('show.bs.modal',function() {
                    $('.icp-auto').iconpicker();
                    $('select[name=routename]').select2({
                        dropdownParent: $('#myModal')
                    });
                });

                $('#form').submit( function(e) {
                    e.preventDefault();
                    showLoadingMenu();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '".route('routeRP')."',
                        type: $('#btn-submit').data('ref'),
                        data:$('#form').serialize()+'&type='+$('#btn-submit').data('type'),
                        success: function(data) {
                            if ((data.error)) {
                                swal('Maaf !',data.error,'error');
                                console.log(\"error\");
                                hideLoadingMenu();
                            } else {
                                $('#tblRole').DataTable().ajax.reload(null,false);
                                $('#tblPermission').DataTable().ajax.reload(null,false);
                                $('#myModal').modal('hide');
                                console.log(\"success\");
                                swalSuccess();
                                hideLoadingMenu();
                            }
                        },                
                    });   
                    console.log(\"complete\");
                });

                $(document).on('click', '.btn-delete', function() {
                    ref = $(this).data('ref');
                    type = $(this).data('type');
                    swal({
                        title: 'Apa Anda yakin akan menghapusnya?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class=\"fa fa-trash\"></i> Ya',
                        cancelButtonText: '<i class=\"fa fa-times\"></i> Tidak',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#routeRP',
                    }).then((result) => {
                        if (result.value) {
                            showLoadingMenu();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '".route('routeRP')."',
                                type: 'delete',
                                data: {ref: ref, type:type},
                                success: function(data) {
                                    if ((data.error)) {
                                        swal('Sorry!',data.error,'error');
                                        console.log(\"error\");
                                        hideLoadingMenu();
                                    } else {
                                        $('#tblRole').DataTable().ajax.reload(null,false);
                                        $('#tblPermission').DataTable().ajax.reload(null,false);
                                        swalDeleted();
                                        console.log(\"success\");
                                        hideLoadingMenu();
                                    }
                                },               
                            });   
                        }
                    });
                });
            });
            $.getJSON('".route('route_filter_role_menu')."', function(json) {
                $('select[name=filter_role_menu]').append(json.data);
                $('select[name=filter_role_menu]').trigger('change');
                
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