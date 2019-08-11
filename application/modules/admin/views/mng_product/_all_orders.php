
<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

            <h2>Order Details</h2>

        </div>
    </div>
</div>
<!-- ./Home slide -->

<section class="cart_div">
    <div class="main-container no-sidebar">
        <div class="container">
            <div class="main-content">
                <?php
//            echo "<pre>";
//            print_r($summary_data);die;
                if (!empty($message)) {
                    ?>
                    <div id="message">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>								
                <div class="col-sm-12">				<div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
                        <a href="<?php echo base_url(); ?>admin_library/invoice/<?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')]; ?>" class=" print hidden-print btn btn-xs btn-line" style="margin-left: 0;"><i class="fa fa-download"></i> DOWNLOAD</a>
                        <a id="btnPrint" class="print btn btn-xs btn-line"><i class="fa fa-print hidden-print"></i> PRINT</a>
                    </div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
                    <a href="<?php echo base_url(); ?>home/orders" class="pre-page hidden-print btn btn-xs btn-line pull-right"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to Previous Page</a>					<div class="clearfix"></div>					</div>
                </div>				</div>				<div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="main-invoice_section" id='main-invoice_section'>
                                <div class="custom_header1">

                                    <address >
                                        <h1>Customer Name: <?php echo $summary_data['ord_demo_bill_name']; ?></h1>
                                        <p>Address 01: <?php echo $summary_data['ord_demo_bill_address_01']; ?></p>
                                        <p>Address 02: <?php echo $summary_data['ord_demo_bill_address_02']; ?></p>
                                        <p>City: <?php echo $summary_data['ord_demo_ship_city']; ?></p>
                                        <p>State: <?php echo $summary_data['ord_demo_ship_state']; ?></p>
                                        <p>Post / Zip Code: <?php echo $summary_data['ord_demo_ship_post_code']; ?></p>
                                        <p>Country: <?php echo $summary_data['ord_demo_ship_country']; ?></p>
                                        <p>Email: <?php echo $summary_data['ord_demo_email']; ?></p>
                                          <?php
                                          if($summary_data['ord_demo_phone'] != 0 && $summary_data['ord_demo_phone'] != ''){
                                        ?>
                                        <p>Phone Number: <?php echo $summary_data['ord_demo_phone']; ?></p>
                                        <?php } ?>
                                    </address>
                                    <span>
                                        <img alt="" style="background:none" src="<?php echo base_url(); ?>/assets/images/Logo_Vaskia.png">
                                        <!--<input type="file" accept="image/*">-->
                                    </span>
                                </div>

                                <article>

                                    <table class="meta">
                                        <tr>
                                            <th><span >Order Number</span></th>
                                            <td><span ><?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')]; ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span >Order Date</span></th>
                                            <td><span > <?php echo date('jS M Y', strtotime($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'date')])); ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span >Order Status</span></th>
                                            <td><?php
                                                if ($summary_data[$this->flexi_cart_admin->db_column('order_status', 'cancelled')] == 1) {
                                                    echo '<strong class="highlight_red">' . $summary_data[$this->flexi_cart_admin->db_column('order_status', 'status')] .' '.$advance. '</strong>';
                                                } else {
                                                    echo $summary_data[$this->flexi_cart_admin->db_column('order_status', 'status')].' '.$advance;
                                                }
                                                ?></td>
                                        </tr>
                                    </table>

                                    <table class="inventory">
                                        <thead>
                                            <tr>
                                                <th><span >Item</span></th>
                                                <!--<th><span >Description</span></th>-->
                                                <th><span >Rate</span></th>
                                                <th><span >Quantity</span></th>
                                                <th><span >Price</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php // echo '<pre>', print_r($item_data);die;?>
                                            <?php if (!empty($item_data)) { ?>
                                                <?php foreach ($item_data as $row) { ?>
                                                    <tr>
                                                        <td><span ><?php echo $row['ord_det_item_name'];
                                                             $matches
                                                                                    = unserialize($row['ord_det_item_option']);
                                                                                if ($matches['Initial']
                                                                                    != ''
                                                                                    && $matches['Color']
                                                                                    != '') {
                                                                                    echo "<br>(Initial - ".$matches['Initial']." / Color - ".$matches['Color'].")";
                                                                                }
                                                                                 if ($matches['variant'] != '' && $matches['variant'] != '') echo "<br>" . $matches['variant'];
                                                                                if ($matches['Prebook']
                                                                                    != ''
                                                                                    && $matches['Prebook']
                                                                                    == 'true') {
                                                                                    echo "<br><span style='color:red'>(Pre Order)</span>";
                                                                                }
                                                            ?>
                                                            </span></td>
                                                        <!--<td><span >Experience Review</span></td>-->
                                                        <td>
                                                            <span data-prefix></span><span ><?php
                                                                // If an item discount exists.
                                                                if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) {
                                                                    // If the quantity of non discounted items is zero, strike out the standard price.
                                                                    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_non_discount_quantity')] == 0) {
                                                                        echo '<span class="strike">' . $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE) . '</span><br/>';
                                                                    }
                                                                    // Else, display the quantity of items that are at the standard price.
                                                                    else {
                                                                        echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_non_discount_quantity')]) . ' @ ' .
                                                                        $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE) . '<br/>';
                                                                    }

                                                                    // If there are discounted items, display the quantity of items that are at the discount price.
                                                                    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) {
                                                                        echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')]) . ' @ ' .
                                                                        $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price')], TRUE, 2, TRUE);
                                                                    }
                                                                }
                                                                // Else, display price as normal.
                                                                else {
                                                                    echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE);
                                                                }
                                                                ?></span>
                                                        </td>
                                                        <td><span ><?php echo round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2); ?></span></td>
                                                        <td><span data-prefix><?php
                                                                // If an item discount exists, strike out the standard item total and display the discounted item total.
                                                                if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) {
                                                                    echo '<span class="strike">' . $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE) . '</span><br/>';
                                                                    echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price_total')], TRUE, 2, TRUE);
                                                                }
                                                                // Else, display item total as normal.
                                                                else {
                                                                    echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE);
                                                                }
                                                                ?></span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <table class="balance">
                                       <tr>
                                            <th><span >Sub Total</span></th>
                                            <td><span data-prefix>$<?php echo $summary_data['ord_item_summary_total']; ?></span></td>
                                        </tr>
                                        
                                        <tr>
                                            <th><span >Discount Amount</span></th>
                                            <td><span data-prefix>$</span><span><?php
                                                    if ($summary_data['ord_summary_savings_total'] != '') {
                                                        echo $summary_data['ord_summary_savings_total'];
                                                    }
                                                    ?></span></td>
                                        </tr>
                                        <?php if ($summary_data['ord_tax_total'] != '') { ?>
                                            <tr>
                                                <th><span >Total Tax</span></th>
                                                <td><span data-prefix>

                                                        <?php
                                                        //echo $this->flexi_cart_admin->format_currency($summary_data['ord_item_shipping_total'] - str_replace('US $', ' ', $summary_data['ord_summary_savings_total']), TRUE, 2, TRUE);
                                                        echo 'US $' . ($summary_data['ord_tax_total']);

//                                                echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')], TRUE, 2, TRUE); 
                                                        ?></td>

                                            </tr>
                                        <?php } ?>


                                        <?php if ($summary_data['ord_shipping_total'] != '') { ?>
                                            <tr>
                                                <th><span >Shipping Charges</span></th>
                                                <td><span data-prefix>

                                                        <?php
                                                        //echo $this->flexi_cart_admin->format_currency($summary_data['ord_item_shipping_total'] - str_replace('US $', ' ', $summary_data['ord_summary_savings_total']), TRUE, 2, TRUE);
                                                        echo 'US $' . ($summary_data['ord_shipping_total']);

//                                                echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')], TRUE, 2, TRUE); 
                                                        ?></td>

                                            </tr>
                                        <?php } ?>
                                            <tr>
                                            <th><span >Total</span></th>
                                            <td><span data-prefix>$<?php echo $summary_data['ord_total']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span >Balance Due</span></th>
                                            <td><span data-prefix>$</span><span>00.00</span></td>
                                        </tr>
                                    </table>

                                </article>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            x</button>
                        <h4 class="modal-title" id="myModalLabel">
                            Login to continue</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <span id="st_message"></span>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#Login" data-toggle="tab">Login</a></li>
                                    <li><a href="#Registration" data-toggle="tab">Registration</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="Login">

                                        <form  id="loginForm" method="post"  class="form-horizontal">
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Username</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="username" required class="form-control" id="email1" placeholder="Email" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1" class="col-sm-2 control-label">
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password" required class="form-control" id="exampleInputPassword1" placeholder="Email" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn kopaBtn">
                                                        Submit</button>
                                                    <!--<a href="javascript:;">Forgot your password?</a>-->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="Registration">
                                        <form role="form" id="signupForm" class="form-horizontal">

                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    First Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" required name="first_name" class="form-control" id="email" placeholder="Email" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Last Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" required name="last_name" class="form-control" id="email" placeholder="Email" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" required class="form-control" id="email" placeholder="Email" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile" class="col-sm-2 control-label">
                                                    Mobile</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="phone" required class="form-control" id="mobile" placeholder="Mobile" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password" required class="form-control" id="password" placeholder="Password" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">
                                                    Confirm Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password_confirm" class="form-control" id="password" placeholder="Password" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn kopaBtn">
                                                        Register</button>
                                                    <button type="button"  data-dismiss="modal" aria-hidden="true" class="btn kopaBtn">
                                                        Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- main content -->
<script type="text/javascript">
    function funDeleteCartProduct(itemId) {
        //    var itemId = $(this).find('#item_session_id').val();
//        var itemId = $(this).closest('tbody tr input').next('').val();
        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': itemId},
                    url: href = "<?php echo base_url(); ?>standard_library/delete_item/" + itemId,
                    success: function (data)
                    {
                        $.toaster({priority: 'danger', title: 'Cart', message: 'Item Remove from cart.'});

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
    });
</script>

<script>
    $("#btnPrint").click(function () {
        var divContents = $("#main-invoice_section").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>DIV Contents</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
</script>
<!--End Invoice Section-->
<style type="text/css">
    /* reset */

    /* content editable */

    *[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

    *[contenteditable] { cursor: pointer; }

    *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

    span[contenteditable] { display: inline-block; }


    /* table */

    table { font-size: 75%; table-layout: fixed; width: 100%; }
    table { border-collapse: separate; border-spacing: 2px; }
    th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
    th, td { border-radius: 0.25em; border-style: solid; }
    th { background: #EEE; border-color: #BBB; }
    td { border-color: #DDD; }

    /* page */

    /* header */

    .custom_header1 { margin: 0 0 3em; }
    .custom_header1:after { clear: both; content: ""; display: table; }

    .custom_header1 h1 {
        border-radius: 0.25em;
        margin: 0;
        padding: 0;
        font-size: 15px;
    }
    .custom_header1 address { float: left; font-size: 100%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
    .custom_header1 address p { margin: 0 0 0.25em; }
    .custom_header1 span, .custom_header1 img { display: block; float: right; }
    .custom_header1 span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
    .custom_header1 img {
        max-height: 100%;
        max-width: 100%;
        background: #404040;
        padding: 15px 11px;
        border-radius: 3px;
    }
    .custom_header1 input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

    /* article */

    article, article address, table.meta, table.inventory { margin: 0 0 3em; }
    article:after { clear: both; content: ""; display: table; }
    article h1 { clip: rect(0 0 0 0); position: absolute; }

    article address { float: left; font-size: 125%; font-weight: bold; }

    /* table meta & balance */

    table.meta, table.balance { float: right; width: 50%; }
    table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

    /* table meta */

    table.meta th { width: 40%;font-size: 13px; }
    table.meta td { width: 60%;font-size: 12px; }

    /* table items */

    table.inventory { clear: both; width: 100%; }
    table.inventory th { font-weight: bold; text-align: center;font-size: 13px; }

    table.inventory td { text-align: center; }
    /*table.inventory td:nth-child(1) { width: 26%; }
    table.inventory td:nth-child(2) { width: 38%; }
    table.inventory td:nth-child(3) { text-align: right; width: 12%; }
    table.inventory td:nth-child(4) { text-align: right; width: 12%; }
    table.inventory td:nth-child(5) { text-align: right; width: 12%; }*/

    /* table balance */

    table.balance th, table.balance td { width: 50%; }
    table.balance th { font-size: 13px; }
    table.balance td { text-align: right; font-size: 12px; }

    /* aside */

    aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
    aside h1 { border-color: #999; border-bottom-style: solid; }

    /* javascript */

    .add, .cut
    {
        border-width: 1px;
        display: block;
        font-size: .8rem;
        padding: 0.25em 0.5em;  
        float: left;
        text-align: center;
        width: 0.6em;
    }

    .add, .cut
    {
        background: #9AF;
        box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
        background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
        border-radius: 0.5em;
        border-color: #0076A3;
        color: #FFF;
        cursor: pointer;
        font-weight: bold;
        text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
    }

    .add { margin: -2.5em 0 0; }

    .add:hover { background: #00ADEE; }

    .cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
    .cut { -webkit-transition: opacity 100ms ease-in; }

    tr:hover .cut { opacity: 1; }

    .main-invoice_section {
        border: 1px solid #ccc;
        background: #fff;
        padding: 15px;
    }

    @media print {
        * { -webkit-print-color-adjust: exact; }
        html { background: none; padding: 0; }
        body { box-shadow: none; margin: 0; }
        span:empty { display: none; }
        .add, .cut { display: none; }
    }
    @page { margin: 0; }		@media only screen and (max-width: 638px)  {		table.meta, table.balance { width: 100%; }	}
</style>







