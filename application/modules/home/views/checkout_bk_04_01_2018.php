

<style>
    .chosen-container chosen-container-single { width:100% !important}
</style>
<div class="category_inner_header">

    <div class="container">

        <div class="category_header_div">

            <h2>Checkout</h2>

        </div>

    </div>

</div>

<!-- ./Home slide -->

<?php
//echo '<pre>';print_R($dataHeader);die; //echo count($dataHeader);die;
if ($discounts['total']['value'] != '') {
    $coupon_code_price = str_replace('US $', ' ', $discounts['total']['value']);
    $this->session->unset_userdata('coupon_code_price');
    $this->session->set_userdata("coupon_code_price", $coupon_code_price);
} else {
    $coupon_code_price = 0;
    $this->session->unset_userdata('coupon_code_price');
    $this->session->set_userdata("coupon_code_price", $coupon_code_price);
}
?>

<section class="cart_div">

    <div class="main-container no-sidebar">

        <div class="container">

            <?php
            echo form_open(base_url()."home/checkout",
                array('id' => 'checkoutfrm'));
            ?>

            <div class="main-content">

                <div class="row">

                    <div class="col-sm-8">



                        <div class="form-checkout">

                            <h5 class="form-title">SHIPPING ADDRESS</h5>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" required name="checkout[shipping][name]" id="checkout_shipping_name" value="<?php
                                        echo (set_value('checkout[shipping][name]'))
                                                ? set_value('checkout[shipping][name]')
                                                : $account_details[0]['shipping_name'];
                                        ?>" placeholder="Name" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[shipping][name]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[shipping][company]" id="checkout_shipping_company" value="<?php
                                        echo (set_value('checkout[shipping][company]'))
                                                ? set_value('checkout[shipping][company]')
                                                : $account_details[0]['shipping_company'];
                                        ?>" placeholder="Company" class="width_200"/></p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[shipping][add_01]" required id="checkout_shipping_add_01" value="<?php
                                        echo (set_value('checkout[shipping][add_01]'))
                                                ? set_value('checkout[shipping][add_01]')
                                                : $account_details[0]['shipping_address_01'];
                                        ?>" placeholder="Address Line 1" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[shipping][add_01]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[shipping][add_02]" id="checkout_shipping_add_02" value="<?php
                                        echo (set_value('checkout[shipping][add_02]'))
                                                ? set_value('checkout[shipping][add_02]')
                                                : $account_details[0]['shipping_address_02'];
                                        ?>" placeholder="Address Line 2" class="width_200"/></p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" required name="checkout[shipping][city]" id="city_name" value="<?php
                                        echo ($this->session->userdata('customer_city')
                                        != '') ? $this->session->userdata('customer_city')
                                                : $account_details[0]['shipping_city'];
                                        ?>" placeholder="City / Town" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[shipping][city]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><?php if (!($this->flexi_cart->shipping_location_name(2))) { ?>

                                            <input type="text" required name="checkout[shipping][state]" id="state_name" value="<?php
                                            echo ($this->session->userdata('customer_state')
                                            != '') ? $this->session->userdata('customer_state')
                                                    : $account_details[0]['shipping_state'];
                                            ?>" placeholder="State" class="width_200"/>

                                        <?php } else { ?>

                                            <?php echo $this->flexi_cart->shipping_location_name(2); ?>

                                            <input type="hidden" required name="checkout[shipping][state]" value="<?php
                                            echo ($this->session->userdata('customer_state')
                                            != '') ? $this->session->userdata('customer_state')
                                                    : $account_details[0]['shipping_state'];
                                            ?>"/>

                                        <?php } ?>

                                        <?php
                                        echo form_error('checkout[shipping][state]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p> <?php if (!($this->flexi_cart->shipping_location_name(3))) { ?>

                                            <input type="text"  required name="checkout[shipping][post_code]" id="cust_zipcode" onfocusout="getShippingInfo()" value="<?php
                                            if ($this->session->userdata('customer_zipcode')
                                                != '') {
                                                echo $this->session->userdata('customer_zipcode');
                                            } elseif ($account_details[0]['shipping_zipcode']
                                                != '' && $account_details[0]['shipping_zipcode']
                                                != 0 && $this->session->userdata('customer_zipcode')
                                                != "") {
                                                echo $account_details[0]['shipping_zipcode'];
                                            } else {
                                                set_value('checkout[shipping][post_code]');
                                            }
                                            ?>" placeholder="Post / Zip Code" class="width_200"/>

                                        <?php } else { ?>

                                            <?php echo $this->flexi_cart->shipping_location_name(3); ?>

                                            <input type="hidden" required name="checkout[shipping][post_code]" value="<?php
                                            echo ($this->session->userdata('customer_zipcode')
                                            != '') ? $this->session->userdata('customer_zipcode')
                                                    : set_value('checkout[shipping][post_code]');
                                            ?>"/>

                                        <?php } ?>

                                        <?php
                                        echo form_error('checkout[shipping][post_code]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>
                                    <div id="message_ship"></div>


                                </div>

                                <div class="col-sm-6">

                                    <p><select id="checkout_billing_country" required name="checkout[shipping][country]" class="width_400">

                                            <option selected value="USA" <?php if ($account_details[0]['shipping_country']
                                            == 'USA') { ?>selected="selected" <?php } ?>> USA </option>
                                            <option value="Mexico" <?php if ($account_details[0]['shipping_country']
                                            == 'Mexico') { ?>selected="selected" <?php } ?>> Mexico </option>



                                        </select>

                                        <?php
                                        echo form_error('checkout[shipping][country]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                            </div>



                        </div>

                        <div class="form-checkout">

                            <h5 class="form-title">BILLING ADDRESS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
                            <h4 class="billing-checkbox">
                                <input type="checkbox" id="copy_billing_details" value="1" class="pull-left"/>
                                <label for="checkbox_1"><strong>Same as shipping address?</strong></label>
                            </h4>






                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[billing][name]" required id="checkout_billing_name" value="<?php
                                        echo (set_value('checkout[billing][name]'))
                                                ? set_value('checkout[billing][name]')
                                                : $account_details[0]['billing_name'];
                                        ?>" placeholder="Name" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[billing][name]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>



                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[billing][company]" id="checkout_billing_company" value="<?php
                                        echo (set_value('checkout[billing][company]'))
                                                ? set_value('checkout[billing][company]')
                                                : $account_details[0]['billing_company'];
                                        ?>" placeholder="Company" class="width_200"/></p>

                                </div>

                            </div>



                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[billing][add_01]" required id="checkout_billing_add_01" value="<?php
                                        echo (set_value('checkout[billing][add_01]'))
                                                ? set_value('checkout[billing][add_01]')
                                                : $account_details[0]['billing_address_01'];
                                        ?>" placeholder="Address Line 1" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[billing][add_01]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[billing][add_02]" id="checkout_billing_add_02" value="<?php
                                        echo (set_value('checkout[billing][add_02]'))
                                                ? set_value('checkout[billing][add_02]')
                                                : $account_details[0]['billing_address_02'];
                                        ?>" placeholder="Address Line 2" class="width_200"/></p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[billing][city]" required id="checkout_billing_city" value="<?php
                                        echo (set_value('checkout[billing][city]'))
                                                ? set_value('checkout[billing][city]')
                                                : $account_details[0]['billing_city'];
                                        ?>" placeholder="City / Town" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[billing][city]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[billing][state]" required id="checkout_billing_state" value="<?php
                                        echo (set_value('checkout[billing][state]'))
                                                ? set_value('checkout[billing][state]')
                                                : $account_details[0]['billing_state'];
                                        ?>" placeholder="State" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[billing][state]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p> <input type="text" name="checkout[billing][post_code]" required id="checkout_billing_post_code" value="<?php
                                        echo (set_value('checkout[billing][post_code]'))
                                                ? set_value('checkout[billing][post_code]')
                                                : $account_details[0]['billing_zipcode'];
                                        ?>" placeholder="Post / Zip Code" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[billing][post_code]',
                                            '<span style="color:red" class="error bill_zipcode_error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><select id="checkout_billing_country" required name="checkout[billing][country]" class="width_400">

                                            <option  value="USA" <?php if ($account_details[0]['billing_country']
                                            == 'USA') { ?>selected="selected" <?php } ?>> USA </option>
                                            <option value="Mexico" <?php if ($account_details[0]['billing_country']
                                            == 'Mexico') { ?>selected="selected" <?php } ?>> Mexico </option>



                                        </select>

                                        <?php
                                        echo form_error('checkout[billing][country]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                            </div>



                        </div>









                        <div class="form-checkout">

                            <h5 class="form-title">CONTACT DETAILS</h5>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" required name="checkout[email]" id="checkout_email" value="<?php
                                        echo (set_value('checkout[email]')) ? set_value('checkout[email]')
                                                : $dataHeader['email'];
                                        ?>" placeholder="Email" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[email]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="checkout[phone]" id="checkout_phone" value="<?php
                                        echo (set_value('checkout[billing][phone]'))
                                                ? set_value('checkout[billing][phone]')
                                                : $dataHeader['phone'];
                                        ?>" placeholder="Phone Number" class="width_200"/>

                                        <?php
                                        echo form_error('checkout[phone]',
                                            '<span style="color:red" class="error">',
                                            '</span>');
                                        ?>

                                    </p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-12">

                                    <p><textarea class="form-control" name="checkout[comments]" id="checkout_comments" placeholder="Comments" rows="2" class="width_400"><?php echo set_value('checkout[comments]'); ?></textarea></p>

                                </div>



                            </div>



                        </div>



                    </div>

                    <div class="col-sm-4">

                        <div class="form-checkout order">

                            <h5 class="form-title">YOUR ORDER</h5>

                            <table class="shop-table order">

                                <thead>

                                    <tr>

                                        <th class="product-name">PRODUCT</th>

                                        <th class="total">TOTAL</th>

                                    </tr>

                                </thead>

                                <tbody>



                                    <?php
                                    $subtotal = 0;

                                    foreach ($cart_items as $sid => $cData) {

                                        $subtotal = $subtotal + (floatval($cData['internal_price'])
                                            * floatval($cData['quantity']));
                                        ?>


                                        <tr>

                                            <td class="product-name">

                                                <a href="<?php echo base_url().'home/shop_product/'.$cData['id'].'/' ?>" class="h5"><?php echo $cData['name'] ?>
                                                    <?php
                                                    if (($cData['quantity']) > $cData['item_stock'][0]['quantity']
                                                        && $cData['options']['Prebook']
                                                        == 'true') {
                                                        echo '<p style="color:green">Pre Order<p>';
                                                    }
                                                    if ($cData['options']['Initial']
                                                        != '' && $cData['options']['Color']
                                                        != '')
                                                            echo "<br>(Inicial - ".$cData['options']['Initial']." Color - ".$cData['options']['Color'].")";
                                                    ?>
                                                    <?php
                                                    if ($cData['options']['variant']
                                                        != '' && $cData['options']['variant']
                                                        != '')
                                                            echo "<br>".$cData['options']['variant'];
//                                                    foreach($cData['options'] as $key =>$value){
//                                                        if($key != 'Initial' && $key !='Color' && $key!='Prebook')
//                                                            echo "<br>".$key ." - ".$value;
//                                                    }
                                                    //echo ($cData['options']['Prebook'] == 'true') ? '<p style="color:green">Pre Order<p>' : ''
                                                    ?>
                                                </a>

                                                <p class="text-success"><?php
                                                echo $cData['stock_quantity'] > 1
                                                        ? 'In Stock' : ''
                                                ?></p>


                                                                                                                                                                                        <!--<span>Status: </span>-->

                                                                                                                                                                                        <!--<strong class="text-success">In Stock</strong>-->

                                            </td>



                                            <td class="total"><strong>$<?php
                                                echo (floatval($cData['internal_price'])
                                                * floatval($cData['quantity']))
                                                ?> </strong></td>



                                        </tr>

<?php } ?>

                                    <tr>

                                        <td class="subtotal">Subtotal</td>

                                        <td class="total"><strong>$<?php echo $subtotal; ?></strong></td>

                                    </tr>

                                    <tr>
                                        <td>Delivery charges<span class="text-danger"></span></td>
                                        <td class="text-right">
                                            <?php
                                            if (!empty($custom_option['shipping_total'])
                                                && $custom_option['shipping_total']
                                                != '0') {
                                                echo "<strong id='shippingRateFromUps'>$".$custom_option['shipping_total']."</strong>";
                                            } else {
                                                echo "<strong><span  id='shippingRateFromUps' >Free</span></strong>";
                                            }


//                                    echo!empty($cart_summary['item_summary_total'])
//                                    ? $cart_summary['item_summary_total']-str_replace('US $', ' ', $discounts['total']['value']) : '0'
                                            ?> </td>
                                    </tr>
                                    <tr>
                                        <td>Tax<span class="text-danger"></span></td>
                                        <td class="text-right"><?php
                                            if (!empty($custom_option['tax_total'])
                                                && $custom_option['tax_total'] != '0') {
                                                echo "<strong id='TaxRate'>$".$custom_option['tax_total']."</strong>";
                                            } else {
                                                echo "<strong><span id='TaxRate'>$0.00</span></strong>";
                                            }


//                                    echo!empty($cart_summary['item_summary_total'])
//                                    ? $cart_summary['item_summary_total']-str_replace('US $', ' ', $discounts['total']['value']) : '0'
                                            ?> </td>
                                    </tr>

<!--                                    <tr>

                                        <td class="subtotal">Shipping</td>

                                        <td class="total">Internaltional</td>

                                    </tr>-->

<?php foreach ($discounts as $discount) { ?>

                                        <tr>

                                            <td class="subtotal">Coupon Discount</td>







                                            <td colspan="2" class="total"><b>- $<?php
    echo str_replace('US $', ' ', $discount['value']);
    ?></b></td>







                                        </tr>

<?php } ?>





                                    <tr class="order-total">

                                        <td class="subtotal">ORDER TOTAL</td>
                                <input type="hidden" id="summary_total_val" value="">
                                <td class="total"><span class="price" id="summary_total">$<?php
//                                                print_r($cart_summary);die;
                                        if (!empty($cart_summary['item_summary_total'])) {

                                            if (!empty($discounts['total']['value'])) {

                                                echo ($cart_summary['item_summary_total']
                                                + $custom_option['shipping_total']
                                                + $custom_option['tax_total']) - str_replace('US $',
                                                    ' ',
                                                    $discounts['total']['value']);
                                            } else {
                                                echo $cart_summary['item_summary_total']
                                                + $custom_option['shipping_total']
                                                + $custom_option['tax_total'];
                                            }
                                        }
                                        ?></span></td>

                                </tr>
                                </tbody>

                            </table>

                            <button type="submit" class="button btn-primary medium proceed_checkout">PROCEED TO PAYMENT DETAILS</button>

                        </div>

                        <div class="form-checkout checkout-payment box-coupon" style="padding-bottom: 10px">

                            <h5 class="form-title">NEWSLETTER</h5>

                            <div class="checkbox">
                                <label>
                                    <input id="newslettercheckbox" <?php
                                        if (count($dataHeader) > 0 && $dataHeader['newsletter_suscriber']
                                            == '1' && count($arr_users_subscriber)
                                            > 0) {
                                            ?> checked="checked" <?php } ?> name="newslettercheckbox" type="checkbox"> Get latest updates of our products.
                                </label>
                            </div>
                        </div>



                        <!--                        <div class="form-checkout checkout-payment">

                                                    <h5 class="form-title">YOUR PAYMENT</h5>

                        <?php
//                            echo form_error('payment_method',
//                                '<span style="color:red" class="error">',
//                                '</span>');
                        ?>

                                                    <div class="payment_methods">

                                                        <div class="payment_method margin-bottom-10">

                                                            <label><input name="payment_method" type="radio" value="1">PAY WITH DEBIT / CREDIT CARD</label>

                                                            <div class="payment_box">

                                                                Nulla laoreet ipsum dignissim magna maximus, vitae euismod turpis iaculis. Sed phare tra lacus sit amet dui consequat dignissim bibendum ullamcorper sem.

                                                            </div>

                                                        </div>

                                                        <div class="payment_method margin-bottom-10">

                                                            <img style="width: 50%" onclick="submitPaypalPayment()" src="http://www.dermitech.com/image/PayPal-PayNow-Button.png">
                                                            <div style="display:none" id="paypal-button"></div>
                                                            <div class="payment_box">

                                                                Nulla laoreet ipsum dignissim magna maximus, vitae euismod turpis iaculis. Sed phare tra lacus sit amet dui consequat dignissim bibendum ullamcorper sem.

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>-->

                    </div>

                </div>

            </div>

<?php echo form_close(); ?>

        </div>

    </div>

</section>



<script>
//$('.proceed_checkout').prop('disabled', true);
    $(function ()

    {

        // Toggle show/hide cart session array

        $('#copy_billing_details').click(function ()

        {

            $('input[name^="checkout[shipping]"]').each(function ()

            {

                // Target textboxes only, no hidden fields

                if ($(this).attr('type') == 'text')

                {

                    var name = $(this).attr('name').replace('shipping', 'billing');

                    var value = ($('#copy_billing_details').is(':checked')) ? $(this).val() : '';



                    $('input[name="' + name + '"]').val(value);

                }

            });



        });

    });



//    function validateStock() {
//
//        $(".proceed_checkout").html('Processing <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
//        $(".proceed_checkout").prop('disabled', true);
//        $.ajax({
//            url: base_url + 'home/home/validateStock',
//            type: 'POST',
//            dataType: 'JSON',
//            success: function (response) {
//                if (response.status === '1') {
//                    $("#stockStatus").html('<div class="alert alert-danger">' + response.msg + '</div>');
//                    $(".proceed_checkout").html('PROCEED TO CHECKOUT');
//                    $(".proceed_checkout").prop('disabled', false);
//                    $(window).scrollTop(0);
//                    return false;
//                } else {
//                    return true;
//                }
//            },
//            error: function (error) {
//                console.log(error);
//
//            }
//
//
//        });
//    }
//$( document ).ready(function() {
//    $('#newslettercheckbox').click(function() {
//    if($(this).not(':checked'))
//        alert('unchecked');
//    else{
//        alert('checked');
//    }
//});
//});

    $(document).ready(function () {
        var id = '';
        $("#newslettercheckbox").click(function () {
            var checked = $(this).is(':checked');
            if (checked) {
                document.getElementById("newslettercheckbox").checked = true;
                id = 1;

                //alert('checked');
            } else {
                document.getElementById("newslettercheckbox").checked = false;
                id = 0;
                // alert('unchecked');
            }

            $.ajax({
                url: '<?php echo base_url(); ?>' + 'home/Home/updateNewsletterSubscriber',
                async: false,
                type: "POST",
                data: {
                    id: id,
                },
                dataType: "html",
                success: function (dataCurrent) {

                }
            });

        });
    });
    //$("#cust_zipcode").keyup(function(){
    //$('.proceed_checkout').prop('disabled', true);
    //});


    

    function getShippingInfo() {
        var cust_zipcode = $("#cust_zipcode").val();
//        if (cust_zipcode === '') {
//            return false;
//        }
        $.ajax({

            url: base_url + 'admin/ups/getRates',

            data: {cust_zipcode: cust_zipcode},

            type: 'POST',

            dataType: 'JSON',

            success: function (response) {

                if (response.status === '1') {
                    //$('.proceed_checkout').prop('disabled', false);
                    $("#shippingRateFromUps").html(response.data);
                    $("#TaxRate").html("$" + response.tax);
                    $("#summary_total").html(response.total);


                    $("#message_ship").html('<p style="color:green">' + response.msg + '</p>');
                    $("#city_name").val(response.city_name);
                    $("#state_name").val(response.state_name);


                } else {

                    $("#message_ship").html('<p style="color:red">' + response.data + '</p>');
                    $("#cust_zipcode").val("")

                }

            },

            error: function (error) {

                console.log(error);

            }

        });

    }

</script>
<?php if ($account_details[0]['billing_zipcode'] != '') { ?>
    <script>
        getShippingInfo();
    </script>
<?php } ?>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script> 
<script type="text/javascript">
$(document).ready(function () {
  $("#checkoutfrm").validate({
      rules: {
          'checkout[shipping][name]': "required",
      }

  });
});


$(function () {
//alert('Document is ready');

        $('#checkout_billing_post_code').keyup(function () {
            if ($("#checkout_billing_post_code").val().length > 4) {

                $.ajax({

                    url: base_url + 'admin/ups/getRates',

                    data: {cust_zipcode: cust_zipcode},

                    type: 'POST',

                    dataType: 'JSON',

                    success: function (response) {

                        if (response.status === '0') {
                            $("#bill_zipcode_error").html(response.data);
                        }

                    },

                    error: function (error) {

                        console.log(error);

                    }

                });
            }
        });
    }); //END document.ready
</script> 