<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ups extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->CI = & get_instance();

        $this->load->library(array('ups_lib'));
        $this->load->model('common_model');
        $this->load->library('flexi_cart');
//        $this->load->model('common_model');
//        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//        /* Load Backend model */
//        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
//        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));
//
//        $this->lang->load('auth');
//        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax', 'backend/coupon_group', 'common_model', 'Common_model_marketing'));
//        $this->flexi = new stdClass;
//        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));
//        $this->load->library('flexi_cart');
//        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'demo_cart_admin_model'));
    }

    public function getRates()
    {
        $this->session->unset_userdata('shipping_total');
        $getshippinginfo                = $this->common_model->getRecords('us_zipcode',
            '', array('zipcode' => $this->input->post('cust_zipcode'),'country_name'=>$this->input->post('cust_country')));
        if (count($getshippinginfo) == 0) {
            echo json_encode(array('status' => '0', 'data' => "This postal code is invalid."));
            exit;
        }
        if ($this->input->post('cust_zipcode') != '' || $this->input->post('cust_country')
            != '') {

            $validacity = $this->getShippingTime($this->input->post());

            if ($validacity->Response->ResponseStatus->Description == 'Success') {

                $city = $validacity->TransitResponse->ShipTo->Address->City;
                $state = $validacity->TransitResponse->ShipTo->Address->StateProvinceCode;
                $country = $validacity->TransitResponse->ShipTo->Address->Country;
                $country_code = $validacity->TransitResponse->ShipTo->Address->CountryCode;
                $zipcode = $validacity->TransitResponse->ShipTo->Address->PostalCode;
                $this->session->set_userdata('customer_zipcode',
                    $this->input->post('cust_zipcode'));
                $this->session->set_userdata('customer_country',
                    $this->input->post('cust_country'));
                $this->session->set_userdata('customer_city',
                    $city);
                $this->session->set_userdata('customer_state',
                    $state);
                //create soap request
                $option['RequestOption'] = 'Shop';
                $request['Request']      = $option;

                $pickuptype['Code']        = '01';
                $pickuptype['Description'] = 'Daily Pickup';
                $request['PickupType']     = $pickuptype;

                $customerclassification['Code']        = '01';
                $customerclassification['Description'] = 'Classfication';
                $request['CustomerClassification']     = $customerclassification;

                $shipper['Name']              = '';
                $shipper['ShipperNumber']     = '2734W3';
                $address['AddressLine']       = array
                    (
                    '',
                    '',
                    ''
                );
                $address['City']              = 'Miami';
                $address['StateProvinceCode'] = 'FL';
                $address['PostalCode']        = '33156';
                $address['CountryCode']       = 'US';
                $shipper['Address']           = $address;
                $shipment['Shipper']          = $shipper;

                $shipto['Name']                           = '';
                $addressTo['AddressLine']                 = '';
                $addressTo['City']                        = $city;
                $addressTo['StateProvinceCode']           = $state;
                $addressTo['PostalCode']                  = $zipcode;
                $addressTo['CountryCode']                 = ($country == 'MEXICO')? "MX":"US";
                $addressTo['ResidentialAddressIndicator'] = '';
                $shipto['Address']                        = $addressTo;
                $shipment['ShipTo']                       = $shipto;

                $shipfrom['Name']                 = '';
//        $addressFrom['AddressLine'] = array
//            (
//            'Southam Rd',
//            '4 Case Court',
//            'Apt 3B'
//        );
                $addressFrom['City']              = 'Miami';
                $addressFrom['StateProvinceCode'] = 'FL';
                $addressFrom['PostalCode']        = '33156';
                $addressFrom['CountryCode']       = 'US';
                $shipfrom['Address']              = $addressFrom;
                $shipment['ShipFrom']             = $shipfrom;

                $service['Code']        = 'AMG';
                $service['Description'] = 'Service Code';
                $shipment['Service']    = $service;

                $packaging1['Code']                  = '02';
                $packaging1['Description']           = 'Rate';
                $package1['PackagingType']           = $packaging1;
                $dunit1['Code']                      = 'IN';
                $dunit1['Description']               = 'inches';
                $dimensions1['Length']               = '5';
                $dimensions1['Width']                = '4';
                $dimensions1['Height']               = '10';
                $dimensions1['UnitOfMeasurement']    = $dunit1;
                $package1['Dimensions']              = $dimensions1;
                $punit1['Code']                      = 'LBS';
                $punit1['Description']               = 'Pounds';
                $packageweight1['Weight']            = '0.5';
                $packageweight1['UnitOfMeasurement'] = $punit1;
                $package1['PackageWeight']           = $packageweight1;

                $shipment['Package']                = array($package1);
                $shipment['ShipmentServiceOptions'] = '';
                $shipment['LargePackageIndicator']  = '';
                $request['Shipment']                = $shipment;

                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
                if ($this->data['cart_summary']['item_summary_total'] < 250) {

                    $rate         = $this->ups_lib->getShipRates($request);

                    $shippingRate = "$".number_format($rate->RatedShipment[0]->TotalCharges->MonetaryValue,
                            2);
//                $_SESSION['custom_option']['shipping_total'] = number_format($rate->RatedShipment[0]->TotalCharges->MonetaryValue,
//                    2);
                    $this->session->set_userdata('shipping_total',
                        number_format($rate->RatedShipment[0]->TotalCharges->MonetaryValue,
                            2));
                } else {
                    $shippingRate = "Free";
                }
                if ($state == 'FL') {
                    $tax = ($this->data['cart_summary']['item_summary_total']
                        * 7 / 100);
//                $_SESSION['custom_option']['tax_total'] = $tax;
                    $this->session->set_userdata('tax_total', $tax);
                } else {
                    $tax = "0.00";
//                $_SESSION['custom_option']['tax_total'] = 0;
                    $this->session->set_userdata('tax_total', 0);
                }
                $custdata     = array('tax_total' => $tax, 'shipping_total' => number_format($rate->RatedShipment[0]->TotalCharges->MonetaryValue,
                        2));
                $this->session->set_userdata('tax_total', $tax);
                $discount     = $this->flexi_cart->summary_discount_data();
                $discount_val = str_replace('US $', ' ',
                    $discount['total']['value']);
                if ($discount_val != '' || $discount_val != '0') {
                    $total = ($this->data['cart_summary']['item_summary_total'] - $discount_val)
                        + $rate->RatedShipment[0]->TotalCharges->MonetaryValue + $tax;
                } else {
                    $total = $this->data['cart_summary']['item_summary_total'] + $rate->RatedShipment[0]->TotalCharges->MonetaryValue
                        + $tax;
                }
//        $this->session->set_userdata('flexi_cart')['shipping_total'] = $rate->RatedShipment[0]->TotalCharges->MonetaryValue;
                echo json_encode(array('status' => '1', 'data' => $shippingRate,
                    'tax' => number_format($tax,2),
                    'total' => "$".number_format($total, 2), 'city_name' => ucfirst(strtolower($city)),
                    'state_name' => (strlen($state) > 2)? ucwords(strtolower($state)): $state, 'msg' => "Tax and shipping updated. Shipping to ".ucfirst(strtolower($city))." (".ucfirst(strtolower($state)).")"));
            } else {
                echo json_encode(array('status' => '0', 'data' => $validacity->detail->Errors->ErrorDetail->PrimaryErrorCode->Description));
            }
        }
    }

    public function getShippingTime($data)
    {
        $getshippinginfo                = $this->common_model->getRecords('us_zipcode',
            '', array('zipcode' => $data['cust_zipcode']));
//        if (count($getshippinginfo) == 0) {
//            echo json_encode(array('status' => '0', 'data' => "Invalid postal code"));
//            exit;
//        }
        if($data['cust_country'] == 'USA'){
            $country = "US";
        }elseif($data['cust_country'] == 'Mexico'){
            $country = "MX";
        }else{
            $country = $data['cust_country'];
        }

        //create soap request
        $requestoption['RequestOption'] = 'TNT';
        $request['Request']             = $requestoption;

        $addressFrom['City']              = 'Miami';
        $addressFrom['CountryCode']       = 'US';
        $addressFrom['PostalCode']        = '33156';
        $addressFrom['StateProvinceCode'] = 'FL';
        $shipFrom['Address']              = $addressFrom;
        $request['ShipFrom']              = $shipFrom;

        $addressTo['City']              = '';
        $addressTo['StateProvinceCode'] = '';
        $addressTo['PostalCode']        = $data['cust_zipcode'];
        $addressTo['CountryCode']       = $country;
        $shipTo['Address']              = $addressTo;
        $request['ShipTo']              = $shipTo;
        $pickup['Date']                 = date("Ymd", strtotime("+1 day"));

        $request['Pickup'] = $pickup;

        $unitOfMeasurement['Code']           = 'LBS';
        $unitOfMeasurement['Description']    = 'Pounds';
        $shipmentWeight['UnitOfMeasurement'] = $unitOfMeasurement;
        $shipmentWeight['Weight']            = '0.5';
        $request['ShipmentWeight']           = $shipmentWeight;

        $request['TotalPackagesInShipment'] = '1';

        $invoiceLineTotal['CurrencyCode']  = 'USD';
        $invoiceLineTotal['MonetaryValue'] = '10';
        $request['InvoiceLineTotal']       = $invoiceLineTotal;

        $request['MaximumListSize'] = '1';

        (array) $result = $this->ups_lib->getTransitTime($request);

        return $result;
//        if ($result->Response->ResponseStatus->Description == 'Success') {
//            $output = "<table class='table table-bordered'>";
//            $output .= "<tr><th>Code</th>";
//            $output .= "<th>Shipping Package</th>";
//            $output .= "<th>Arrival Date & time</th>";
//            $output .= "<th>No of days</th></tr>";
//            foreach ($result->TransitResponse->ServiceSummary as $data) {
//                $output .= "<tr><td>".$data->Service->Code."</td>";
//                $output .= "<td>".$data->Service->Description."</td>";
//                $output .= "<td>".$data->EstimatedArrival->DayOfWeek.', '.date('d F Y',
//                        strtotime($data->EstimatedArrival->Arrival->Date))."</td>";
//                $output .= "<td>".$data->EstimatedArrival->TotalTransitDays."</td></tr>";
//            }
//            $output .= "</table>";
//            echo json_encode(array("status" => "1", "data" => $output));
//        } else {
//            echo json_encode(array("status" => "0", "data" => $result->detail->Errors->ErrorDetail->PrimaryErrorCode->Description));
//        }
    }

    public function TrackOrder()
    {
        //create soap request
        $req['RequestOption']        = '15';
        $tref['CustomerContext']     = 'Add description here';
        $req['TransactionReference'] = $tref;
        $request['Request']          = $req;
        $request['InquiryNumber']    = '';
        $request['TrackingOption']   = '01';
        $this->ups_lib->getTracking($request);
    }
}