<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * This CI library is based on the Paypal PHP class by Micah Carrick
 * See www.micahcarrick.com for the most recent version of this class
 * along with any applicable sample files and other documentaion.
 *
 * This file provides a neat and simple method to interface with paypal and
 * The paypal Instant Payment Notification (IPN) interface.  This file is
 * NOT intended to make the paypal integration "plug 'n' play". It still
 * requires the developer (that should be you) to understand the paypal
 * process and know the variables you want/need to pass to paypal to
 * achieve what you want.  
 *
 * This class handles the submission of an order to paypal as well as the
 * processing an Instant Payment Notification.
 * This class enables you to mark points and calculate the time difference
 * between them.  Memory consumption can also be displayed.
 *
 * The class requires the use of the PayPal_Lib config file.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Inventory Management
 * @author      Atul Suroshe <atul.suroshe@gmail.com>
 * @copyright   Copyright (c) 2017, http://rebelute.com/
 *
 */
// ------------------------------------------------------------------------

class clover
{
    var $CI;

    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->config('clover_config');

        $sanbox             = $this->CI->config->item('sandbox');
        $this->access_token = $this->CI->config->item('access_token');
        $this->clover_url   = ($sanbox == TRUE) ? 'https://apisandbox.dev.clover.com/v3/merchants/'.$this->CI->config->item('merchant_id')
                : 'https://api.clover.com:443/v3/merchants/'.$this->CI->config->item('merchant_id');
    }
    /*
     * Function to get items from clover
     * @return array
     */

    public function getAllProducts($showlimit)
    {
        if ($showlimit != '') {
            $url = $this->clover_url.'/items?offset=1001&limit=1000&expand=itemStock';
        } else {
            $url = $this->clover_url.'/items?offset=1&limit=1000&expand=itemStock';
        }
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get items from clover
     * @return array
     */

    public function getSingleProduct($product_id)
    {

        $url = $this->clover_url.'/items/'.$product_id.'?expand=categories,taxRates,itemStock';
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get customers from clover
     * @return array
     */

    public function getCustomers()
    {

        $url = $this->clover_url.'/customers';
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get customers from clover
     * @param $data 
     * @return array
     */

    public function createCustomers($data)
    {

        $url = $this->clover_url.'/customers';
        return json_decode($this->curlPost($url, $data), TRUE);
    }
    /*
     * Function to get single customer from clover
     * @param $data 
     * @return array
     */

    public function getSingleCustomer($customer_id)
    {

        $url = $this->clover_url.'/customers/'.$customer_id;
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to create item in clover
     * @param $data 
     * @return array
     */

    public function createProduct($data)
    {

        $url = $this->clover_url.'/items/';
        return json_decode($this->curlPost($url, $data), TRUE);
    }
    /*
     * Function to create item in clover
     * @param $data 
     * @return array
     */

    public function updateProduct($product_id, $data)
    {

        $url = $this->clover_url.'/items/'.$product_id.'?expand=categories,taxRates,itemStock';
        return json_decode($this->curlPost($url, $data), TRUE);
    }
    /*
     * Function to delete item in clover
     * @param $data 
     * @return array
     */

    public function deleteProduct($itemid)
    {

        $url = $this->clover_url.'/items/'.$itemid;
        return json_decode($this->curlDelete($url), TRUE);
    }
    /*
     * Function to create product category in clover
     * @param $data 
     * @return array
     */

    public function getAllCategory()
    {

        $url = $this->clover_url.'/categories/';
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to create product category in clover
     * @param $data 
     * @return array
     */

    public function createProductCategory($postdata)
    {

        $url = $this->clover_url.'/categories/';
        return json_decode($this->curlPost($url, $postdata), TRUE);
    }
    /*
     * Function to update product stock count in clover
     * @param $data 
     * @return array
     */

    public function updateStockCount($itemid, $postdata)
    {

        $url = $this->clover_url.'/item_stocks/'.$itemid;
        return json_decode($this->curlPost($url, $postdata), TRUE);
    }
    /*
     * Function to create product category in clover
     * @param $data 
     * @return array
     */

    public function getAllCategories()
    {

        $url = $this->clover_url.'/categories/';
        return json_decode($this->curlPost($url, $postdata), TRUE);
    }
    /*
     * Function to get item stock from clover
     * @param $data 
     * @return array
     */

    public function getItemStock($item_id)
    {

        $url = $this->clover_url.'/item_stocks/'.$item_id;
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get item stock from clover
     * @param $data 
     * @return array
     */

    public function getAllOrders($showlimit = "")
    {
       $url = $this->clover_url.'/orders?orderBy=clientCreatedTime%20DESC&limit=1000&expand=customers';       

        // if ($showlimit != '') {
            // $url = $this->clover_url.'/orders?orderBy=clientCreatedTime%20ASC&offset=1&limit=1000&expand=customers';
        // } else {
           // $url = $this->clover_url.'/orders?orderBy=clientCreatedTime%20DESC&offset=1&limit=1000&expand=customers';
        // }
//        echo $url;
//        die;
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get customer of order from clover
     * @param $data 
     * @return array
     */

    public function getCustomerNameOfProduct($cust_id)
    {

        $url = $this->clover_url.'/customers/'.$cust_id;
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get order details from clover
     * @param $data 
     * @return array
     */

    public function getOrderDetails($order_id)
    {

        $url = $this->clover_url.'/orders/'.$order_id.'?expand=lineItems,discounts,customers,payments,employee,devices';
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get order details from clover
     * @param $data 
     * @return array
     */

    public function getEmployeeDetails($emp_id)
    {

        $url = $this->clover_url.'/employees/'.$emp_id;
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get order details from clover
     * @param $data 
     * @return array
     */

    public function getPaymentsOfOrder($order_id)
    {

        $url = $this->clover_url.'/orders/'.$order_id.'/payments';
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get order details from clover
     * @param $data 
     * @return array
     */

    public function getDeviceDetails($device_id)
    {

        $url = $this->clover_url.'/devices/'.$device_id;
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get order details from clover
     * @param $data 
     * @return array
     */

    public function getItemsOfOrder($order_id)
    {

        $url = $this->clover_url.'/orders/'.$order_id.'/line_items';
        return json_decode($this->curlPost($url), TRUE);
    }
    /*
     * Function to get order details from clover
     * @param $data 
     * @return array
     */

    public function getDiscountOfOrder($order_id)
    {

        $url = $this->clover_url.'/orders/'.$order_id.'/discounts';
        return json_decode($this->curlPost($url), TRUE);
    }

    function curlPost($url, $post_data = NULL)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->access_token));
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Authorization: Bearer '.$this->access_token
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if ($post_data != NULL) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        }
        $data      = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $data;
    }

    function curlDelete($url)
    {
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Authorization: Bearer '.$this->access_token
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
?>
