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
           $html .='<li aria-haspopup="true" class="'.( \Request::is($menu->url) ? 'active' : '' ).'">
                        <a href="'.$menu->url.'" class="nav-link  "><i class="fa fa-file-text-o"></i> Profil </a>
                    </li>';
                // $html .= '<ul class="dropdown-menu pull-left">
                // <li aria-haspopup="true" class=" ">
                //     <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Profil </a>
                // </li>
                // <li aria-haspopup="true" class=" ">
                //     <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Panduan Aplikasi </a>
                // </li>
                // <li class="dropdown-header"> Customs Bond</li>
                // <li aria-haspopup="true" class=" ">
                //     <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> P I B </a>
                // </li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
