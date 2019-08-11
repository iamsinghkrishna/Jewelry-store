<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Angell EYE - PayPal CodeIgniter Library Demo Kits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Angell EYE">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        #angelleye-logo { margin:10px 0; }
    </style>
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div id="header" class="row clearfix">
                <div class="col-md-6 column">
                    <div id="angelleye-logo">
                        <a href="#"><img class="img-responsive" alt="Angell EYE PayPal CodeIgniter Library Demo" src="https://www.angelleye.com/images/paypal-codeigniter-library-demo-header.png"></a>
                    </div>
                </div>
            </div>
            <div class="jumbotron well">
                <h2> PayPal CodeIgniter Library Demo Kits</h2>
                <p>This is a collection of demo apps for a variety of PayPal checkout flows using our PayPal library.</p>
            </div>
            <div class="alert alert-warning">
                <p>To begin, click 'View Demo' button on any of the demos listed below.</p>
                <p>If you have any troubles you may <a href="https://www.angelleye.com/support" target="_blank">submit a support ticket</a> and we will be happy to help.</p>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?php
                    $controller = 'paypal/demos/Express_checkout.php';
                    $controller_exists = (file_exists(APPPATH."controllers/".$controller)) ? true : false;
                    $panel_class = ($controller_exists) ? ' panel-info' : ' panel-default';
                    ?>
                    <div class="panel <?php if(isset($panel_class)) echo $panel_class; ?>">
                        <div class="panel-heading">
                            <h3>Express Checkout</h3>
                            <p>BASIC</p>
                        </div>
                        <div class="panel-body">
                            <p>Here we are integrating Express Checkout without any line item details or any extra features. We obtain the user's shipping information so that we can calculate shipping and tax, but otherwise no additional data is included with this checkout demo.</p>
                            <?php if($controller_exists) { ?>
                                <a class="btn btn-primary btn-block" href="<?php echo site_url('paypal/demos/express_checkout');?>">View Demo</a>
                            <?php } else { ?>
                                <a class="btn btn-default btn-block" href="https://www.angelleye.com/?s=codeigniter&post_type=product" target="_blank">Download/Buy</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $controller = 'paypal/demos/Express_checkout_with_line_items.php';
                    $controller_exists = (file_exists(APPPATH."controllers/".$controller)) ? true : false;
                    $panel_class = ($controller_exists) ? ' panel-info' : ' panel-default';
                    ?>
                    <div class="panel <?php if(isset($panel_class)) echo $panel_class; ?>">
                        <div class="panel-heading">
                            <h3>Express Checkout</h3>
                            <p>WITH LINE ITEMS</p>
                        </div>
                        <div class="panel-body">
                            <p>Here we expand on our basic Express Checkout demo to add individual order items to the API requests so that the data is available within PayPal's checkout review pages transaction details.</p>
                            <?php if($controller_exists) { ?>
                                <a class="btn btn-primary btn-block" href="<?php echo site_url('paypal/demos/express_checkout_with_line_items');?>">View Demo</a>
                            <?php } else { ?>
                                <a class="btn btn-success btn-block" href="https://www.angelleye.com/product/codeigniter-paypal-integration-express-checkout-line-items-demo" target="_blank">Buy Now</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $controller = 'paypal/demos/Express_checkout_digital_goods.php';
                    $controller_exists = (file_exists(APPPATH."controllers/".$controller)) ? true : false;
                    $panel_class = ($controller_exists) ? ' panel-info' : ' panel-default';
                    ?>
                    <div class="panel <?php if(isset($panel_class)) echo $panel_class; ?>">
                        <div class="panel-heading">
                            <h3>Express Checkout</h3>
                            <p>DIGITAL GOODS</p>
                        </div>
                        <div class="panel-body">
                            <p>Learn how to implement digital goods (micro-processing rates) into PayPal Express Checkout. This includes the option for embedded payments.</p>
                            <?php if($controller_exists) { ?>
                                <a class="btn btn-primary btn-block" href="<?php echo site_url('paypal/demos/express_checkout_digital_goods');?>">View Demo</a>
                            <?php } else { ?>
                                <a class="btn btn-success btn-block" href="https://www.angelleye.com/product/codeigniter-paypal-integration-express-checkout-digital-goods-demo" target="_blank">Buy Now</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $controller = 'paypal/demos/Express_checkout_with_billing_agreement.php';
                    $controller_exists = (file_exists(APPPATH."controllers/".$controller)) ? true : false;
                    $panel_class = ($controller_exists) ? ' panel-info' : ' panel-default';
                    ?>
                    <div class="panel <?php if(isset($panel_class)) echo $panel_class; ?>">
                        <div class="panel-heading">
                            <h3>Express Checkout</h3>
                            <p>BILLING AGREEMENT</p>
                        </div>
                        <div class="panel-body">
                            <p>Learn how to implement digital goods (micro-processing rates) into PayPal Express Checkout. This includes the option for embedded payments.</p>
                            <?php if($controller_exists) { ?>
                                <a class="btn btn-primary btn-block" href="<?php echo site_url('paypal/demos/express_checkout_with_billing_agreement');?>">View Demo</a>
                            <?php } else { ?>
                                <a class="btn btn-success btn-block" href="https://www.angelleye.com/product/codeigniter-paypal-integration-express-checkout-billing-agreement-demo" target="_blank">Buy Now</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $controller1 = 'paypal/demos/Express_checkout_with_line_items.php';
                    $controller2 = 'paypal/demos/Express_checkout_digital_goods.php';
                    $controller3 = 'paypal/demos/Express_checkout_with_billing_agreement.php';
                    $controller1_exists = (file_exists(APPPATH."controllers/".$controller1)) ? true : false;
                    $controller2_exists = (file_exists(APPPATH."controllers/".$controller2)) ? true : false;
                    $controller3_exists = (file_exists(APPPATH."controllers/".$controller3)) ? true : false;
                    $panel_class = ($controller1_exists && $controller2_exists && $controller3_exists) ? ' panel-info' : ' panel-default';
                    
                    if(!$controller1_exists || !$controller2_exists || !$controller3_exists) { ?>
                    <div class="panel <?php if(isset($panel_class)) echo $panel_class; ?>">
                        <div class="panel-heading">
                            <h3>Express Checkout</h3>
                            <p>ALL-IN-ONE</p>
                        </div>
                        <div class="panel-body">
                            <p>Learn how to implement digital goods (micro-processing rates) into PayPal Express Checkout. This includes the option for embedded payments.</p>
                                <a class="btn btn-success btn-block" href="https://www.angelleye.com/product/codeigniter-paypal-integration-all-in-one" target="_blank">Buy Now</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>