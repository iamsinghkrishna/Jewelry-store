<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Create unique slugs for post titles etc.
 */

function create_unique_slug($string, $table) {
    $CI = & get_instance();

    $slug = url_title($string);
    $slug = strtolower($slug);
    $i = 0;
    $params = array();
    $params['slug'] = $slug;
    if ($CI->input->post('id')) {
        $params['id !='] = $CI->input->post('id');
    }

    while ($CI->db->where($params)->get($table)->num_rows()) {
        if (!preg_match('/-{1}[0-9]+$/', $slug)) {
            $slug .= '-' . ++$i;
        } else {
            $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
        }
        $params ['slug'] = $slug;
    }
    return $slug;
}

/**
 * Add or change error flashdata, only available
 * until the next request
 *
 * @access      public
 * @param       mixed
 * @param       string
 * @return      void
 */
function set_flashdata($newdata = array()) {
    $newdata['type'] = (isset($newdata['type']) ? $newdata['type'] : 'info');
    $newdata['msg'] = (isset($newdata['msg']) ? $newdata['msg'] : '');

    $str = '<div class="alert alert-' . $newdata['type'] . '">';
    $str .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    $str .= $newdata['msg'] . '</div>';
    return $str;
}


/*
 * 
 */

function randString($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $size = strlen($chars);
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}