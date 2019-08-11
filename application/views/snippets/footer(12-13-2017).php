    
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<section class="instagram_feeds">
    <div class="header_title">
        <img class="insta_img" src="<?php echo base_url() ?>assets/images/Insta.png"> 
        <h2><span class="headline"></span>Shop Our Instagram <span class="headline"></span></h2>
    </div>

    <div class="insta_images">


        <?php
        $i=0;
        $product_insta_images = array();
        if (!empty($product_details_instagram)) {
            foreach ($product_details_instagram as $key => $images) {
                if ($key <= 7) {
                    $product_insta_images[]='https://' . $images['instagram_image'];
                    ?>
                    <div class="col-md-3 col-xs-6">
                        <img src="<?php echo 'https://' . $images['instagram_image']; ?>">
                        <a style="cursor:pointer;" onclick="addToCartInstagram('<?php echo 'https://' . $images['instagram_image']; ?>')" target="_blank"><div class="details">Shop Now</div></a>
                    </div>
                    <?php
                    $i++;
                }
            }
        }
        ?>

        <?php
        //echo '<pre>';print_R($insta_feeds);die;
            if($i < 8){
                    if (!empty($insta_feeds)) {
                    foreach ($insta_feeds as $keys => $images) {
                        if ($i <= 7) {
                            if (in_array($images, $product_insta_images)){

                            }else{
                            ?>
                                <div class="col-md-3 col-xs-6">
                                    <img src="<?php echo $images; ?>">

                                </div>
                                <?php
                                $i++;
                            }
                        }
                    }
                }
          }
        ?>

    </div>
    <div class="clearfix"></div>
</section>


<div class="block-paralax5 bg-parallax no-margin footer-custom">
		<div class="container">
			<div class="head">
				<h3 class="title">newsletter</h3>
				<span class="sub-title">Subscribe to our newsletters and don’t miss our exclusive offers and promotions.</span>
			</div>
			<div class="col-lg-offset-1 col-sm-12 col-lg-10">
				<div class="block-newletter style3">
					<div class="form">
						<div class="desc">
							<!--span class="text-primary">Get <span class="big-text">50%</span> off</span>
							<span>On your next purchase!</span-->
							<p style="color:#fff; font-size: 12px;">
							Help us in creating a community of conscious women who stay upbeat with their taste for jewelry 
							and rule the fashion pack. Subscribe to our weekly newsletter to have all the inside scoop on our 
							brand new avant-garde collection at Vaskia.
							</p>
						</div>
						<div class="newletter-wapper">
							<form class="newletter" action="<?php echo base_url() ?>admin/newsletter_subscriber/addNewsletterSubscriber" method="post">
								<input class="email-text" name="user_email" required type="email" value="" placeholder="Your email address here...">
								<input type="submit" value="SUBSCRIBE" class="button">
							</form>
							<?php if($this->session->flashdata('error')) ?>
							<div id="footernews" class="error"><?php echo $this->session->flashdata('error') ?></div>
							
							<?php if($this->session->flashdata('msg')) ?>
							<div id="footernews" class="success"><?php echo $this->session->flashdata('msg') ?></div>
						</div>
					</div>
				</div>
			</div>

            <div class="new-footer-social-links">
                <ul>
                    <li>
                        <a href="<?php echo config_item('facebook_link')?>" target="_blank" class="fb"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="<?php echo config_item('instagram_link')?>" target="_blank" class="insta"><i class="fa fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="<?php echo config_item('twitter_link')?>" target="_blank" class="ld"><i class="fa fa-twitter"></i></a>
                    </li>
                     <!--li>
                        <a href="" target="_blank" class="insta"><i class="flaticon-social-media"></i></a>
                    </li-->
                </ul>
            </div>

		</div>
</div>



<!-- Brand -->
<footer class="main_footer_2 footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="footer_menu_div_2">								
                    <div class="footer_menu">				
                        <ul>				
                            <li><a href="<?php echo base_url() ?>home/about_us">About</a></li>				
                            <li><a href="<?php echo base_url() ?>home/return_and_exchange">Returns & Exchanges</a></li>				
                            <li><a href="<?php echo base_url() ?>home/shipping">Shipping</a></li>				
                            <li><a href="<?php echo base_url() ?>home/faq">FAQ's</a></li>
                            <li><a href="<?php echo base_url() ?>home/contact_us">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- Instagram images add to cart pop up start here --->
    <div class="modal fade product_view" id="instadetails">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                    <h3 class="modal-title">Product Details</h3>
                </div>
                <div class="modal-body">
                    <div class="row" id="instagram_product_details_div">
                        <center>

                            <img src="<?php echo base_url() ?>assets/images/xloading.gif" />
                        </center>

                    </div>
                </div>
            </div>
        </div>
    </div>


	
<script type="text/javascript">
      function addToCartInstagram(image) {

        if (image != '') {
            $('#instadetails').modal('show');
            var str = '';
            var str = '<center><img src="<?php echo base_url() ?>assets/images/xloading.gif" /></center>';
            $('#instagram_product_details_div').html(str);
            $.ajax({
                url: '<?php echo base_url(); ?>' + 'home/instagramImage',
                async: false,
                type: "POST", //The type which you want to use: GET/POST
                data: "image=" + image, //The variables which are going.
                dataType: "html", //Return data type (what we expect).

                //This is the function which will be called if ajax call is successful.
                success: function (data) {
                    var res = data.split("+++");
                    //alert(res[1]);
                    $('#instagram_product_details_div').html(res[0]);
                    $('#product_id_insta').val(res[1]);

                }
            });
        }
    }

    function funAddToCartInsta(id) {
   var total_quantity = $('#quantity_insta_' + id).val();
        if (total_quantity <= 0) {
            $('#errormsgforqtyinsta').html("Value must be greater than 0");
            $('#quantity_insta_' + id).val("");
            return false;
        }

        if($("#stock_insta_"+id).val() < total_quantity){
            $('#errormsgforqty').html("Only "+$("#stock_insta_"+id).val()+" item left in stock");
            return false;
        }
        $('#quantity_insta_' + id).next("span").remove();
        $(".cart-dis-insta").html('ADDING <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        $(".cart-dis-insta").prop('disabled', true);
        
        $.ajax(
                {
                    method: "POST",
                    dataType: 'JSON',
                    data: {'id': id, 'total_quantity': total_quantity},
                    url: "<?php echo base_url(); ?>home/checkProductQuantityAvailable",
                    success: function (response)
                    {
                        if (response.status === '1') {
                            funAddToCartInstaSuccess(id);
                        } else {
                            $('.cart-dis-insta').attr('onclick', '').unbind('click');
                            $('.cart-dis-insta').attr('onclick', 'funAddToCartInstaSuccess(' + id + ',"1")').bind('click');
                            $(".cart-dis-insta").html('ORDER IN ADVANCE?');
                            $(".cart-dis-insta").prop('disabled', false);
                            $.toaster({priority: 'danger', title: 'Cart', message: 'Selected product quantity is not available but you can order it.It will take approx 2 weeks for shipment.'});
                        }
                    }
                }
        );
    }


    function funAddToCartInstaSuccess(id, prebook)
    {
        if (id != '') {
           var item_id = $('#item_id_insta_' + id).val();
            var name = $('#name_insta_' + id).val();
            var price = $('#price_insta_' + id).val();
            var item_url = $('#img_url_insta_' + id).val();
            var quantity = $('#quantity_insta_' + id).val();
            var stock_quantity = $('#stock_insta_' + id).val();
            var init = $('input[name=initial]:checked').val();
            var color = $('input[name=color]:checked').val();
        var variantup = $('#variantUp').val();
        if (init === '') {
            init = "";
        } else {
            init = init;
        }
        if (color === '') {
            color = "";
        } else {
            color = color;
        }
        if (color === '') {
            variantup = "";
        } else {
            variantup = variantup;
        }
        if (prebook === '1') {
            var prebook = 'true';
        } else {
            var prebook = 'false';
        }
            //event.preventDefault();
            $.ajax(
                    {
                        method: "POST",
                        data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url, 'quantity': quantity, 'stock_quantity': stock_quantity, 'prebook': prebook, 'init': init, 'color': color, 'variant': variantup},
                        url: href = "<?php echo base_url(); ?>standard_library/insert_ajax_link_item_to_cart/" + id,
                        success: function (data)
                        {
                            var parsed = $.parseJSON(data);

//                        alert(JSON.stringify(parsed.content));

                            $.toaster({priority: 'success', title: 'Cart', message: 'Product has been added to the cart.'});
                            var cart_count = JSON.stringify(parsed.content['summary']['total_rows']);
                            var cart_total = JSON.stringify(parsed.content['summary']['total']);
//                        alert("count is "+ cart_count);
//                        $('#id_cart_total').text('');
                            $('#id_total').text('');
                            $('.id_cart_total').html("(" + cart_count + ")");
//                        $('#id_cart_total').html(cart_count);
                            $('#id_total').text(cart_total);
                            $(".item shopping-cart").show();
                            $(window).scrollTop(0);
                            $(".cart-dis-insta").html('Added <i class="fa fa-check" aria-hidden="true"></i>');
                            $(".cart-dis-insta").prop('disabled', true);
                            return false;
//                        ajax_update_mini_cart(data);
                        }
                    }
            );
        }
    }


    function funAddTwishlistInsta(id)
    {
        $(".cart-wish-insta").html('ADDING <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        $(".cart-wish-insta").prop('disabled', true);
        var item_id = $('#item_id_insta_' + id).val();
        var user_id = $('#user_id_insta').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>home/add_wishlist/add',
            data: 'product_id=' + item_id + '&user_id=' + user_id,
            success: function (data)
            {

                var parsed = $.parseJSON(data);
                console.log(parsed.status);
                if (parsed.status == 200)
                {
                    $.toaster({priority: 'success', title: 'Wishlist', message: 'Product has been added to the wishlist.'});
                    $(".cart-wish-insta").html('ADDED <i class="fa fa-check" aria-hidden="true"></i>');
                    $(".cart-wish-insta").prop('disabled', false);
                }
                if (parsed.status == 400)
                {
                    $(".cart-wish-insta").html('ADD TO WISHLIST <i class="fa fa-check" aria-hidden="true"></i>');
                    $(".cart-wish-insta").prop('disabled', false);
                    $.toaster({priority: 'danger', title: 'Wishlist', message: 'Already added to the wishlist.'});
                }



            }
        });

    }

    function funAddTwishlist_login_insta()
    {
        $.toaster({priority: 'info', title: 'Info', message: 'Please Login'});
    }
</script>
