<div class="shoppingCartWrap pt-40 mb-40">
    <div class="container">
        <div class="widget-title title-s2 hidden-print">
            <h3><?php echo $page_title; ?></h3>
        </div>
        <br>
    <!--<p><a href="<?php // echo $base_url;                   ?>admin_library/orders">Manage Orders</a></p>-->
        <div class="row">


            <?php if (!empty($message)) { ?>
                <div id="message">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <div class="top-link">

                </div>

                <a href="<?php echo base_url(); ?>home/orders" class="pre-page hidden-print">Back to Previous Page</a>
            </div>
            <?php foreach ($order_details as $od) { ?>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="main-invoice_section">
                                <div class="custom_header1">

                                    <address >
                                        <h1>Customer Name: <?php
                                            foreach ($od['customers']['elements'] as $cust) {
                                                echo $cust['firstName'] . " " . $cust['lastName'];
                                            }
                                            ?></h1>
                                        <br>
                                        <h1>Employee Name: <?php echo $od['employee']['name']; ?></h1>

                                        <br>
                                        <!-- <h1>Device Type: <?php echo $order_details['device_details']['deviceTypeName']; ?></h1>

                                        <br>
                                        <h1>Device Model: <?php echo $order_details['device_details']['model']; ?></h1> -->


                                    </address>

                                    <img style="background:none" alt="" src="<?php echo base_url(); ?>/assets/images/Logo_Vaskia.png">
                                    <!--<input type="file" accept="image/*">-->

                                </div>

                                <article>

                                    <table class="meta">
                                        <tr>
                                            <th><span >Order Number</span></th>
                                            <td><span ><?php echo $od['id']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span >Order Date</span></th>
                                            <td><span > <?php
//                                        echo gmdate('d M Y h:i a', substr($od['clientCreatedTime'], 0, -3));
                                        $seconds = $od['clientCreatedTime'] / 1000;
                                        echo date("d-M-Y h:i a", $seconds);
                                            ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span >Order Status</span></th>
                                            <td>Completed</td>
                                        </tr>
                                    </table>

                                    <table class="inventory">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Product SKU/Code</td>
                                                <td>Product Name</td>
                                                <td>Product Price</td>
                                                <!-- <td>Discount</td> -->
                                                <td>Details</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $item_amount = 0.00;
                                        $i = 0;
                                        $discount_amount1 = 0;
                                        foreach ($od['lineItems']['elements'] as $items) {
                                            // if($items['id'] == $discount_details['elements'][$i]['id']){
                                            //        $discount = $discount_details['elements'][$i]['amount'];
                                            //        $discount_name = $discount_details['elements'][$i]['name'];
                                            //        $discount_amount = $items['amount'] / 100 ;
                                            //        $discount_amount1 = $discount_amount1 + $discount_amount;
                                            //    }else{
                                            //        $discount = "";
                                            //        $discount_name = "N/A";
                                            //    }                                   


                                            echo "<tr><td>" . $items['id'] . "</td>";
                                            echo "<td>" . $items['itemCode'] . "</td>";
                                            echo "<td>" . $items['name'] . "</td>";
                                            echo "<td>$" . number_format(($items['price'] / 100), 2) . "</td>";
                                            // echo "<td>".$discount_name."<br>".$discount ."</td>";
                                            echo "<td>";
                                            if ($items['refunded'] == 1)
                                                echo "<strong style='color:red'>Refunded </strong><br>";
                                            if ($items['printed'] == 1)
                                                echo "Printed <br>";
                                            if ($items['isRevenue'] == 1)
                                                echo "Is Revenue";
                                            echo "</td></tr>";
                                            $i++;
                                        }
                                        ?>
                                        <tbody>

                                        </tbody>

                                    </table>

                                    <table class="balance">
    <?php foreach ($od['payments']['elements'] as $pd) { ?>
                                            <tr>
                                                <th><span >Amount</span></th>
                                                <td><span data-prefix>$<?php echo $pd['amount'] / 100; ?></span></td>
                                            </tr>

                                            <tr>
                                                <th><span >Tax</span></th>
                                                <td><span data-prefix>$<?php echo number_format(($pd['taxAmount'] / 100), 2); ?></span></td>
                                            </tr>


                                            <tr>
                                                <th><span >Total Amount</span></th>
                                                <td><span data-prefix>$<?php echo $pd['amount'] / 100; ?></span></td>
                                            </tr>

    <?php } ?>

                                    </table>

                                </article>

                            </div>

                        </div>
                    </div>
                </div>
<?php } ?>
        </div>
    </div>
</div>
</div>
</div>
</div>

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