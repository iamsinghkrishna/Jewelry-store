<div class="category_inner_header">

    <div class="container">

        <div class="category_header_div">

            <h2>My Profile</h2>

        </div>

    </div>

</div>

<!-- ./Home slide -->


<section class="cart_div">

    <div class="main-container no-sidebar">

        <div class="container">

            <?php echo form_open_multipart(base_url() . "home/my_profile"); ?>

            <div class="main-content">

                <div class="row">
                    <?php
                    if ($this->session->flashdata('profile_msg')) {
                        echo "<div class='alert alert-success'>" . $this->session->flashdata('profile_msg') . "</div>";
                    }
                    ?>

                    <div class="col-sm-12 col-md-8">



                        <div class="form-checkout">

                            <h5 class="form-title">SHIPPING ADDRESS</h5>

                            <div class="row">

                                <div class="col-sm-6">
                                    <p><input type="text" required name="shipping_name" id="checkout_shipping_name" value="<?php if (set_value('shipping_name')) {
                        echo set_value('shipping_name');
                    } else if ($account_details[0]['shipping_name'] == '') {
                        echo $dataHeader['first_name'] . " " . $dataHeader['last_name'];
                    } else {
                        echo $account_details[0]['shipping_name'];
                    } ?>" placeholder="Name" class="width_200"/>

<?php echo form_error('shipping_name', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="shipping_company" id="checkout_shipping_company" value="<?php echo (set_value('shipping_company')) ? set_value('shipping_company') : $account_details[0]['shipping_company']; ?>" placeholder="Company" class="width_200"/></p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="shipping_address_01" required id="checkout_shipping_add_01" value="<?php echo (set_value('shipping_address_01')) ? set_value('shipping_address_01') : $account_details[0]['shipping_address_01']; ?>" placeholder="Address Line 1" class="width_200"/>

<?php echo form_error('shipping_address_01', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="shipping_address_02" id="checkout_shipping_add_02" value="<?php echo (set_value('shipping_address_02')) ? set_value('shipping_address_02') : $account_details[0]['shipping_address_02']; ?>" placeholder="Address Line 2" class="width_200"/></p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" required name="shipping_city" id="city_name" value="<?php echo (set_value('shipping_address_city')) ? set_value('shipping_city') : $account_details[0]['shipping_city']; ?>" placeholder="City / Town" class="width_200"/>

<?php echo form_error('shipping_address_city', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p>

                                        <input type="text" required name="shipping_state" id="state_name" value="<?php echo (set_value('shipping_state')) ? set_value('shipping_state') : $account_details[0]['shipping_state']; ?>" placeholder="State" class="width_200"/>



<?php echo form_error('shipping_state', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p> 
                                        <input type="text"  required name="shipping_zipcode" id="cust_zipcode" value="<?php echo (set_value('shipping_zipcode')) ? set_value('shipping_zipcode') : $account_details[0]['shipping_zipcode']; ?>" placeholder="Post / Zip Code" class="width_200"/>


<?php echo form_error('shipping_zipcode', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>
                                    <div id="message_ship"></div>


                                </div>

                                <div class="col-sm-6">

                                    <p> 

                                        <select id="checkout_billing_country" required name="shipping_country" class="width_400">

                                            <option <?php if($account_details[0]['shipping_country'] == 'US') echo "selected";?> value="US"> USA </option>
                                            <option <?php if($account_details[0]['shipping_country'] == 'MX') echo "selected";?> value="MX"> Mexico </option>

                                            

                                        </select>
                                </div>

                            </div>



                        </div>

                        <div class="form-checkout">

                            <h5 class="form-title">BILLING ADDRESS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Same as shipping address?</strong>

                                <input type="checkbox" id="copy_billing_details" value="1"/></h5>







                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="billing_name" required id="checkout_billing_name" value="<?php if (set_value('billing_name')) {
    echo set_value('billing_name');
} else if ($account_details[0]['billing_name'] == '') {
    echo $dataHeader['first_name'] . " " . $dataHeader['last_name'];
} else {
    echo $account_details[0]['billing_name'];
} ?>" placeholder="Name" class="width_200"/>

<?php echo form_error('billing_name', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>



                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="billing_company" id="checkout_billing_company" value="<?php echo (set_value('billing_company')) ? set_value('billing_company') : $account_details[0]['billing_company']; ?>" placeholder="Company" class="width_200"/></p>

                                </div>

                            </div>



                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="billing_address_01" required id="checkout_billing_add_01" value="<?php echo (set_value('billing_address_01')) ? set_value('billing_address_01') : $account_details[0]['billing_address_01']; ?>" placeholder="Address Line 1" class="width_200"/>

<?php echo form_error('billing_address_01', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="billing_address_02" id="checkout_billing_add_02" value="<?php echo (set_value('billing_address_02')) ? set_value('billing_address_02') : $account_details[0]['billing_address_02']; ?>" placeholder="Address Line 2" class="width_200"/></p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" name="billing_city" required id="billing_city" value="<?php echo (set_value('billing_city')) ? set_value('billing_city') : $account_details[0]['billing_city']; ?>" placeholder="City / Town" class="width_200"/>

<?php echo form_error('billing_city', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><input type="text" name="billing_state" required id="billing_state" value="<?php echo (set_value('billing_state')) ? set_value('billing_state') : $account_details[0]['billing_state']; ?>" placeholder="State" class="width_200"/>

                                        <?php echo form_error('billing_state', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p> <input type="text" name="billing_zipcode" required id="billing_zipcode" value="<?php echo (set_value('billing_zipcode')) ? set_value('billing_zipcode') : $account_details[0]['billing_zipcode']; ?>" placeholder="Post / Zip Code" class="width_200"/>

                                            <?php echo form_error('billing_zipcode', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                                <div class="col-sm-6">

                                    <p><select id="checkout_billing_country" required name="billing_country" class="width_400">

                                            <option <?php if($account_details[0]['billing_country'] == 'US') echo "selected";?> value="US"> USA </option>
                                            <option <?php if($account_details[0]['billing_country'] == 'MX') echo "selected";?> value="MX"> Mexico </option>

                                            

                                        </select>

<?php echo form_error('billing_country', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>

                            </div>



                        </div>









                        <div class="form-checkout">

                            <h5 class="form-title">CONTACT DETAILS</h5>
                            <div class="row">

                                <div class="col-sm-6">

                                    <p><input type="text" required name="phone" id="phone" value="<?php echo (set_value('phone')) ? set_value('phone') : $account_details[0]['phone']; ?>" placeholder="Phone Number" class="width_200"/>

<?php echo form_error('checkout[phone]', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>
                                <div class="col-sm-6">

                                    <p><input type="text" readonly name="checkout[email]" id="checkout_email" value="<?php echo (set_value('checkout[email]')) ? set_value('checkout[email]') : $account_details[0]['email']; ?>" placeholder="Email" class="width_200"/>

<?php echo form_error('checkout[email]', '<span style="color:red" class="error">', '</span>'); ?>

                                    </p>

                                </div>







                            </div>
                            <div class="row">


                                <div class="col-sm-3">

                                    <p><input type="file" name="profile_image" id="checkout_phone" placeholder="Phone Number" class="width_200"/>


                                    </p>
                                    <input type="hidden" name="old_profile_image" value="<?php echo $account_details[0]['picture_url'];?>">

                                </div>
                                <?php if($account_details[0]['picture_url'] != ''){ ?>
                                <div class="col-sm-6">

                                    <p>

                                        <img src="<?php echo $account_details[0]['picture_url']; ?>">
                                    </p>

                                </div>
                                <?php } ?>


                            </div>

                            <div class="row">

                                <div class="col-sm-6">

                                    <p>

                                        <input type="submit" value="Update">
                                    </p>

                                </div>


                            </div>





                        </div>



                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="box-cart-total">
                            <h2 class="title" style="border-bottom: 0;">My Account</h2>
                            <table class="table checkoutOrdertable">
                                <tr>
                                    <td >
                                        <a href="<?php echo base_url(); ?>home/orders" class="active">My Orders</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active">
                                        <a class="active" >My Profile</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url(); ?>home/cart" >My Cart</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url(); ?>home/checkout">Checkout</a>
                                    </td>
                                </tr>
                            </table>



                        </div>
                    </div>

                </div>

            </div>

<?php echo form_close(); ?>

        </div>

    </div>

</section>

<script>
    $(function ()

    {

        // Toggle show/hide cart session array

        $('#copy_billing_details').click(function ()

        {

            $('input').each(function ()

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
</script>