
<!--Banner-Start-->
<header class="head-bottom-border-style">
    <div class="header-content">
        <div class="header-content-inner innerpage-heading text-left">
            <h2 id="homeHeading">Order Details</h2>
            <hr>
            <p>Check your order details</p>
            <!--<a href="#about" class="btn btn-primary btn-xl page-scroll">Enter Site</a>-->

        </div>
    </div>
</header>

<section id="Aboutus_Img_Grid">
    <div class="container">
        <div class="row">
		<div class="c-content-title-1">
                            <h3 class="c-center c-font-uppercase c-font-bold"></h3>
                            
                        </div>
            <table class="table table-bordered" style="margin-top:130px;">
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
					
                    foreach ($cart['shopping_cart']['items'] as $cart_item) {
                        ?>
                        <tr>
                            <td><?php echo $cart_item['id']; ?></td>
                            <td><?php echo $cart_item['name']; ?></td>
                            <td class="center"> $<?php echo number_format($cart_item['price'], 2); ?></td>
                            <td class="center"><?php echo $cart_item['qty']; ?></td>
                            <td class="center"> $<?php echo round($cart_item['qty'] * $cart_item['price'], 2); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">

            <div class="col-md-4" style="float:right">

                <table class="table" style="margin-top:20px;">
                    <tbody>
                        <tr>
                            <td><strong> Subtotal</strong></td>
                            <td> $<?php echo number_format($cart['shopping_cart']['subtotal'], 2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Shipping</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['shipping'], 2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Handling</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['handling'], 2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tax</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['tax'], 2); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Grand Total</strong></td>
                            <td>$<?php echo number_format($cart['shopping_cart']['subtotal'], 2); ?></td>
                        </tr>
                        <tr>
                            <td class="center" colspan="2"><a href="<?php echo site_url('frontend/express_checkout/SetExpressCheckout'); ?>"><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>


<div class="hr_Line"><hr></div> 
