<div class="category_inner_header">

    <div class="container">

        <div class="category_header_div">

            <h2>Shopping Cart</h2>

        </div>

    </div>

</div>

<!-- ./Home slide -->



<section class="cart_div">

    <div class="main-container no-sidebar">

        <div class="container">

            <div class="main-content">
                <?php
                if (isset($cart_items) && !empty($cart_items)) {
                    if ($this->session->flashdata('stock_error')) {
                        echo '<div class="alert alert-danger">' . $this->session->flashdata('stock_error') . '</div>';
                    }
                    if ($this->session->flashdata('stock_error1')) {
//                        echo "<pre>";
                         echo '<div class="alert alert-danger">' . $this->session->flashdata('stock_error1'). '</div>';
//                        die;
//                        foreach ($this->session->flashdata('stock_error1') as $val) {
//                            if ($val['quantity_available'] < 1) {
//                                echo "<span style='color:red'>Only " . $val['quantity_available'] . " " . $val['name'] . " are available</strong></span>";
//                            }
//                        }
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <?php
                            echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
                            ?>

                            <div class="responsive-content">

                                <table class="shop_table cart">

                                    <thead>

                                        <tr>

                                            <th width="100"></th>

                                            <th>Product Name</th>

                                            <th width="75">Quantity</th>

                                            <th class="text-center" width="100">Unit Price</th>

                                            <th class="text-center" width="100">Total</th>

                                            <th width="50"></th>

                                        </tr>

                                    </thead>

                                    <tbody>




                                        <?php
                                        //echo '<pre>';print_r($cart_items);die;
                                        $prebook = array();
                                        $avail = array();
                                        foreach ($cart_items as $sid => $cData) {

                                            if ($cData['options']['Prebook'] == 'true') {
                                                array_push($prebook, 'prebook');
                                            }
                                            if ($cData['options']['Prebook'] == '') {
                                                array_push($avail, 'avail');
                                            }
                                            ?>

                                            <tr>

                                                <td>

                                                    <img class="img-responsive" src="<?php echo ($cData['item_url'] != '') ? base_url() . $cData['item_url'] : base_url() . "assets/images/product-no-image2.jpg"; ?>"> 

                                                </td>

                                                <td>

                                                    <a href="<?php echo base_url() . 'home/shop_product/' . $cData['id'] . '/' ?>" class="h5"><?php echo $cData['name'] ?>
                                                        <?php if ($cData['options']['Initial'] != '' && $cData['options']['Color'] != '') echo "<br>(Inicial - " . $cData['options']['Initial'] . " Color - " . $cData['options']['Color'] . ")"; ?>
                                                    </a>
                                                                                                                                                                                                        <br>                                                                                                                                                    <!--<span>Status: </span>-->
                                                    <?php
                                                    if (($cData['quantity']) > $cData['item_stock'][0]['quantity'] && $cData['options']['Prebook'] == 'true') {
                                                        echo '<p style="color:green">Pre Order<p>';
                                                    }
                                                    //echo ($cData['options']['Prebook'] == 'true') ? '<p style="color:green">Pre Order<p>' : '' 
                                                    ?>
                                                    <?php
                                                    if ($cData['item_stock'][0]['quantity'] < 1 || ($cData['quantity']) > $cData['item_stock'][0]['quantity']) {
                                                        echo "<span style='color:red'>Out Of Stock </span>";
                                                        if($cData['item_stock'][0]['quantity'] > 0){ echo "<span style='color:red'>(".$cData['item_stock'][0]['quantity']." item available)";}"</span>";
                                                    } else {
                                                        echo "<span style='color:green'>In Stock</span>";
                                                    }
                                                    ?>
                                                                                                                                                                                                                <!--<strong class="text-success">In Stock</strong>-->

                                                </td>

                                                <td class="text-center">

                                                    <input type="number" name="quantity_<?php echo $cData['id']; ?>" class="form-control" id="" value="<?php echo $cData['quantity'] ?>" min="1" required="">

                                                    <input hidden value="<?php echo $sid; ?>" id="session_id" name="session_id_<?php echo $cData['id']; ?>">

                                                    <input hidden value="<?php echo $cData['id']; ?>" id="item_id" name="item_id[]" >

                                                </td>

                                                <td class="text-center"><strong>$<?php echo $cData['internal_price'] ?></strong></td>

                                                <td class="text-center"><strong>$<?php echo (floatval($cData['internal_price']) * floatval($cData['quantity'])) ?> </strong></td>



                                                <td>







                                                    <button type="button" id="delBtn<?php echo $sid; ?>" class="btn btn-solid btn-sm" onclick="funDeleteCartProduct('<?php echo $sid; ?>',<?php echo $cData['id']; ?>);">

                                                        <i class="fa fa-trash-o"></i>

                                                    </button>



                                                </td>

                                            </tr>





                                        <?php } ?>

                                        <?php foreach ($discounts as $discount) { ?>



                                            <tr>

                                                <td colspan="3">



                                                    &raquo; <?php echo $discount['description']; ?>

                                                </td>

                                                <td colspan="2"><b><?php echo $discount['value']; ?></b></td>

                                                <td>

                                                    <?php if (!empty($discount['id'])) { ?>

                                                        <a class="btn btn-line btn-sm" href="<?php echo base_url(); ?>standard_library/unset_discount/<?php echo $discount['id']; ?>"><i class="fa fa-trash-o"></i></a>

                                                    <?php } ?>



                                                </td>



                                            </tr>

                                        <?php } ?>

                                    </tbody>

                                </table>
                            </div>



                            <a href="<?php echo base_url() ?>home/clear_cart_all" class="pull-right btn btn-xs btn-solid" title="Empty | Clear your cart" ><i class="fa fa-shopping-cart"> </i> Empty </a>



                            <button  type="submit" class="pull-right btn btn-xs btn-line" title="Update" ><i class="fa fa-shopping-cart"> </i> Update Cart </button>

                            <br><br>  

                            <?php
                            $message = $this->session->flashdata('cart_update_msg');

                            if (!empty($message)) {
                                ?>

                                <div id="message">

                                    <?php echo $message; ?>

                                </div>

                            <?php } ?>




                            <!--                                <div class="coupon">

                                                                <h3 class="coupon-box-title">Coupon</h3>

                                                                <div class="inner-box">

                                                                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Coupon code">

                                                                    <input type="submit" class="button apply_coupon" name="apply_coupon" value="Apply Coupon">

                                                                </div>

                                                            </div>-->









                            <?php
                            echo form_close();
                            if (count($prebook) > 0 && count($avail) > 0) {
                                echo "<p style='color:red'>Since one of the items in your shopping cart is not available in stock, please create two separate orders as they will ship separately.</p>";
                            }
                            ?>



                            <?php echo form_open('standard_library/view_cart'); ?>

                            <?php ?>
                            <div id="message_ship"></div>
                            <div><lable>Postal Code</lable>
                                <input value="<?php echo ($this->session->userdata('customer_zipcode') != '') ? $this->session->userdata('customer_zipcode') : "" ?>" type="text" id="cust_zipcode">
                                <button type="button"  class="btn btn-default bt-xs pincode-button" id="getShippingInfo">Check</button>
                            </div>
                            <hr>



                                                                                                                                                                                                                                                                                                                                                                                                                    <!--							<small>Examples: 'FREE-UK-SHIPPING', '10-PERCENT', '10-FIXED-RATE'</small>-->

                            <?php if ($dataHeader['id'] > 0) { ?>

                                <div class="box-coupon">

                                    <h3 class="coupon-box-title">APPLY YOUR DISCOUNT HERE</h3>

                                    <div class="inner-box">
                                        <?php
                                        $message = $this->session->userdata('message');
                                        if ($message != '') {
                                            ?>
                                            <small style="color:red;">
                                                <?php
                                                echo $message;
                                                $this->session->unset_userdata('message');
                                                ?>
                                            </small>
                                            <?php
                                        }
                                        // Get an array of all discount codes. The returned array keys are 'id', 'code' and 'description'.

                                        if ($discount_data = $this->flexi_cart->discount_codes()) {

                                            foreach ($discount_data as $discount_codes) {
                                                ?>

                                                <div class="row">

                                                    <div class="col-sm-6">
                                                        <input type="text" class="input-text" name="discount[<?php echo $discount_codes['code']; ?>]" value="<?php echo $discount_codes['code']; ?>"/> 

                                                        <small class="inline">* <?php echo $discount_codes['description']; ?></small>

                                                    </div>

                                                    <div class="col-sm-2">

                                                        <button  type="submit" name="update_discount" value="Update" class="button apply_coupon">Update</button>

                                                    </div>

                                                    <div class="col-sm-2">

                                                        <button type="submit" name="remove_discount_code[<?php echo $discount_codes['code']; ?>]" value="" class="button apply_coupon"><i class="fa fa-trash"></i></button>

                                                    </div>

                                                </div>

                                                <hr>

                                                <?php
                                            }
                                        }

                                        $coupon_name = $this->session->userdata('coupon_name');
                                        if ($coupon_name == '' && count($discount_data) < 1) {
                                            ?>



                                            <div class="">

                                                <div class="col-sm-4 no-padding">

                                                    <input type="text" name="discount[0]" class="input-text" value=""/>

                                                </div>

                                                <div class="col-sm-4 no-padding">

                                                    <input type="submit" class="button apply_coupon"  name="update_discount" value="Add Coupon Code">

                                                </div>

                                                <!--                                                <div class="col-sm-4 no-padding">
                                                
                                                                                                    <input  type="submit" name="remove_all_discounts" class="button apply_coupon left-margin" title="Remove all discount codes and all manually set discounts." value="Remove all Coupons">
                                                
                                                                                                </div>-->

                                            </div> 
                                        <?php } else {
                                            ?>
                                            <?php
                                            $message = $this->session->userdata('message');
                                            ?>
                                            <?php if ($message != '') { ?>
                                                <small style="color:red;">
                                                    <?php
                                                    echo $message;
                                                    $this->session->unset_userdata('message');
                                                    ?>
                                                </small>
                                            <?php } ?>

                                            <?php if (count($discount_data) < 1) { ?>  
                                                <div class="">

                                                    <div class="col-sm-4 no-padding">

                                                        <input type="text" name="discount[0]" class="input-text" value=""/>

                                                    </div>

                                                    <div class="col-sm-4 no-padding">

                                                        <input type="submit" class="button apply_coupon"  name="update_discount" value="Add Coupon Code">

                                                    </div>

                                                    <div class="col-sm-4 no-padding">

                                                        <input  type="submit" name="remove_all_discounts" class="button apply_coupon left-margin" title="Remove all discount codes and all manually set discounts." value="Remove all Coupons">

                                                    </div>

                                                </div> 
                                            <?php }
                                        } ?>

                                    </div>

                                </div>
                            <?php } ?>

                            <?php echo form_close();
                            ?>



                        </div>



                        <div class="col-sm-12 col-md-4">

                            <div class="box-cart-total">

                                <h2 class="title">Cart Totals</h2>

                                <table>

                                    <tr>

                                        <td>Subtotal</td>

                                        <td><span class="price">$<?php
//                                        echo "<pre>";print_r($cart_summary);die;
                                                if (!empty($cart_summary['item_summary_total'])) {
                                                    echo number_format($cart_summary['item_summary_total'], 2);
                                                } else {

                                                    echo "0.00";
                                                }
                                                ?></span></td>

                                    </tr>
                                    <?php
//                                     print_r($discounts);die;
                                    if (!empty($discounts) && $discounts['total']['value'] != 0 && $discounts['total']['value'] != '') {
                                        ?>
                                        <tr>

                                            <td>Subtotal</td>

                                            <td><span class="price">$<?php
                                                    if (!empty($discounts['total']['value'])) {

                                                        echo number_format($cart_summary['item_summary_total'], 2);
                                                    } else {

                                                        echo number_format($cart_summary['item_summary_total'], 2);
                                                    }
                                                    ?></span></td>

                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($discounts['total']['value'])) { ?>
                                        <tr>

                                            <td>Discount</td>

                                            <td><span class="price">$<span id=""><?php echo str_replace('US $', ' ', $discounts['total']['value']); ?></span>

                                                </span></td>

                                        </tr>
                                    <?php } ?>
                                    <tr>

                                        <td>Delivery Charges</td>

                                        <td><span class="price"><?php
                                                if (!empty($cart_summary['item_summary_total']) && $cart_summary['item_summary_total'] >= 250) {

                                                    echo "<span style='color:green'>Free</span>";
                                                } else {

                                                    echo '<span id="shippingRateFromUps">';
                                                    echo ($custom_option['shipping_total'] != '') ? "$" . number_format($custom_option['shipping_total'], 2) : '';
                                                    echo '</span>';
                                                }
                                                ?></span></td>

                                    </tr>
                                    <tr>

                                        <td>Tax</td>

                                        <td><span class="price">$<span id="TaxRate"><?php echo ($custom_option['tax_total'] != 0) ? number_format($custom_option['tax_total'], 2) : '0.00'; ?></span>

                                            </span></td>

                                    </tr>


                                    <tr class="order-total">

                                        <td>Total</td>

                                        <td><span id="summary_total" class="price">$<?php
                                                if (!empty($cart_summary['item_summary_total'])) {

                                                    if (!empty($discounts['total']['value'])) {

                                                        echo number_format(($cart_summary['item_summary_total'] - str_replace('US $', ' ', $discounts['total']['value'])) + $custom_option['tax_total'] + $custom_option['shipping_total'], 2);
                                                    } else {

                                                        echo number_format($cart_summary['item_summary_total'] + $custom_option['tax_total'] + $custom_option['shipping_total'], 2);
                                                    }
                                                } else {

                                                    echo "$0.00";
                                                }
                                                ?></span></td>

                                    </tr>

                                </table>

                                <a href="<?php echo base_url() ?>home/category/1" class="button medium update_btn">Continue Shopping</a>



                                <?php if ($this->ion_auth->logged_in() && !empty($cart_summary['total_items'])) { ?>

                                    <a href="<?php echo base_url(); ?>home/checkout" class="button btn-primary medium checkout-button checkout_btn">Checkout</a>

                                <?php } else if ($dataHeader['id'] == '') {
                                    ?>

                                    <a class="button btn-primary medium checkout-button checkout_btn" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#myModal">PROCEED TO CHECKOUT</a>

                                <?php } ?>



                            </div>

                        </div>






                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center row">

                            <p><i class="fa fa-5x fa-shopping-cart text-danger"></i></p>

                            <p>Your cart is empty</p>

                        </div>
                    </div>

                <?php } ?>
            </div>

        </div>


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <button type="button" class="mobalclose-btn" data-dismiss="modal" aria-hidden="true">x</button>

                    <div class="modal-body">
                        <div class="col-md-6">
                            <img class="img-login-page" src="<?php echo base_url() ?>assets/images/loginimage.jpg"/>
                        </div>
                        <div class="col-md-6 login_form_div">

                            <form id="loginForm" method="post">
                                <h3 class="modal-title-head">Login</h3>
                                <p class="form-row form-row-wide">

                                    <input type="text" name="username" required class="input-text" id="email1" placeholder="User Name" />
                                </p>

                                <p class="form-row form-row-wide">

                                    <input type="password" name="password" required class="input-text" id="exampleInputPassword1" placeholder="Password" />
                                </p>

                                <p class="form-row">
                                    <input type="submit" class="button" name="login" value="Login">

                                    <!--a href="javascript:;" style="padding: 8px 0">Forgot your password?</a-->

                                <div style="clear: both"></div>

                                Don't have an account
                                <a style="padding: 8px 0" id="show-signup-div" href="javascript:;"> Sign Up</a>
                                </p>

                                <?php if (isset($authUrl_g))  ?>
                                <a id="btn-fblogin" href="<?= $authUrl ?>" class="btn btn-primary"><i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook</a><span> <b>OR</b></span>
                                <a id="btn-google" href="<?php echo $authUrl_g ?>" class="btn btn-danger"><i class="fa fa-google-plus" aria-hidden="true"></i> Login with Google</a>

                            </form>

                            <div style="clear: both"></div>

                            <form role="form" id="signupForm" class="signupForm1">

                                <h3 class="modal-title-head">Register</h3>

                                <p class="form-row form-row-wide">

                                    <input type="text" required name="first_name" class="input-text" id="email" placeholder="First Name" />
                                </p>

                                <p class="form-row form-row-wide">

                                    <input type="text" required name="last_name" class="input-text" id="email" placeholder="Last Name" />
                                </p>

                                <p class="form-row form-row-wide">

                                    <input type="email" name="email" required class="input-text" id="email" placeholder="Email" />

                                </p>

                                <p class="form-row form-row-wide">

                                    <input type="text" name="phone" required class="input-text" id="mobile" placeholder="Mobile" />



                                </p>

                                <p class="form-row form-row-wide">
                                    <input type="password" name="password" required class="input-text" id="password" placeholder="Password" />
                                </p>

                                <p class="form-row form-row-wide">
                                    <input type="password" name="password_confirm" class="input-text" id="password" placeholder="Confirm Password" />

                                </p>

                                <div class="row" style="margin-bottom: 10px">

                                    <div class="col-md-6">

                                        <input type="submit" class="button" name="login" value="Register">

                                    </div>

                                    <div class="col-md-6">

                                        <input type="submit" class="button" name="login" value="Cancel" data-dismiss="modal" aria-hidden="true">


                                    </div>
                                </div>

                                Back to
                                <a id="show-login-div" href="javascript:;"> Login</a>

                            </form>

                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>
        </div>



    </div>

</section>

<!-- main content -->

<script type="text/javascript">

    function funDeleteCartProduct(itemId, product_id) {

        //    var itemId = $(this).find('#item_session_id').val();

//        var itemId = $(this).closest('tbody tr input').next('').val();
        $("#delBtn" + itemId).html("<i class='fa fa-spinner fa-spin'></i>");
        $.ajax(
                {

                    method: "POST",

                    data: {'item_id': itemId, 'original_pr_id': product_id},

                    url: href = "<?php echo base_url(); ?>standard_library/delete_item/" + itemId + "/" + product_id,

                    success: function (data)

                    {
                        $("#delBtn" + itemId).html("<i class='fa fa-trash-o'></i>");
                        $.toaster({priority: 'success', title: 'Cart', message: 'Item Remove from cart.'});

                        window.location.reload();



                    }

                }

        );

    }



    $(document).ready(function () {

        $("#loginForm").submit(function (e) {

            e.preventDefault();

            var datastring = $("#loginForm").serialize();

            $.ajax({

                url: base_url + 'auth/auth/ajaxLoginSubmit',

                data: datastring,

                type: 'POST',

                dataType: 'JSON',

                success: function (response) {

                    if (response.status === '1') {

                        $.toaster({priority: 'success', title: 'Cart', message: response.msg});

                        window.setTimeout(function () {

                            location.reload()

                        }, 3000);

                    } else {

                        $.toaster({priority: 'danger', title: 'Fail', message: response.msg});

                    }

                },

                error: function (error) {

                    console.log(error);

                }

            });

        });

    });

    $(document).ready(function () {

        $("#signupForm").submit(function (e) {

            e.preventDefault();

            var datastring = $("#signupForm").serialize();

            $.ajax({

                url: base_url + 'auth/auth/ajaxUserRegisterSubmit',

                data: datastring,

                type: 'POST',

                dataType: 'JSON',

                success: function (response) {

                    if (response.status === '1') {

                        $("#st_message").html('<div class="alert alert-success"><strong>Success! </strong>' + response.msg + '</div>');

                        window.setTimeout(function () {

                            location.reload()

                        }, 3000);

                    } else {

                        $("#st_message").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.msg + '</div>');

                    }

                },

                error: function (error) {

                    console.log(error);

                }

            });

        });

        $("#getShippingInfo").click(function (e) {

            e.preventDefault();

            var cust_zipcode = $("#cust_zipcode").val();
            if (cust_zipcode === '') {
                $("#message_ship").html('<p style="color:red">Please enter post code</p>');
                return false;
            }
            $(this).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({

                url: base_url + 'admin/ups/getRates',

                data: {cust_zipcode: cust_zipcode},

                type: 'POST',

                dataType: 'JSON',

                success: function (response) {
                    $("#getShippingInfo").html('Check');
                    if (response.status === '1') {
                        $("#shippingRateFromUps").html(response.data);
                        $("#TaxRate").html(response.tax);
                        $("#summary_total").html(response.total);
                        $("#message_ship").html('<p style="color:#0ac723">' + response.msg + '</p>');


                    } else {

                        $("#message_ship").html('<p style="color:red">' + response.data + '</p>');

                    }

                },

                error: function (error) {

                    console.log(error);

                }

            });

        });





    });

</script>



