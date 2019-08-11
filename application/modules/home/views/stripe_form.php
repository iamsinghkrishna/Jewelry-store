<?php // echo "<pre>"; print_r($custom_option);die;            ?>
<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

            <h2>Payment Details</h2>

        </div>
    </div>
</div>
<!-- ./Home slide -->

<section class="cart_div">
    <div class="main-container no-sidebar">
        <div class="container">
            <div class="main-content">
                <div class="row">
                    <form id="paymentDetailsForm" role="form" action="" method="post"  class="">                        <div class="col-sm-8 form-checkout">
                            <span id="paystatus"></span>
                            <h5 class="form-title">ENTER PAYMENT DETAILS</h5>
                            <div class="col-md-6 form-group creaditCardInfo no-padding-left">
                                <label>Card Number</label>
                                <input name="credit_number" required id="credit_number" class="form-control"  size="20" data-stripe="number" required="required" type="number" onkeydown="return isNumberKey(event);" placeholder="Card Number">
                            </div>
                            <div class="col-md-6 form-group securityCode creaditCardInfo">
                                <label>Security Code 
                                    <span data-toggle="popover" data-trigger="hover" data-html="true" title="CVV" data-content="
                                          <p>Your card code is a 3 or 4 digit number that is found in these locations:</p>
                                          <div class='clearfix'>
                                          <div class='contents'>
                                          <p><strong>Visa/Mastercard</strong></p>
                                          <p>The security code is a 3 digit number on the back of your credit card. It immediately follows your main card number.</p>
                                          <p><strong>American Express</strong></p>
                                          <p>The security code is a 4 digit number on the front of your card, just above and to the right of your main card number.</p>
                                          </div>
                                          <div class='imgBlock'>
                                          <img src='<?php echo base_url() ?>assets/images/cvv.png' class=''>
                                          </div>
                                          </div>
                                          ">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                </label>
                                <input name="security_code" required class="form-control" id="cvc" required="required" type="text" data-stripe="cvc" onkeydown="return isNumberKey(event);" placeholder="Security Code">
                            </div>
                            <div class="form-group creaditCardInfo">
                                <label>Expiration Date</label>                                                      <div style="clear:both"></div>
                                <div class="col-md-6 form-group no-padding-left">
                                    <select name="exp_month" data-stripe="exp_month"  required id="exp_month">  
                                        <?php
                                        $months = array();
                                        for ($x = 1; $x <= 12; $x++) {
                                            $x          = str_pad($x, 2, '0',
                                                STR_PAD_LEFT);
                                            $months[$x] = date("F",
                                                    mktime(0, 0, 0, $x, 10))." ($x)";
                                            echo '<option value="'.$x.'">'.$x.'</option>';
                                        }
                                        ?>


                                    </select>
                                </div>  

                                <div class="col-md-6 form-group">
                                    <select required data-stripe="exp_year" name="exp_year"  id="exp_year"> 
                                        <?php
                                        $years   = array();
                                        $curYear = date("y");
                                        $limit   = 10;
                                        $j       = 0;
                                        for ($x = $curYear; $x < $curYear + $limit; $x++) {
                                            echo '<option value="'.$x.'">'.$x.'</option>';
                                            $j++;
                                        }
                                        ?>


                                    </select>   
                                </div>


                            </div>  
                            <div style="clear:both"></div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input required type="checkbox" name="terms" checked> I accept <a href="" target="_blank">terms and conditions</a>
                                    </label>
                                </div>

                            </div>                                              
                            <div class="form-group">    
                                <a class="btn kopaBtn paypal-btn" style="display:none" href="<?php echo base_url().'home/buy/'; ?>">Place Order</a> 
                                <button type="submit" id="submitPayment" class="button btn-primary medium proceed_checkout" >Place Order</button>                                <img  src="<?php echo base_url(); ?>assets/images/xloading.gif" style="display:none;" id="img_loader"/>                                                            </div>                                                          <style>                     .checkbox label, .radio label {                         padding-left: 6px;                      }                                               .form-checkout input[type="text"], .form-checkout input[type="number"] {                            width: 100%;                            height: 40px;                           box-shadow: none;                           border-radius: 0;                       }                       </style>

                            <div class="form-group text-center" style="padding-top: 1px;">

                                <div class="or-seperator">
                                    <div class="bg-or">
                                        or
                                    </div>
                                </div>

                                <h4>
                                    Click the button to sign into your paypal account and pay securely.
                                </h4>

                                <span id="paypal-button">                                  
                                </span>
                                <img src="<?php echo base_url() ?>assets/images/paypal-buttons-au.png">
                                <!--p>The safer, easier way to pay</p-->
                            </div>
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
                                                    echo $cart_summary['item_summary_total'];
                                                } else {

                                                    echo "0.00";
                                                }
                                                ?></span></td>

                                    </tr>
                                    <?php
//                                     print_r($discounts);die;
                                    if (!empty($discounts) && $discounts['total']['value']
                                        != 0 && $discounts['total']['value'] != '') {
                                        ?>
                                        <tr>

                                            <td>Subtotal</td>

                                            <td><span class="price">$<?php
                                                    if (!empty($discounts['total']['value'])) {

                                                        echo $cart_summary['item_summary_total'];
                                                    } else {

                                                        echo $cart_summary['item_summary_total'];
                                                    }
                                                    ?></span></td>

                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($discounts['total']['value'])) { ?>
                                        <tr>

                                            <td>Discount</td>

                                            <td><span class="price">$<span id=""><?php
                                                        echo str_replace('US $',
                                                            ' ',
                                                            $discounts['total']['value']);
                                                        ?></span>

                                                </span></td>

                                        </tr>
                                    <?php } ?>
                                    <tr>

                                        <td>Delivery Charges</td>

                                        <td><span class="price"><?php
                                                if (!empty($cart_summary['item_summary_total'])
                                                    && $cart_summary['item_summary_total']
                                                    >= 250) {

                                                    echo "<span style='color:green'>Free</span>";
                                                } else {

                                                    echo '<span id="shippingRateFromUps">';
                                                    echo ($custom_option['shipping_total']
                                                    != '') ? "$".$custom_option['shipping_total']
                                                            : '';
                                                    echo '</span>';
                                                }
                                                ?></span></td>

                                    </tr>
                                    <tr>

                                        <td>Tax</td>

                                        <td><span class="price">$<span id="TaxRate"><?php
                                                    echo ($custom_option['tax_total']
                                                    != 0) ? $custom_option['tax_total']
                                                            : '0.00';
                                                    ?></span>

                                            </span></td>

                                    </tr>


                                    <tr class="order-total">

                                        <td class="subtotal">ORDER TOTAL</td>

                                        <td class="total"><span class="price" id="summary_total">$<?php
//                                                print_r($cart_summary);die;
                                                if (!empty($cart_summary['item_summary_total'])) {

                                                    if (!empty($discounts['total']['value'])) {

                                                        echo ($cart_summary['item_summary_total']
                                                        + $custom_option['shipping_total']
                                                        + $custom_option['tax_total'])
                                                        - str_replace('US $',
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

                                </table>









                            </div>

                        </div>






                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
                                    $("#paymentDetailsForm").submit(function (e) {
                                        e.preventDefault();
                                        $('#submitPayment').css('display', 'none');
                                        $('#img_loader').css('display', 'inline');
                                        var $form = $('#paymentDetailsForm');
                                        //alert($form);
                                        // Disable the submit button to prevent repeated clicks:
                                        $form.find('.strip-btn').prop('disabled', true);
                                        $form.find('.strip-btn').html('Please wait...');
                                        // Request a token from Stripe:
                                       
                                       
                                            $('#submitPayment').css('display', 'none');
                                            $('#img_loader').css('display', 'inline');
                                            $.ajax({
                                                url: base_url + 'home/Home/stripePaySubmit',
                                                data: $form.serialize(),
                                                type: 'POST',
                                                dataType: 'JSON',
                                                success: function (response) {
                                                    console.log(response);
                                                    $("html, body").animate({ scrollTop: 0 }, "slow");
                                                    if (response.status == '200') {

                                                        $("#paystatus").html('<div class="alert alert-success"><strong>Success! </strong>' + response.success + '</div>');
                                                        $('#img_loader').css('display', 'none');
                                                        $('#submitPayment').css('display', 'none');
                                                        setTimeout(function () {
                                                            window.location.href = base_url + "admin_library/order_details/<?php echo $this->flexi_cart->order_number() ?>";
                                                        }, 5000);
                                                    } else if (response.status == '700') {
                                                        $("#paystatus").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.error + '</div>');
                                                        $('#submitPayment').css('display', 'none');
                                                        $('#img_loader').css('display', 'block');

                                                        setTimeout(function () {
                                                            window.location.href = base_url + "home/cart";
                                                        }, 5000);

                                                    } else {
                                                        $("#paystatus").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.error + '</div>');
                                                        $('#submitPayment').css('display', 'block');
                                                        $('#img_loader').css('display', 'none');
                                                    }
                                                },
                                                error: function (error) {
                                                    console.log(error);
                                                    $('#submitPayment').css('display', 'block');
                                                    $('#img_loader').css('display', 'none');
                                                }
                                            });
                                            //console.log(response.id);
                                        

                                        // $('li[role=presentation]').removeClass('active');
                                        // $('.tab-pane').removeClass('active');
                                        // $('.status_details').removeClass('disabled').addClass('active');
                                    });
                                    

                                    function isNumberKey(evt) {
                                        var charCode = (evt.which) ? evt.which : event.keyCode;
                                        if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) {
                                            return false;
                                        }

                                        return true;
                                    }

</script>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>

                                    paypal.Button.render({

                                        env: 'production', // Or 'sandbox',production
                                        style: {
                                            label: 'checkout',
                                            size: 'medium', // small | medium | large | responsive
                                            shape: 'rect', // pill | rect
                                            color: 'gold'      // gold | blue | silver | black
                                        },

                                        client: {
                                            sandbox: 'Adtbn1glXOmnhaLkL3Y8ppD9jjxHp1j9pq4IamgGIgQM1XPom4-odOvIq0L4tLqty4HsUM6ecT6hBp45',
                                            production: 'ARyazPqm1pA8fBlV8Asmx6UfCJ9vuXg77Vt6Q2mLwjmP23KYxjAlLpiCFyPajCfBeucesYm5Lh3N2FPQ'
                                        },

                                        commit: true, // Show a 'Pay Now' button

                                        payment: function (data, actions) {
                                            return actions.payment.create({
                                                payment: {
                                                    transactions: [
                                                        {
                                                            amount: {total: '<?php
//                                                print_r($cart_summary);die;
                                                if (!empty($cart_summary['item_summary_total'])) {

                                                    if (!empty($discounts['total']['value'])) {

                                                        echo ($cart_summary['item_summary_total']
                                                        + $custom_option['shipping_total']
                                                        + $custom_option['tax_total'])
                                                        - str_replace('US $',
                                                            ' ',
                                                            $discounts['total']['value']);
                                                    } else {
                                                        echo $cart_summary['item_summary_total']
                                                        + $custom_option['shipping_total']
                                                        + $custom_option['tax_total'];
                                                    }
                                                }
                                                ?>', currency: 'USD'}
                                                        }
                                                    ]
                                                }
                                            });
                                        },

                                        onAuthorize: function (data, actions) {
                                            return actions.payment.execute().then(function (payment) {
                                                
                                                if(payment.state ==='approved'){                                                    
                                                $.ajax({
                                                    url: '<?php echo base_url(); ?>' + 'home/Home/updatePaypalPayment',
                                                    type: "POST",
                                                    data: {'payment': payment,'data':data, 'order_number': '<?php echo $this->flexi_cart->order_number() ?>'},
                                                    dataType: "json",
                                                    success: function (dataCurrent) {
                                                        $("html, body").animate({ scrollTop: 0 }, "slow");
                                                        if (dataCurrent.status === 200) {
                                                            $("#paystatus").html('<div class="alert alert-success">' + dataCurrent.data + '</div>');
                                                            $('#img_loader').css('display', 'none');
                                                            
                                                            setTimeout(function () {
                                                                window.location.href = base_url + "admin_library/order_details/<?php echo $this->flexi_cart->order_number() ?>";
                                                            }, 2000);
                                                        } else {
                                                            $("#paystatus").html('<div class="alert alert-danger"><strong>' + dataCurrent.data + '</div>');
                                                        }
                                                    }
                                                });
                                                }else{
                                                    $("#paystatus").html('<div class="alert alert-danger">Something went wrong. Paypal declined payment.Please try after sometime.</div>');
                                                    return false;
                                                
                                                }

                                            });
                                        },
                                         onClick: function () {
                                            $.ajax({
                                                    url: '<?php echo base_url(); ?>' + 'home/validatePaypalSession',
                                                    type: "POST",dataType: "json",
                                                    success: function (dataCurrent1) {
                                                        
                                                        if (dataCurrent1.status === 200) {
                                                            return true;
                                                        }else if(dataCurrent1.status === 202){
                                                            alert("Your cart is empty");
                                                            window.location.href=base_url+"home/cart";
                                                        }else if (dataCurrent1.status === 700){
                                                            //console.log('700');
                                                            // $.toaster({priority: 'danger', title: 'Payment error', message: '700'+dataCurrent.data});
                                                           
                                                                $("#paystatus").html('<div class="alert alert-danger"><strong>Fail! </strong>' + dataCurrent1.data + '</div>');
                                                                //$('#submitPayment').css('display', 'none');
                                                                //$('#img_loader').css('display', 'block');
                                                                setTimeout(function () {
                                                                    window.location.href = base_url + "home/cart";
                                                                }, 5000);

                                                            }
                                                        else {
                                                            alert("Your session is logged out. Please login and try again");
                                                            window.location.href=base_url+"home/login";
                                                        }
                                                    }
                                                });
                                        },

                                    }, '#paypal-button');


</script>
