<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    public function __construct() {
        parent::__construct();
    }

    function show_error($heading, $message, $template = 'error_general', $status_code = 500) {
        try {
            $str = parent::show_error($heading, $message, $template = 'error_general', $status_code = 500);

            throw new Exception($str);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $trace = "<h1>Call Trace</h1><pre>" . $e->getTraceAsString() . "<pre>";

            //append our stack trace to the error message
            $err = str_replace('</div>', $trace . '</div>', $msg);

            echo $err;
        }
    }

}

