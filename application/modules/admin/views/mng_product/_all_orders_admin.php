
<div class="shoppingCartWrap pt-40 mb-40">
    <div class="container">
        <div class="widget-title title-s2 hidden-print">
            <h3><?php echo $page_title; ?></h3>
        </div>
        <br>
    <!--<p><a href="<?php // echo $base_url;                         ?>admin_library/orders">Manage Orders</a></p>-->
        <div class="row">


            <?php if (!empty($message)) { ?>
                <div id="message">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <div class="top-link">
                    <a href="<?php echo base_url(); ?>admin_library/invoice/<?php
                    echo $summary_data[$this->flexi_cart_admin->db_column('order_summary',
                        'order_number')];
                    ?>" class="btn  btn-default hidden-print"><i class="fa fa-download"></i></a>
                    <a id='btnPrint' class="print btn  btn-default hidden-print"><i class="fa fa-print "></i></a>
                                        <!--a href="<?php echo base_url(); ?>home/orders" class="pre-page hidden-print">Back to Previous Page</a-->
                    <a href="javascript:;" class="btn  btn-default" data-toggle="modal" data-target=".forget-modal">Assign UPS tracking number</a>
                </div>
                <!-- Modal -->
                <div class="modal fade forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Assign Tracking Number</h4>
                            </div>
                            <div class="modal-body">
                                <p>Enter order tracking number</p>
                                <input type="text" name="recovery-email" id="tracking_number" class="form-control" autocomplete="off">
                            </div>
                            <div class="modal-footer">
                                <!--button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button-->
                                <button type="button" id="assignTrackingNumber" class="btn btn-custom">Submit</button>
                            </div>
                        </div> <!-- /.modal-content -->
                    </div> <!-- /.modal-dialog -->
                </div> <!-- /.modal -->

            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="main-invoice_section">
                            <div class="custom_header1">
                                
                                <address >
                                    <h2>Billing Address</h2>
                                    <p>Name: <?php echo $summary_data['ord_demo_bill_name']; ?></p>
                                    <p>Address 01: <?php echo $summary_data['ord_demo_bill_address_01']; ?></p>
                                    <p>Address 02: <?php echo $summary_data['ord_demo_bill_city']; ?></p>
                                    <p>City / Town: <?php echo $summary_data['ord_demo_ship_city']; ?></p>
                                    <p>State / County: <?php echo $summary_data['ord_demo_bill_country']; ?></p>
                                    <p>Post / Zip Code: <?php echo $summary_data['ord_demo_bill_post_code']; ?></p>
                                    <p>Country: <?php echo $summary_data['ord_demo_bill_country']; ?></p>
                                    <p>Email: <?php echo $summary_data['ord_demo_email']; ?></p>
                                    <?php
                                    echo ($summary_data['ord_demo_phone'] != 0) ? "<p>Phone: ".$summary_data['ord_demo_phone']
                                            : ""
                                    ?></p>
                                </address>
                               
                                <address >
                                     <h2>Shipping Address</h2>
                                    <p>Name: <?php echo $summary_data['ord_demo_ship_name']; ?></p>
                                    <p>Address 01: <?php echo $summary_data['ord_demo_ship_address_01']; ?></p>
                                    <p>Address 02: <?php echo $summary_data['ord_demo_ship_address_02']; ?></p>
                                    <p>City / Town: <?php echo $summary_data['ord_demo_ship_city']; ?></p>
                                    <p>State: <?php echo $summary_data['ord_demo_ship_state']; ?></p>
                                    <p>Country: <?php echo $summary_data['ord_demo_ship_country']; ?></p>
                                    <p>Post / Zip Code: <?php echo $summary_data['ord_demo_ship_post_code']; ?></p>

                                    <p>Email: <?php echo $summary_data['ord_demo_email']; ?></p>
                                    <?php
                                    echo ($summary_data['ord_demo_phone'] != 0) ? "<p>Phone: ".$summary_data['ord_demo_phone']
                                            : ""
                                    ?></p>
                                </address>

                                <img style="background:none" alt="" src="<?php echo base_url(); ?>/assets/images/Logo_Vaskia.png">
                                <!--<input type="file" accept="image/*">-->

                            </div>

                            <article>
                                
                                <table class="meta">
                                    <tr>
                                        <th><span >Order Tracking Number</span></th>
                                        <td><span ><?php echo $summary_data['order_tracking_number']; ?></span></td>
                                    </tr>
                                    <tr>
                                        <th><span >Order Number</span></th>
                                        <td><span ><?php
                                                echo $summary_data[$this->flexi_cart_admin->db_column('order_summary',
                                                    'order_number')];
                                                ?></span></td>
                                    </tr>
                                    <tr>
                                        <th><span >Order Date</span></th>
                                        <td><span > <?php
                                                echo date('jS M Y',
                                                    strtotime($summary_data[$this->flexi_cart_admin->db_column('order_summary',
                                                            'date')]));
                                                ?></span></td>
                                    </tr>
                                    <tr>
                                        <th><span >Order Status</span></th>
                                        <td><?php
                                            if ($summary_data[$this->flexi_cart_admin->db_column('order_status',
                                                    'cancelled')] == 1) {
                                                echo '<strong class="highlight_red">'.$summary_data[$this->flexi_cart_admin->db_column('order_status',
                                                    'status')].'</strong>';
                                            } else {
                                                echo $summary_data[$this->flexi_cart_admin->db_column('order_status',
                                                    'status')];
                                            }
                                            ?></td>
                                    </tr>
                                </table>

                                <table class="inventory">
                                    <thead>
                                        <tr>
                                            <th><span >Item Code/SKU</span></th>
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
                                                    <td><?php echo $row['product_details']['product_sku']?></td>
                                                    <td><span ><?php
                                                            echo $row['ord_det_item_name'];
                                                            $matches = unserialize($row['ord_det_item_option']);
                                                            if ($matches['Initial']
                                                                != '' && $matches['Color']
                                                                != '') {
                                                                echo "<br>(Initial - ".$matches['Initial']." / Color - ".$matches['Color'].")";
                                                            }
                                                            if ($matches['variant']
                                                                != '' && $matches['variant']
                                                                != '')
                                                                    echo "<br>".$matches['variant'];
                                                            if ($matches['Prebook']
                                                                != '' && $matches['Prebook']
                                                                == 'true') {
                                                                echo "<br><span style='color:red'>(Pre Order)</span>";
                                                            }
//                                                            foreach ($matches as $key => $value) {
//                                                                if ($key != 'Initial'
//                                                                    && $key != 'Color'
//                                                                    && $key != 'Prebook')
//                                                                        echo "<br>".$key." - ".$value."<br>";
//                                                            }
                                                            if($row['product_details']['variant_color']!='') echo "<br>Color - ".$row['product_details']['variant_color']."<br>";
                                                            if($row['product_details']['variant_size']!='') echo "Color - ".$row['product_details']['variant_size']."<br>";
                                                            ?>

                                                        </span></td>
                                                    <!--<td><span >Experience Review</span></td>-->
                                                    <td>
                                                        <span data-prefix>$</span><span ><?php
                                                            // If an item discount exists.
                                                            if ($row[$this->flexi_cart_admin->db_column('order_details',
                                                                    'item_discount_quantity')]
                                                                > 0) {
                                                                // If the quantity of non discounted items is zero, strike out the standard price.
                                                                if ($row[$this->flexi_cart_admin->db_column('order_details',
                                                                        'item_non_discount_quantity')]
                                                                    == 0) {
                                                                    echo '<span class="strike">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                            'item_price')],
                                                                        TRUE, 2,
                                                                        TRUE).'</span><br/>';
                                                                }
                                                                // Else, display the quantity of items that are at the standard price.
                                                                else {
                                                                    echo number_format($row[$this->flexi_cart_admin->db_column('order_details',
                                                                            'item_non_discount_quantity')]).' @ '.
                                                                    $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                            'item_price')],
                                                                        TRUE, 2,
                                                                        TRUE).'<br/>';
                                                                }

                                                                // If there are discounted items, display the quantity of items that are at the discount price.
                                                                if ($row[$this->flexi_cart_admin->db_column('order_details',
                                                                        'item_discount_quantity')]
                                                                    > 0) {
                                                                    echo number_format($row[$this->flexi_cart_admin->db_column('order_details',
                                                                            'item_discount_quantity')]).' @ '.
                                                                    $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                            'item_discount_price')],
                                                                        TRUE, 2,
                                                                        TRUE);
                                                                }
                                                            }
                                                            // Else, display price as normal.
                                                            else {
                                                                echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                        'item_price')],
                                                                    TRUE, 2,
                                                                    TRUE);
                                                            }
                                                            ?></span>
                                                    </td>
                                                    <td><span ><?php
                                                            echo round($row[$this->flexi_cart_admin->db_column('order_details',
                                                                    'item_quantity')],
                                                                2);
                                                            ?></span></td>
                                                    <td><span data-prefix><?php
                                                            // If an item discount exists, strike out the standard item total and display the discounted item total.
                                                            if ($row[$this->flexi_cart_admin->db_column('order_details',
                                                                    'item_discount_quantity')]
                                                                > 0) {
                                                                echo '<span class="strike">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                        'item_price_total')],
                                                                    TRUE, 2,
                                                                    TRUE).'</span><br/>';
                                                                echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                        'item_discount_price_total')],
                                                                    TRUE, 2,
                                                                    TRUE);
                                                            }
                                                            // Else, display item total as normal.
                                                            else {
                                                                echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details',
                                                                        'item_price_total')],
                                                                    TRUE, 2,
                                                                    TRUE);
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
                                                if ($summary_data['ord_summary_savings_total']
                                                    != '') {
                                                    echo $summary_data['ord_summary_savings_total'];
                                                }
                                                ?></span></td>
                                    </tr>
                                    <?php
                                    if ($summary_data['ord_tax_total'] != '') {
                                        ?>
                                        <tr>
                                            <th><span >Total Tax</span></th>
                                            <td><span data-prefix>

                                                    <?php
                                                    //echo $this->flexi_cart_admin->format_currency($summary_data['ord_item_shipping_total'] - str_replace('US $', ' ', $summary_data['ord_summary_savings_total']), TRUE, 2, TRUE);
                                                    echo 'US $'.($summary_data['ord_tax_total']);

//                                                echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')], TRUE, 2, TRUE);
                                                    ?></td>

                                        </tr>
                                    <?php } ?>


                                    <?php
                                    if ($summary_data['ord_shipping_total'] != '') {
                                        ?>
                                        <tr>
                                            <th><span >Shipping Charges</span></th>
                                            <td><span data-prefix>

                                                    <?php
                                                    //echo $this->flexi_cart_admin->format_currency($summary_data['ord_item_shipping_total'] - str_replace('US $', ' ', $summary_data['ord_summary_savings_total']), TRUE, 2, TRUE);
                                                    echo 'US $'.($summary_data['ord_shipping_total']);

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
</div>
</div>
</div>
</div>
<script>
    $("#btnPrint").click(function () {
        $("#main-invoice_section").print();
    });

    $("#assignTrackingNumber").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo base_url() ?>admin/admin/updateTrackingNumber",
            data: {
                order_tracking_number: $("#tracking_number").val(),
                order_number: '<?php
                                    echo $summary_data[$this->flexi_cart_admin->db_column('order_summary',
                                        'order_number')];
                                    ?>'
            },
            success: function (result) {
                if (result.status === 200) {
                    alert(result.msg);
                    $('.forget-modal').modal('toggle');
                    location.reload();
                } else {
                    alert(result.msg);
                }
            }
        });
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

    table.meta, table.balance { float: right; width: 36%; }
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

    @page { margin: 0; }
</style>