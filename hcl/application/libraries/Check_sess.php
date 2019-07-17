<?php
/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 29.07.18
 * Time: 22:08
 */

class check_sess
{
    public function check()
    {
        $CI = get_instance();
        //check_browser agent
        $CI->load->library('user_agent');

        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_robot()) {
            $agent = $CI->agent->robot();
        } elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }
        //check session id or start
        if (!session_id()) {
            session_start();
        }
        //sess id
        $ses_id = session_id();
        //ip address
        $ip = $CI->input->ip_address();
        //referer
        $referer = '';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'] . "||";
        }
        //time last 30 min
        $time = time() + 1800;

        //if isset sess
        $CI->db->order_by('id', 'desc');
        $CI->db->where('session', $ses_id);
        $sess = $CI->db->get('page_viewers')->row_array();

        //prepare add data session
        $add_ses = array(
            'session' => $ses_id,
            'ses_time' => $time,
            'ip' => $ip,
            'agent' => $agent,
            'referer' => $referer
        );
        if ($sess) {

            //if refresh
            if ($sess['ses_time'] <= $time) {
                if ($sess['referer'] != $referer and $referer != '') {
                    $referer = $sess['referer'] . $referer . "||";
                }
                $edit_ses = array(
                    'ses_time' => $time,
                    'referer' => $referer,
                    'ip' => $ip,
                    'agent' => $agent
                );
                $CI->db->where('id', $sess['id'], true);
                $CI->db->update('page_viewers', $edit_ses);
            } //if timeout session
            else {

                $CI->db->insert('page_viewers', $add_ses);
            }

        } else {
            //if no previos session
            $CI->db->insert('page_viewers', $add_ses);
        }
    }

    public function get_data($this_i,$ch_lang = ''){
        $CI = get_instance();
        $data = array();
        $data['browser'] = $CI->agent->browser();
        $data['robot'] = '';
        if ($CI->agent->is_robot()){
            $data['robot'] = 'robot';
        }
        $cookie_lang = $CI->input->cookie('lang');
        if ($cookie_lang!=''){
            $lang = $cookie_lang;
            if ($cookie_lang!=$ch_lang and $ch_lang!=''){
                delete_cookie('lang');
                $cookie = array(
                    'name'   => 'lang',
                    'value'  => $ch_lang,
                    'expire' => '31536000'
                );
                set_cookie($cookie);
                $lang = $ch_lang;
            }

        } elseif ($ch_lang!='') {
            $lang = $ch_lang;
            $cookie = array(
                'name'   => 'lang',
                'value'  => $lang,
                'expire' => '31536000'
            );
            set_cookie($cookie);
        } else {
            $lang = 'ua';
            $cookie = array(
                'name'   => 'lang',
                'value'  => $lang,
                'expire' => '31536000'
            );
            set_cookie($cookie);
        }
        $data['lang'] = $lang;
        return $data;
    }
}