<?php
/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 29.07.18
 * Time: 22:24
 */

class Lib_view
{
    function load($page = '', $data = ''){
        $CI = get_instance();
        $CI->load->view('pages/start_loader.php',$data);
        $CI->load->view($page, $data);
        $CI->load->view('pages/end_loaded_js.php',$data);
    }

    function subload($page = '', $data = ''){
        $CI = get_instance();
        $CI->load->view('pages/start_loader.php',$data);
        $CI->load->view('pages/'.$page.".php", $data);
        $CI->load->view('pages/end_loaded_js.php',$data);
    }
}