<!--Banner-Start-->


<section id="Aboutus_Img_Grid">
    <div class="container">
        <div class="row" style="margin-top:222px;">
			<div class="c-content-title-1">
                            <div class="c-content-title-1">
                            <h3 class="c-center c-font-uppercase c-font-bold">Thank You</h3>
                            <div class="c-line-center c-theme-bg"></div>
                        </div>
                            <div class="c-center">Your order has been placed successfully.</div>
                        </div>
            
            <!--<a href="#about" class="btn btn-primary btn-xl page-scroll">Enter Site</a>-->

       
            <table class="table table-bordered" style="margin-top:50px;">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="center">Price</th>
                    <th class="center">QTY</th>
                    <th class="center">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($cart['shopping_cart']['items'] as $cart_item) {
                    ?>
                    <tr>
                        <td><?php echo $cart_item['id']; ?></td>
                        <td><?php echo $cart_item['name']; ?></td>
                        <td class="center"> $<?php echo number_format($cart_item['price'],2); ?></td>
                        <td class="center"><?php echo $cart_item['qty']; ?></td>
                        <td class="center"> $<?php echo round($cart_item['qty'] * $cart_item['price'],2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="row clearfix">
                <div class="col-md-4 column">
                    <!--<p><strong>Billing Information</strong></p> -->
                    <p>
                        <?php
						
						
                        /*echo $cart['first_name'] . ' ' . $cart['last_name'] . '<br />' .
                            $cart['email'] . '<br />'.
                            $cart['phone_number'] . '<br />';*/
                        ?>
                    </p>
                </div> 
                <div class="col-md-4 column">
                    <p><strong>Shipping Information</strong></p>
                    <p>
                        
						<?php 
						
				$addr = (!empty($checkoutdata['ord_bill_name'])) ? $checkoutdata['ord_bill_name'] . ', ' : '';
				//$addr .= (!empty($checkoutdata['ord_email'])) ? $checkoutdata['ord_email'] . ', ' : '';
				$addr .= (!empty($checkoutdata['ord_bill_address_01'])) ? $checkoutdata['ord_bill_address_01'] . ', ' . '<br/>' : '';
				$addr .= (!empty($cart['shiptocity'])) ? $cart['shiptocity'] . ', ' : '';
				$addr .= (!empty($cart['shiptostate'])) ? $cart['shiptostate'] . ', ' : '';
				$addr .= (!empty($cart['shiptozip'])) ? 'Zipcode :- '. $cart['shiptozip'] . ', ' . '<br/>' : '';
				$addr .= (!empty($cart['shiptophonenum'])) ? 'Phone :-' . $cart['shiptophonenum'] . ', ' : '';
				
		
				echo $addr;
		         
                       /* echo $cart['shipping_name'] . '<br />' .
                            $cart['shipping_street'] . '<br />' .
                            $cart['shipping_city'] . ', ' . $cart['shipping_state'] . '  ' . $cart['shipping_zip'] . '<br />' .
                            $cart['shipping_country_name'];*/
                        ?>
                    </p>
                </div>
                <div class="col-md-4 column">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><strong> Subtotal</strong></td>
                            <td> $<?php echo number_format($cart['shopping_cart']['subtotal'],2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Shipping</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['shipping'],2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Handling</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['handling'],2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tax</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['tax'],2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Grand Total</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['grand_total'],2); ?></td>
                        </tr>
                        <tr>
                            <td class="center" colspan="2">
							<a href="<?php echo base_url() . 'research-page'; ?>" class="btn btn-lg c-theme-btn c-btn-square c-btn-uppercase c-btn-bold">Continue Shopping</a>
                                
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</section>


<div class="hr_Line"><hr></div> 
