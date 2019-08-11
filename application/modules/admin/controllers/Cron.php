<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('common_model');
    }

    public function stockCheck() {
        $data['products'] = $this->common_model->getRecords('it_products as pr', 'pr.*,(select url from it_products_image as img where pr.id=img.product_id limit 1) as product_image', 'pr.quantity <= 2');
        $html = $this->load->view('email_templates/stock_notification', $data, true);
        if (count($data['products']) > 0) {
            $mail = $this->common_model->sendEmail(config_item('admin_email'), array("email" => config_item('site_email'), "name" => 'Vaskia'), 'Running with low stock', $html);
        }
    }

}
