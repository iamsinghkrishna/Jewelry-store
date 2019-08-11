<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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

class ups_lib {

    var $access = "5D344060BA9CE5AC";
    var $userid = "vaskiajewelrymiami@gmail.com";
    var $passwd = "April282015";//@VASapr2015
    
    public function __construct() {

    }

    /**
     * Get the shipping rates
     *
     * @param       array  $data    Input string
     * @return      array
     */
    public function getShipRates($data) {
        $outputFileName = base_url() . "wsdl/Rate/XOLTResult.xml";
        $wsdl = base_url() . "wsdl/Rate/RateWS.wsdl";
        $endpointurl = 'https://www.ups.com/webservices/Rate';
        $operation = "ProcessRate";
        try {

            $mode = array
                (
                'soap_version' => 'SOAP_1_1', // use soap 1.1 client
                'trace' => 1
            );

            // initialize soap client
            $client = new SoapClient($wsdl, $mode);

            //set endpoint url
            $client->__setLocation($endpointurl);


            //create soap header
            $usernameToken['Username'] = $this->userid;
            $usernameToken['Password'] = $this->passwd;
            $serviceAccessLicense['AccessLicenseNumber'] = $this->access;
            $upss['UsernameToken'] = $usernameToken;
            $upss['ServiceAccessToken'] = $serviceAccessLicense;

            $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
            $client->__setSoapHeaders($header);


            //get response
            $resp = $client->__soapCall($operation, array($data));
            return $resp;
        } catch (Exception $ex) {

            return $ex;
        }
    }

    /**
     * Get the shipping time transit
     *
     * @param       array  $request    Input string
     * @return      array
     */
    public function getTransitTime($request) {
        $outputFileName = base_url() . "wsdl/Time/XOLTResult.xml";
        $wsdl = base_url() . "wsdl/Time/TNTWS.wsdl";
        $endpointurl = 'https://wwwcie.ups.com/webservices/TimeInTransit';
        $operation = "ProcessTimeInTransit";

        try {

            $mode = array
                (
                'soap_version' => 'SOAP_1_1', // use soap 1.1 client
                'trace' => 1
            );

            // initialize soap client
            $client = new SoapClient($wsdl, $mode);

            //set endpoint url
            $client->__setLocation($endpointurl);

            $usernameToken['Username'] = $this->userid;
            $usernameToken['Password'] = $this->passwd;
            $serviceAccessLicense['AccessLicenseNumber'] = $this->access;
            $upss['UsernameToken'] = $usernameToken;
            $upss['ServiceAccessToken'] = $serviceAccessLicense;

            $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
            $client->__setSoapHeaders($header);



            //get response
            $resp = $client->__soapCall($operation, array($request));

            return $resp;
        } catch (Exception $e) {
            return $e;
        }
    }

    /*
     * Function to get tracking of the order
     *
     * $param array $request INput values
     * @return array
     */

    public function getTracking($request) {
        $outputFileName = base_url() . "wsdl/Track/XOLTResult.xml";
        $wsdl = base_url() . "wsdl/Track/Track.wsdl";
        $endpointurl = 'https://onlinetools.ups.com/webservices/Track';
        $operation = "ProcessTrack";
        try {
            $mode = array
                (
                'soap_version' => 'SOAP_1_1', // use soap 1.1 client
                'trace' => 1
            );

            // initialize soap client
            $client = new SoapClient($wsdl, $mode);

            //set endpoint url
            $client->__setLocation($endpointurl);


            //create soap header
            $usernameToken['Username'] = $this->userid;
            $usernameToken['Password'] = $this->passwd;
            $serviceAccessLicense['AccessLicenseNumber'] = $this->access;
            $upss['UsernameToken'] = $usernameToken;
            $upss['ServiceAccessToken'] = $serviceAccessLicense;

            $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
            $client->__setSoapHeaders($header);


            //get response
            $resp = $client->__soapCall($operation, array($request));

            //get status
           return $resp;
        } catch (Exception $ex) {
            return $resp;
        }
    }

}

?>
