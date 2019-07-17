<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Actions extends CI_Controller
{
    public $rootFolder = '';
    public $rootFolderId = '';
    public $should_to_check = array();

    function index() {
        if (isset($_POST['load'])){
            $data = array();
            $page = $_POST['page'];
//            $this->check_sess->check();
            $data['robot'] = '';
//            if ($this->agent->is_robot()){
//                $data['robot'] = 'robot';
//            }
//            if (isset($_POST['lang'])){
//                $cookie_lang = $_POST['lang'];
//            } else {
//                $cookie_lang = $this->input->cookie('lang');
//            }
//            $this->lang->load($page,$cookie_lang);
//            $this->lang->load('main_content', $cookie_lang);
            $data['page'] = $page;
//            $data['lang'] = $cookie_lang;
            if ($page!=''){
//                $page_cache = $page."_".$cookie_lang;
//                if (isset($_SESSION[$page_cache]) and $_SESSION[$page_cache]!=''){
//                    echo $_SESSION[$page_cache];
//                    $this->load->view('pages/end_loaded_js.php',$data);
//                } else {
//                    die($set_cookie);
                $this->lib_view->subload($page,$data);
//                    $cache_content = $this->load->view('pages/'.$page,$data,true);
//                    $_SESSION[$page_cache] = $cache_content;
//                }
            }
        }
    }

    function order() {
        if (isset($_POST['phone'])){
            $phone = $_POST['phone'];

            $name = '';
            $mail = '';

            if (isset($_POST['name']) and $_POST['name']!=''){
                $name = $_POST['name'];
            }

            if (isset($_POST['email']) and $_POST['email']!=''){
                $mail = $_POST['email'];
            }

            $order_data = array(
                'cname'     => $name,
                'cphone'    => $phone,
                'cemail'    => $mail,
                'order_time'=> time(),
                'cstatus'   => 'created'
            );

            $this->db->insert('orders',$order_data);


            $message_to_user = '<html>
                    <head>
                      <title>New order from website</title>
                    </head>
                    <body>
                      <div style="border: 2px solid rgb(0,120,120);background-color: hsl(0,0%,15%);width: calc(100% - 4px);max-width: 600px;text-align: center;">
                        <p><img src="https://neydel.com/img/main_logo.png" style="width: 250px"/></p>
                        <p style="color: hsl(0,0%,85%);font-size: 18px;">Здравствуйте '.$name.'. Благодарим за ваш заказ!</p>
                      </div>
                      <div style="width: calc(100% - 4px);max-width: 604px; padding-top: 1em">
                        <a href="https://neydel.com" style="width: 200px; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em; margin: 2em">
                            Перейти на сайт
                        </a>
                        <p style="font-size: 25px">
                            Для внесения предложений по усовершествованию сообщите на mail:
                        </p>
                        <a href="mailto:info@neydel.com">
                            info@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Есть проблемы с сайтом:
                        </p>
                        <a href="mailto:support@neydel.com">
                            support@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Связь с администрацией:
                        </p>
                        <a href="mailto:yevhen@neydel.com">
                            yevhen@neydel.com
                        </a>
                        <br>
                        <a href="tel:+380979294547">
                            +380979294547
                        </a>
                      </div>
                    </body>
                    </html>';

            $to_us     = $mail;
            $subject_us = 'Neydel.com';
            $headers_us  = 'MIME-Version: 1.0' . "\r\n";
            $headers_us .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers_us .= 'From: info@neydel.com' . "\r\n" .
                'Reply-To: yevhen@neydel.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion()."\r\n";

            $m_us = mail($to_us, $subject_us, $message_to_user, $headers_us);
            if ($m_us){

            }
            $message = '<html>
                    <head>
                      <title>New order from website</title>
                    </head>
                    <body>
                      <div style="border: 2px solid rgb(0,120,120);background-color: hsl(0,0%,15%);width: calc(100% - 4px);max-width: 600px;text-align: center;">
                        <p><img src="https://neydel.com/img/main_logo.png" style="width: 250px"/></p>
                        <p style="color: hsl(0,0%,85%);font-size: 18px;">Hello Yevhen, you have new order from site</p>
                      </div>
                      <table style="border: 1px solid hsl(0,0%,85%);width: 100%;max-width: 604px;text-align: center;">
                        <tr>
                          <th>Phone</th><th>Name</th><th>Mail</th><th>Date</th>
                        </tr>
                        <tr>
                          <td>'.$phone.'</td><td>'.$name.'</td><td>'.$mail.'</td><td>'.date('d.m.Y').'</td>
                        </tr>
                      </table>
                     
                    </body>
                    </html>';

// Для отправки HTML-письма должен быть установлен заголовок Content-type
            $to      = 'yevhen@neydel.com,jev.neydel@gmail.com';
            $subject = 'New order on website';
//            $message = 'Hello Yevhen, you have new order from site '."\r\n".'Phone: '.$phone."\r\n".'Name: '. $name."\r\n".'Mail: '.$mail;
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: robot@neydel.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion()."\r\n";


            $m = mail($to, $subject, $message, $headers);

            if ($m) {
                header('Location: https://neydel.com/#success');
            } else {
                header('Location: https://neydel.com/#wrong');
            }
        }
    }


    function resend_requers() {

        $mails = $_POST['mails'];
        $addMess = '';
        if (isset($_POST['message']) and $_POST['message']){
            $addMess = $_POST['message'];
        }
        $butt = "";
        if (isset($_POST['buttons']) and $_POST['buttons']){
            $buttons = $_POST['buttons'];
            if (isset($buttons[0])){
                for ($i=0;$i<count($buttons);$i++) {
                    $butt .= "<a href='".$buttons[$i]['link']."' style='width: 80%; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em;margin:1em'>".$buttons[$i]['name']."</a>";
                }
            } else {
                $butt .= "<a href='".$buttons['link']."' style='width: 80%; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em;margin:1em'>".$buttons['name']."</a>";
            }
        }
        $message = '<html>
                    <head>
                      <title>mail mess</title>
                    </head>
                    <body>
                      <div style="border: 2px solid rgb(0,120,120);background-color: hsl(0,0%,15%);width: calc(100% - 4px);max-width: 600px;text-align: center;padding-bottom: 3em">
                        <p><img src="https://neydel.com/img/main_logo.png" style="width: 250px"/></p>
                        <p style="color: hsl(0,0%,85%);font-size: 18px;">'.$addMess.'</p>
                        <div style="min-height: max-content;">
                        '.$butt.'
                        </div>
                        <br>
                      </div>
                      <br><br>
                      <div style="width: calc(100% - 4px);max-width: 604px; padding-top: 2em">
                        <a href="https://neydel.com" style="width: 200px; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em; margin: 2em">
                            Перейти на сайт
                        </a>
                        <p style="font-size: 25px">
                            Для внесения предложений по усовершествованию сообщите на mail:
                        </p>
                        <a href="mailto:info@neydel.com">
                            info@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Есть проблемы с сайтом:
                        </p>
                        <a href="mailto:support@neydel.com">
                            support@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Связь с администрацией:
                        </p>
                        <a href="mailto:yevhen@neydel.com">
                            yevhen@neydel.com
                        </a>
                        <br>
                        <a href="tel:+380979294547">
                            +380979294547
                        </a>
                      </div>
                    </body>
                    </html>';

        $to      = $mails;
        $subject = $addMess;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: info@neydel.com' . "\r\n" .
            'Reply-To:'.'yevhen@neydel.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion()."\r\n";

        $m = mail($to, $subject, $message, $headers);

        if ($m){
            echo 'Error request 404';
        }
    }


    function get_folder(){
        $source = $this->input->post('source',true);

        $source = $this->hlp->validate_dir($source);
        $files = scandir($source);

        $files = array_slice($files,2);

        if (!$files){
//            $this->hlp->error('fuck');
        } else {
            $resp = json_encode($files);
            $this->hlp->push('files',$resp);
        }

        $this->hlp->init_return();
        return;
    }

    function download_photo($hash = ''){
//        $dirname = dirname(__FILE__);
//        $dirname = explode("/", $dirname);
//        $dirname = array_slice($dirname,0,count($dirname)-2);
//        $dirname = implode("/",$dirname);
////        $this->hlp->error($dirname);
//        $local_path = $dirname . '/Files/' . $source;

//        $source = $this->input->post('source');
//        $local_path = 'http://' . $_SERVER['HTTP_HOST'] . '/Files/' . $source;

//        $local_path = $this->hlp->validate_path($local_path);

        $this->db->where('filehash', $hash);
        $local_path = $this->db->get('files')->row_array();

        $file = $local_path['filesource'];

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    function init_database(){
//        initialize medias
        $medias = $this->db->get('media')->result_array();

        $volumes = array();

        if ($medias){

            $i = 0;
            //upping volumes
            foreach ($medias as $media){
                $volumes[$i] = array(
                    'medianame'     => $media['medianame'],
                    'mediasize'     => $media['mediasize'],
                    'mediasource'   => $media['mediasource'],
                    'mediaId'       => $media['id']
                );
                $i++;
            }

            $MEDIA_ID = $medias[0]['id'];
            $this->setRootDirectory($volumes[0]['mediasource']);
        } else {

            $local_path = $this->setRootDirectory();

            $media = array(
                'medianame'     => 'Hard_Drive',
                'mediasize'     => '320 Gb',
                'mediasource'   => $local_path,
                'time'          => time()
            );

            $this->db->insert('media',$media);
            $MEDIA_ID = $this->db->insert_id();

            //add to volumes
            $volumes[0] = array(
                'medianame'     => 'Hard_Drive',
                'mediasize'     => '320 Gb',
                'mediasource'   => $local_path,
                'mediaId'       => $MEDIA_ID
            );
        }


        if (!$volumes){
            $this->hls->error('No volumes');
        }

        //add Root folders from Media
        foreach ($volumes as $one_volume) {
            $this->db->where('source', $one_volume['mediasource']);
            $mediaDir = $this->db->get('folders')->row_array();
            if (!$mediaDir) {
                $this->rootFolderId = $this->init_media_folder($one_volume['mediasource'], $one_volume['mediaId']);
            } else {
                $this->rootFolderId = $mediaDir['id'];
            }

            $push_arr = array(
                'filesource'     => $one_volume['mediasource'],
                'mediaId'       => $one_volume['mediaId'],
                'folderId'      => $this->rootFolderId
            );

            array_push($this->should_to_check, $push_arr);
        }

        if (!isset($this->should_to_check)){
            return;
        }

        while (count($this->should_to_check)>0){

            $mini_arr = array();
            $jj = 0;
            if (!isset($this->should_to_check)){
                return;
            }
            foreach ($this->should_to_check as $full_arr){
                $jj = 0;
                foreach ($full_arr as $value){
                    $mini_arr[$jj] = $value;
                    $jj++;
                }
            }
//            print_r($this->should_to_check);
//            print_r('lalasldlasldnaksjfhkajsgfhjkasjhkdfjkahsdhjkaskjhdhjkasghjkjghashjkfashjkfjkhashjkfhjkasfhkjashjkdhjkasdhjkashjk');
//            $this->init_media($filesource, $mediaId, $folderId);
            $this->init_media($mini_arr[0], $mini_arr[1], $mini_arr[2]);
            array_shift($this->should_to_check);
        }


    }

    private function init_media($source = '', $mediaId, $folderId){

//        $this->init_media($filesource,$mediaId,$newFolderId);


//        $source = $this->hlp->validate_dir($source, false);
        $files = scandir($source);
        $files = array_slice($files,2);


        if ($files){

            //foreach files
            foreach ($files as $file){

//                $file = $this->hlp->validate_path($file,false);

                $this->db->where('id',$folderId);
                $top_folder = $this->db->get('folders')->row_array();

                $filesource = $source.$file;
//                print_r($filesource);
//                check source by type
                if (is_dir($filesource)){
                    $filesource = $filesource.'/';
                    //check exists folder in database
                    $this->db->where('source',$filesource);
                    $exist_folder = $this->db->get('folders')->row_array();

                    //if folder doesn't exist
                    if (!$exist_folder){

                        //create filesource
                        $hashcode = $this->encrypt_path($filesource);
                        //insert into database
                        $dir_arr = array(
                            'folder_name' => $file,
                            'source'      => $filesource,
                            'level'       => $top_folder['level']+1,
                            'mediaId'     => $mediaId,
                            'folderId'    => $folderId,
                            'hashcode'    => $hashcode,
                            'timeAdded'   => time()
                        );
                        $this->db->insert('folders', $dir_arr);

//                        $newFolderId = $this->db->insert_id();

//                        $push_arr = array(
//                            'filesource'     => $filesource,
//                            'mediaId'       => $mediaId,
//                            'folderId'      => $newFolderId
//                        );
//
//                        array_push($this->should_to_check, $push_arr);
                    }
//                    $this->init_folder($folderId);
                } elseif(is_file($filesource)) {
//                    $filesource = $source.'/'.$file;
//                    print_r($filesource);
                    $this->init_file($file, $filesource, $folderId);
                }
            }

        }
    }

    private function init_file($filename = '', $filesource = '', $folderId = 0) {

        //isset folder
        $folder_db = $this->check_folder_by_id($folderId);
        if (!$folder_db){
            return;
        }


//        $filesource = $this->hlp->validate_path($filesource, false);
        $this->db->where('filesource', $filesource);
        $exist_file = $this->db->get('files')->row_array();
        if ($exist_file){
            return;
        }

//        $filetype = filetype($filesource);
        $info = new SplFileInfo($filename);
        $filetype = $info->getExtension();

        //create filesource
        $hashcode = $this->encrypt_path($filesource);

        //insert into database
        $dir_arr = array(
            'filename'    => $filename,
            'filesource'  => $filesource,
            'filetype'    => $filetype,
            'folderId'    => $folderId,
            'filehash'    => $hashcode,
            'timeAdded'   => time()
        );
        $this->db->insert('files', $dir_arr);

//        $this->hlp->init_return();

//        return;
    }

    private function init_folder($folderId = 0) {

        $folder_db = $this->check_folder_by_id($folderId);
        if (!$folder_db){
            return;
        }

        $source = $folder_db['source'];

        $source = $this->hlp->validate_dir($source, false);
        $files = scandir($source);

        $files = array_slice($files,2);

        if ($files){
            foreach ($files as $file){
                if (is_dir($file)){
                    $this->init_media($source."/".$file, $this->rootFolderId, $folder_db['id']);
                } elseif (is_file($file)){
                    $this->init_file($file, $folder_db['source'].'/'.$file, $folder_db['id']);
                }
            }
        }

        return;
    }

    private function init_media_folder($filesource, $mediaId){
        //check exists folder in database
        $filesource = $this->hlp->validate_dir($filesource,false);
        $this->db->where('source', $filesource);
        $exist_folder = $this->db->get('folders')->row_array();
        if (!$exist_folder){
            //create filesource
            $hashcode = $this->encrypt_path($filesource);

            //insert into database
            $dir_arr = array(
                'folder_name' => 'Hard_Drive',
                'source'      => $filesource,
                'level'       => 1,
                'mediaId'     => $mediaId,
                'folderId'    => $mediaId,
                'hashcode'    => $hashcode,
                'timeAdded'   => time()
            );
            $this->db->insert('folders', $dir_arr);

            $folderId = $this->db->insert_id();
        } else {
            $folderId = $exist_folder['id'];
        }

        return $folderId;
    }

    function getDrive(){
        $this->init_database();
        $current = $this->input->post('current');
        $back = $this->input->post('back');
        $level = $this->input->post('level');

        $responce = array();

        $medias = $this->db->get('media')->result_array();
        $mediaCount = 0;
        if ($medias){

            foreach ($medias as $media){

                $dir = $media['mediasource'];
                $driveName = $media['medianame'];
                $size = $media['mediasize'];
                $media_json = array(
                    'name'  => $driveName,
                    'size'  => $size,
                    'source'=> $dir
                );


                $mediaFiles = $this->getFolderFromMedia($media['id'], $current);

                $folder_w = $this->check_folder_by_hash($current);
                $level = $this->calc_level($folder_w['source']);
                $bread_cont = json_encode($this->get_bread($folder_w['source']));

                $responce[$mediaCount] = array(
                    'media'     =>      json_encode($media_json),
                    'files'     =>      json_encode($mediaFiles),
                    'back'      =>      $back,
                    'level'     =>      $level,
                    'bread'     =>      $bread_cont
                );
                $mediaCount++;
            }

        }

        echo json_encode($responce);
        return;
    }

    private function getFolderFromMedia($mediaId = 0,$hash = ''){

        //first request
        if ($hash==''){
            $this->db->where('mediaId', $mediaId);
            $this->db->where('level', 1);
            $drive = $this->db->get('folders')->row_array();

        } else {//request with hash
            //find folder
            $this->db->where('hashcode',$hash);
            $found_folder = $this->db->get('folders')->row_array();

            //find file
            $this->db->where('filehash',$hash);
            $found_file = $this->db->get('files')->row_array();

            //        compare variables
            if ($found_folder){
                $drive = $found_folder;
//                print_r($drive);
                $this->init_media($found_folder['source'], $mediaId, $drive['id']);
            } elseif($found_file) {
                $this->hlp->push('action','download');
                $this->hlp->push('hashed', $found_file['filehash']);
                $this->hlp->swal('Ok');
                return;
            } else {
//                $this->hlp->error('helloWord');
            }

        }

        $allFiles = array();
        $countFiles = 0;

        if ($drive){


            $this->db->where('folderId',$drive['id']);
            $folders = $this->db->get('folders')->result_array();
            foreach ($folders as $folder){
                $allFiles[$countFiles] = array(
                    'name'      => $folder['folder_name'],
                    'dateAdded' => $folder['timeAdded'],
                    'hashcode'  => $folder['hashcode'],
                    'filetype'  => 'folder'
                );
                $countFiles++;
            }

            $this->db->where('folderId',$drive['id']);
            $files = $this->db->get('files')->result_array();
            foreach ($files as $file){
                $allFiles[$countFiles] = array(
                    'name'      => $file['filename'],
                    'dateAdded' => $file['timeAdded'],
                    'hashcode'  => $file['filehash'],
                    'filetype'  => $this->filetype_to_icon($file['filetype'])
                );
                $countFiles++;
            }

//            print_r($allFiles);
        }

        return $allFiles;
    }

    function encrypt_path($source = ''){
        $private_key = $this->get_private_code();
        $time = time();
        $hash = hash_hmac('sha256',$time.$source,$private_key);
        return $hash;
    }

    function dencrypt_path($source = ''){
        $private_key = $this->get_private_code();
        $time = time();
        $hash = hash_hmac('sha256',$time.$source,$private_key);
        return $hash;
    }

    private function get_private_code(){
        $private_key = 'Wns4N08gP';

        return $private_key;
    }

    private function check_folder_by_id($folderId = 0){
        //check folder
        $this->db->where('id', $folderId);
        $folder_db = $this->db->get('folders')->row_array();

        if ($folder_db){
            return $folder_db;
        } else {
            return false;
        }
    }

    private function check_folder_by_hash($hash = 0){
        //check folder
        $this->db->where('hashcode', $hash);
        $folder_db = $this->db->get('folders')->row_array();

        if ($folder_db){
            return $folder_db;
        } else {
            return false;
        }
    }

    private function get_root_folder(){
        $this->rootFolder = '';
        $this->rootFolderId = 0;
    }

    private function calc_level($path = ''){
        $minLength = count(explode('/',$this->rootFolder));
        $maxLength = count(explode('/',$path));

        return ($maxLength - $minLength)+2;
    }

    private function get_bread($path = ''){
        $rootDirw = explode('/',$this->rootFolder);
        $currDirw = explode('/',$path);

        $bread_arr = array();
        $ij = 0;
        foreach ($currDirw as $kk=>$val){

            if ($rootDirw[$kk]!=$val){
                $this->db->where('folder_name',$val);
                $folder_w = $this->db->get('folders')->row_array();
                $bread_arr[$ij] = array(
                    $val,
                    $folder_w['hashcode']
                );
                $ij++;
            }
        }

        return $bread_arr;
    }

    private function filetype_to_icon($filetype = ''){
        $icon = 'file';
        switch ($filetype){
            case 'png':
              $icon = 'image';
              break;
            case 'jpg':
                $icon = 'image';
                break;
            case 'jpeg':
                $icon = 'image';
                break;
            case 'zip':
                $icon = 'archive';
                break;
            case 'rar':
                $icon = 'archive';
                break;
        }

        return $icon;
    }

    private function setRootDirectory($path = ''){
        $dirname = dirname(__FILE__);
        $dirname = explode("/", $dirname);
        $dirname = array_slice($dirname,0,count($dirname)-2);
        $dirname = implode("/",$dirname);

        //root path
        if ($path==''){

            //DEFAULT ROOT PATH
            $this->rootFolder = $dirname . '/Files/';
        } else {
            $this->rootFolder = $this->hlp->validate_dir($dirname.'/'.$path, false);
        }

        return $this->rootFolder;
    }
}