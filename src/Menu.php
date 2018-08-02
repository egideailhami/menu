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
        $data = DataMenu::first();
        $html ='<ul class="nav navbar-nav">
                                <li aria-haspopup="true" class="active">
                                    <a href="#"><i class="fa fa-dashboard"></i> Dashboard <span class="arrow"></span>
                                    </a>
                                </li>
                                <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                                    <a href="javascript:;"><i class="fa fa-flask"></i> Pengujian<span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li aria-haspopup="true" class="active ">
                                            <a href="#" class="nav-link  "><i class="fa fa-handshake-o"></i> Penerimaan Sampel </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-money"></i> Pembayaran </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-check-square-o"></i> Permohonan Pengujian </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-flask"></i> Pengujian Sampel </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-clone"></i> Hasil Pengujian </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-check-circle"></i> Pengujian Selesai </a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-remove"></i> Pengujian Batal</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-search"></i> Pencarian Pengujian </a>
                                        </li>
                                    </ul>
                                </li>
                                <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                                    <a href="javascript:;"><i class="fa fa-clipboard"></i> Laporan<span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Pengujian </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Parameter Pengujian </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Pendapatan </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Jumlah Klien </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-file-text-o"></i> Jumlah Sampel </a>
                                        </li>
                                    </ul>
                                </li>
                                <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                                    <a href="javascript:;"><i class="fa fa-database"></i> Data Master <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-user"></i> Klien </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-users"></i> Pegawai </a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="icon-layers"></i> Referensi </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-home"></i> Laboratorium </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-thermometer-empty"></i> Parameter Uji </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-flask"></i> Pengujian </a>
                                        </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-leaf"></i> Jenis Sampel </a>
                                        </li>
                                    </ul>
                                </li>
                                <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                                    <a href="javascript:;"><i class="fa fa-cogs"></i> Pengaturan <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-user-circle-o"></i> Pengaturan User </a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li aria-haspopup="true" class=" ">
                                            <a href="#" class="nav-link  "><i class="fa fa-cog"></i> Pengaturan Aplikasi </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>';
        return $html;
    }
}
