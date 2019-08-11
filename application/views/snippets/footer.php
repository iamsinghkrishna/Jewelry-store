
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<section class="instagram_feeds">
<div class="container">
    <div class="header_title">
        <img class="insta_img" src="<?php echo base_url() ?>assets/images/Insta.png">
        <h2><span class="headline"></span>Shop Our Instagram <span class="headline"></span></h2>
    </div>

    <div class="insta_images">

    <ul  class="product-list-grid desktop-columns-4 tablet-columns-3 mobile-columns-1 row flex-flow">
        <?php

$product_details_instagram = $this->data['insta_feeds'];
$i = 0;
$product_insta_images = array();
foreach ($product_details_instagram as $key => $product) {
    if ($key > 7) {
        break;
    }
    ?>
            <li class="product-item col-sm-3">
                <div class="product-inner">
                    <div class="product-thumb has-back-image">
                        <a href="<?php echo base_url() ?>home/shop_product/<?php echo $product['product_id'] ?>/<?php echo base64_encode($product['category_id']) ?>"><img src="<?php echo base_url($product['url']) ?>" alt="" ></a>
                        <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $product['product_id'] ?>/<?php echo base64_encode($product['category_id']) ?>"><img src="<?php echo ($product['hover_img_url'] != '' || file_exists(base_url($product['hover_img_url']))) ? base_url($product['hover_img_url']) : base_url($product['url']) ?>" alt="" ></a>
                        <div class="col-md-12 text-center no-padding">
                            <div class="product-info">
                                <div class="">
                                    <h2 class="product-name"><a href="<?php echo base_url() ?>home/shop_product/<?php echo $product['id'] ?>/<?php echo base64_encode($product['category_id']); ?>"><?php echo $product['product_name'] ?></a></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php }?>
    </ul>

    </div>
    <div class="clearfix"></div>
    </div>
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
							<?php if ($this->session->flashdata('error')) {
    ;
}
?>
							<div id="footernews" class="error"><?php echo $this->session->flashdata('error') ?></div>

							<?php if ($this->session->flashdata('msg')) {
    ;
}
?>
							<div id="footernews" class="success"><?php echo $this->session->flashdata('msg') ?></div>
						</div>
					</div>
				</div>
			</div>

            <div class="new-footer-social-links">
                <ul>
                    <li>
                        <a href="<?php echo config_item('facebook_link') ?>" target="_blank" class="fb"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="<?php echo config_item('instagram_link') ?>" target="_blank" class="insta"><i class="fa fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="<?php echo config_item('twitter_link') ?>" target="_blank" class="ld"><i class="fa fa-twitter"></i></a>
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
    var inicial_product_available = $('#inicial_product_available_insta').val();

        //if(inicial_product_available != 1){
        if (total_quantity <= 0) {
            $('#errormsgforqtyinsta').html("Value must be greater than 0");
            $('#quantity_insta_' + id).val("");
            return false;
        }

        if($("#stock_insta_"+id).val() < total_quantity){
            $('#errormsgforqty').html("Only "+$("#stock_insta_"+id).val()+" item left in stock");
            return false;
        }

       // }

//        if(inicial_product_available == 1){
//             if (total_quantity <= 0) {
//
//                $('#errormsgforqty').html("Value must be greater than 0");
//                $('#quantity_insta_' + id).val("");
//                return false;
//            }
//
//            var getinicial = $('#getinicial_insta').val();
//            var color = $('#getcolor_insta').val();
//            var getinicialmm = $('#getinicialmm_insta').val();
//            if(getinicial != '' && color != '' && getinicialmm != '' && total_quantity > 0){
//                $.ajax(
//                    {
//                        method: "POST",
//                        dataType: 'JSON',
//                        data: {'getinicial': getinicial, 'color': color, 'getinicialmm': getinicialmm, 'total_quantity': total_quantity},
//                        url: "<?php echo base_url(); ?>home/checkProductQuantityAvailableInicial",
//                        success: function (response)
//                        {
//                        if (response.status === '1'){
////                            var new_product_price = number( true, response.new_price );
////                            $('#new_product_price').html(response.new_price);
//                                $('#item_id_insta_'+id).val(response.new_item_id);
//                                $('#stock_insta_'+id).val(response.new_stock);
//                                $('#name_insta_'+id).val(response.new_name);
//                                $('#img_url_insta_'+id).val(response.new_img_url);
//                                $('#price_insta_'+id).val(response.new_price);
//                                //alert(response.new_product_id);
//                            funAddToCartInstaSuccess(id, '0');
//                        }else if(response.status === '3'){
//                            $.toaster({priority: 'danger', title: 'Cart', message: 'This product is out of stock and can not be pre ordered.'});
//                            $(".cart-dis-insta").html('Add to cart');
//                            $(".cart-dis-insta").prop('disabled', false);
//                            return false;
//                        } else{
//
//                            $('#item_id_insta_'+id).val(response.new_item_id);
//                            $('#stock_insta_'+id).val(response.new_stock);
//                            $('#name_insta_'+id).val(response.new_name);
//                            $('#img_url_insta_'+id).val(response.new_img_url);
//                            $('#price_insta_'+id).val(response.new_price);
//                            $.toaster({priority: 'danger', title: 'Cart', message: 'Selected product quantity is not available but you can order it.It will take approx 2 weeks for shipment.'});
//                            $('.cart-dis-insta').attr('onclick', '').unbind('click');
//                            $('.cart-dis-insta').attr('onclick', 'funAddToCartSuccessCheckAvailableInsta(' + response.new_item_id + ',"1")').bind('click');
//                            $(".cart-dis-insta").html('ORDER IN ADVANCE');
//                            $(".cart-dis-insta").prop('disabled', false);
//                        }
//                        }
//                    }
//                );
//            }
//
//            if($("#stock_"+id).val() < total_quantity){
//
//                $('#errormsgforqty').html("Only "+$("#stock_"+id).val()+" item left in stock");
//                return false;
//            }
//        }
       // else{
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
    //}
    }


    function funAddToCartInstaSuccess(id, prebook)
    {
        var inicial_product_available = $('#inicial_product_available_insta').val();
         var product_not_available = 0;
//        if(inicial_product_available == 1){
//            var total_quantity = $('#quantity_insta_' + id).val();
//             if (total_quantity <= 0) {
//
//                $('#errormsgforqty').html("Value must be greater than 0");
//                $('#quantity_' + id).val("");
//                return false;
//            }
//
//            var getinicial = $('#getinicial_insta').val();
//            var color = $('#getcolor_insta').val();
//            var getinicialmm = $('#getinicialmm_insta').val();
//
//            if(getinicial != '' && color != '' && getinicialmm != '' && total_quantity > 0){
//                $.ajax(
//                    {
//                        method: "POST",
//                        dataType: 'JSON',
//                        data: {'getinicial': getinicial, 'color': color, 'getinicialmm': getinicialmm, 'total_quantity': total_quantity},
//                        url: "<?php echo base_url(); ?>home/checkProductQuantityAvailableInicial",
//                        success: function (response)
//                        {
//
//                        if (response.status === '1'){
////                             var new_product_price = number( true, response.new_price );
////                             $('#new_product_price').html(response.new_price);
//
//                              var back_order_flag = response.back_order_flag;
//
//                              if(back_order_flag == 'no'){
//                                prebook = 0;
//                                $(".cart-dis-insta").html('Add to cart');
//                              }else{
//                                  prebook = 1;
//                                  $(".cart-dis-insta").html('Pre-Order');
//                              }
//                                $('#item_id_insta_' + id).val(response.new_item_id);
//                                $('#stock_insta_'+id).val(response.new_stock);
//                                $('#name_insta_'+id).val(response.new_name);
//                                $('#img_url_insta_'+id).val(response.new_img_url);
//                                $('#price_insta_'+id).val(response.new_price);
//
//                           // funAddToCartSuccess(id, '1');
//                           $('.cart-dis-insta').attr('onclick', 'funAddToCartSuccessCheckAvailableInsta(' + response.new_item_id + ',"1")').bind('click');
//                        }else if(response.status === '3'){
//                            product_not_available = 1;
//                            $.toaster({priority: 'danger', title: 'Cart', message: 'This product is out of stock and can not be pre ordered.'});
//                            $(".cart-dis-insta").html('Add to cart');
//                            $(".cart-dis-insta").prop('disabled', false);
//                            return false;
//                        } else {
////                            var new_product_price = number( true, response.new_price );
////                            $('#new_product_price').html(response.new_price);
//                            $('#item_id_insta_' + id).val(response.new_item_id);
//                            $('#stock_insta_'+id).val(response.new_stock);
//                            $('#name_insta_'+id).val(response.new_name);
//                            $('#img_url_insta_'+id).val(response.new_img_url);
//                            $('#price_insta_'+id).val(response.new_price);
//                            //$.toaster({priority: 'danger', title: 'Cart', message: 'Selected product quantity is not available but you can order it.It will take approx 2 weeks for shipment.'});
////                            $('.cart-dis').attr('onclick', '').unbind('click');
////                            $('.cart-dis').attr('onclick', 'funAddToCartSuccessCheckAvailable(' + response.new_item_id + ',"1")').bind('click');
////                            $(".cart-dis").html('ORDER IN ADVANCE');
////                            $(".cart-dis").prop('disabled', false);
//                        }
//                        }
//                    }
//                );
//            }
//        }
         //setTimeout(function(){
        if (id != '' ) {
           var item_id = $('#item_id_insta_' + id).val();

            var name = $('#name_insta_' + id).val();
            var price = $('#price_insta_' + id).val();
            var item_url = $('#img_url_insta_' + id).val();
            var quantity = $('#quantity_insta_' + id).val();
            var stock_quantity = $('#stock_insta_' + id).val();
//            var init = $('input[name=initial]:checked').val();
//            var color = $('input[name=color]:checked').val();
        var init = $('#getinicial_insta').val();
        var color = $('#getcolor_insta').val();
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
        // }, 3000);
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


    function funAddToCartSuccessCheckAvailableInsta(id, prebook) {
        var total_quantity = $('#quantity_' + id).val();

        $.ajax(
                {
                    method: "POST",
                    dataType: 'JSON',
                    data: {'id': id, 'total_quantity': total_quantity},
                    url: "<?php echo base_url(); ?>home/checkProductQuantityAvailable",
                    success: function (response)
                    {
                        if (response.status === '1') {
                            funAddToCartSuccess(id, '0');
                        } else if (response.status === '3') {
                            $.toaster({priority: 'danger', title: 'Cart', message: 'This product is out of stock and can not be pre ordered.'});
                            $(".cart-dis").html('Add to cart');
                            $(".cart-dis").prop('disabled', false);
                        } else {
                            funAddToCartInstaSuccess(id, '1');
                        }
                    }
                }
        );
    }



    function getInicialProductsInsta(){
        var initial_letter = $('#getinicial_insta').val();
        var initial_color = $('#getcolor_insta').val();
        var initial_mm = $('#getinicialmm_insta').val();
        if(initial_letter != '' && initial_color != '' && initial_mm != ''){
            $.ajax({
                   url: '<?php echo base_url() ?>home/getInicialProductsInsta',
                    async: false,
                    type: "POST", //The type which you want to use: GET/POST
                    //data: "id=" + id, //The variables which are going.
                    data: {
                        initial_letter: initial_letter,
                        initial_color: initial_color,
                        initial_mm: initial_mm,
                    },
                    dataType: "html", //Return data type (what we expect).

                    //This is the function which will be called if ajax call is successful.
                    success: function (data){
                       // $('#submainProductDiv').css('display','none');
                       // $('#loader_img').css('display','block');

                        if(data != '' && data != 1){

                             var res = data.split("+++");
                            //alert(res[1]);
                            $('#instagram_product_details_div').html(res[0]);
                            $('#product_id_insta').val(res[1]);
                            //$('#mainProductDiv').html(data);
                        }else{
                            $.toaster({priority: 'danger', title: 'Wishlist', message: 'Selected product is not available,please check for another combination.'});
                            $('#submainProductDiv').css('display','inline');
                            $('#loader_img').css('display','none');
                        }
                    }
                });
        }
    }
     function getVariantProducts(id)
    {
        var item_id = id;
        window.location.href = "<?php echo base_url() ?>home/shop_product/" + item_id;

    }
</script>
