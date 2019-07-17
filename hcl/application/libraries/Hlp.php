<?php
/**
 * Created by PhpStorm.
 * User: yevhenneydel
 * Date: 2018-12-28
 * Time: 13:27
 */

class Hlp
{

    function __construct() {
        $this->resp = array();
        $this->is_erorr = false;
        $this->admin_data = array();
    }

    function push_rights($adm = array()){;
        $this->admin_data = $adm;
    }


    function push($name = '',$value = ''){

        $this->resp[$name] = $value;

    }

    function push_arr($array = array()){
        foreach ($array as $key=>$val){
            $this->resp[$key] = $val;
        }
    }

    function error($error = ''){
        $this->is_error = true;
        $this->push('error',$error);
        $this->swal($error,'error');
        $this->return_data();
    }

    function swal($comment = '',$case = 'success',$no_return = false){


        switch ($case){
            case 'success':
                $this->resp['status'] = 'success';
                $this->resp['title'] = 'Успішно!';
                break;
            case 'error':
                $this->resp['status'] = 'warning';
                $this->resp['title'] = 'Помилка!';
                break;
            case 'info':

                break;
        }

        $this->resp['comment'] = $comment;
        $this->resp['type_alert'] = 'swal';


        if (!$no_return){
            $this->return_data();
        }
    }

    function lori($msg = '',$case = 'success',$no_return = false){


        switch ($case){
            case 'success':
                $this->resp['status'] = 'success';
                $this->resp['size'] = 'mini';
                break;
            case 'error':
                $this->resp['status'] = 'success';
                $this->resp['size'] = 'mini';
                break;
            case 'info':

                break;
        }

        $this->resp['msg'] = $msg;
        $this->resp['type_alert'] = 'lori';

        if (!$no_return){
            $this->return_data();
        }
    }

    function files(){
        $this->resp['status'] = 'isset';
        $this->resp['type_alert'] = 'none';

        $this->return_data();
    }

    function init_return($with_responce = false){
        if (count($this->resp)>0){
            $this->resp['status'] = 'success';
            $this->return_data();
        } else if ($with_responce) {
            $this->error('no responce data');
        }
    }

    function get_access(){
        if (!$this->admin_data){
            return false;
        }
        $rights = $this->admin_data['rights'];
        $CI = get_instance();
        $CI->db->where('id',$rights);
        $access = $CI->db->get('dussh_access')->row_array();
        if (!$access){
            return false;
        }

        return $access;
    }

    function check_access($func = ''){

        $allow_rights = array(
            "full_priv",
            "set_payments",
            "edit_payments",
            "show_payments",
            "set_trainings",
            "show_trainings",
            "edit_trainings",
            "edit_company_setting",
            "edit_sms_setting",
            "edit_admins",
            "edit_all_ch",
            "edit_groups",
            "edit_docs",
            "show_all_ch",
            "show_childs",
            "show_admins",
            "show_quittances",
            "show_groups",
            "show_docs"
        );

        $droped = true;
        foreach ($allow_rights as $one){
            if ($one===$func){
                $droped = false;
                $th_func = $one;
            }
        }

        if ($droped){
            return false;
        }


        $rights = $this->admin_data;
        $CI = get_instance();
        $CI->db->where('id',$rights['rights']);
        $CI->db->where($th_func,1);
        $access = $CI->db->get('dussh_access')->row_array();

        if ($access){
            return true;
        }
        return false;
    }


    function isset_page($page = ''){
        // Задаємо масив з доступними сторінками
        $show_rights_to_page = array(
            'show_childs'       => array('childs'),
            'show_admins'       => array('trainers','add_payment',"add_trainer"),
            'show_payments'     => array('payments'),
            'show_groups'       => array('groups','add_group'),
            'set_trainings'     => array('trainings','places'),
            'show_trainings'    => array('all_trainings'),
            'show_docs'         => array('docs')
        );

        // Вибираємо права адміна
        $rights = $this->admin_data;

        // Витягуємо права по ід з бази
        $CI = get_instance();
        $CI->db->where('id',$rights['rights']);
        $access = $CI->db->get('dussh_access')->row_array();

        //Добавляємо в масив всі доступні значення
        $user_access = array();
        foreach ($access as $key=>$value){
            if ($value==1){
                $user_access[$key] = $value;
            }
        }

        if (isset($user_access['full_priv'])){
            return $page;
        }
        $lock_page = 1;
        //массив перевірки загальних
        foreach ($show_rights_to_page as $key=>$one_right){

            if (!isset($user_access[$key])){
                continue;
            }

            foreach ($one_right as $one_page){
                //Перевірка чи є у наших правах дана сторінка
                if ($one_page==$page){
                    $lock_page = 0;
                }
            }

        }

        if ($lock_page==1){
            return $access['start_page'];
        } else {
            return $page;
        }

    }

    function safe_select($table = '',$where = array()){
        $ree = $this->admin_data;
        if ($table == ''){
            return false;
        }

        $CI = get_instance();

        $CI->db->where('company_id',$ree['company_id']);
        $CI->db->where($where);
        $ress = $CI->db->get($table)->result_array();

        return $ress;
    }

    function get_start_page(){
        $rights = $this->admin_data;

        $CI = get_instance();
        $CI->db->where('id',intval($rights['rights']));
        $access = $CI->db->get('dussh_access')->row_array();

        if ($access){
            return $access['start_page'];
        } else {
            return false;
        }
    }

    function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'', ' ' => '_', 'і' => 'i'));
        return $s; // возвращаем результат
    }

    function correct_photo($url = ''){
        // Create a cURL handle
        $ch = curl_init($url);

// Execute
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_HEADER  , true);
        curl_setopt($ch, CURLOPT_NOBODY  , true);
        curl_exec($ch);

//        $status = FALSE;
// Check HTTP status code
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    $status = TRUE;
                    break;
                default:
                    $status = FALSE;
            }
        }
// Close handle
        curl_close($ch);

//        die($status);
        return $status;
    }

    private function return_data(){
        echo json_encode($this->resp);
        die;
    }

    function validate_dir($path = '', $files = true){
        $path = str_replace('.','',$path);
        $path = str_replace('..','',$path);
        $path = str_replace('../','',$path);
        if ($files){
            $path = './Files/'.$path;
        }
        return $path;
    }

    function validate_path($path = '', $files = true){
        $path = str_replace('..','',$path);
        $path = str_replace('../','',$path);
        if ($files){
            $path = './Files/'.$path;
        }
        return $path;
    }

}