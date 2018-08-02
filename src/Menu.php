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
        foreach (DataMenu::where('id_parent',0)->get() as $key => $menu) {
            $sub='';
            $tagUl='';
            foreach (DataMenu::where('id_parent',$menu->id_mnu)->get() as $key => $submenu) {
                $sub .= ($submenu->header == 1 ? "<li class='dropdown-header'> ".$submenu->menu_ut."</li>":'<li aria-haspopup="true" class=" ">
                <a href="'.($menu->url != null ? $menu->url :"javascript:;").'" class="nav-link  "><i class="'.$submenu->icon.'"></i> '.$submenu->menu_ut.' </a>
            </li>').($submenu->divider == 1 ? "<li class='divider'> </li>":"");
                        
            $tagUl='<ul class="dropdown-menu pull-left">
            '.$sub.'</ul>';
            }

            $html .='<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
            <a href="'.($menu->url != null ? $menu->url :"javascript:;").'"><i class="'.$menu->icon.'"></i> '.$menu->menu_ut.'<span class="arrow"></span>
            </a>
           '.$tagUl.'
        </li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
