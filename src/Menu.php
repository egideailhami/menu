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
use App\Models\Menu as DataMenu;

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
        $classSubMenuActive='';
        foreach (DataMenu::where('id_parent',0)->where('header',0)->where('divider',0)->get() as $key => $menu) {
            $sub='';
            $tagUl='';
            $classMenuActive = (\Request::is($menu->url) ? 'active' : '');
            foreach (DataMenu::where('id_parent',$menu->id_mnu)->get() as $key => $submenu) {
                $classSubMenuActive .= (\Request::is($submenu->url) ? 'active' : '');
                $sub .= ($submenu->header == 1 ? "<li class='dropdown-header ".(\Request::is($submenu->url) ? 'active' : '')."'> ".$submenu->menu_ut."</li>":'<li aria-haspopup="true" class="'.(\Request::is($submenu->url) ? "active" : '').'">
                <a href="'.($submenu->url != null ? '/'.$submenu->url :"javascript:;").'" class="nav-link  "><i class="'.$submenu->icon.'"></i> '.$submenu->menu_ut.' </a>
            </li>').($submenu->divider == 1 ? "<li class='divider'> </li>":"");
                        
            $tagUl='<ul class="dropdown-menu pull-left">
            '.$sub.'</ul>';
            }

            $html .='<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown '.$classMenuActive.$classSubMenuActive.'" >
            <a href="'.($menu->url != null ? '/'.$menu->url :"javascript:;").'"><i class="'.$menu->icon.'"></i> '.$menu->menu_ut.'<span class="arrow"></span>
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
            $classMenuActive = (\Request::is($menu->url) ? 'active' : '');
            foreach (DataMenu::where('id_parent',$menu->id_mnu)->get() as $key => $submenu) {
                $classSubMenuActive .= (\Request::is($submenu->url) ? 'active' : '');
                $sub .= ($submenu->header == 1 ? "<li class='dropdown-header ".(\Request::is($submenu->url) ? 'active' : '')."'> ".$submenu->menu_ut."</li>":'<li aria-haspopup="true" class="'.(\Request::is($submenu->url) ? "active" : '').'">
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

    public function settingMenu()
    {
        $html = ' <table class="table table-hover" id="tblform">
        <thead>
            <tr>
            <th class="w50">No</th>
            <th class="w50 text-center">
                <a href="javascript:;" class="btn btn-info btn-xs blue add" data-type="form">
                    <i class="fa fa-plus fa-fw"></i>
                </a>
            </th>
            <th class="w200 ">App Name</th>
            <th class="w200 ">Menu Utama</th>
            <th class="w200">Menu Parent</th>
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
        $html = '<script>
        
        </script>';
        return $html;
    }
}
