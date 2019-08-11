
<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

            <h2><?php echo $product_details[0]['product_name'] ?></h2>

        </div>
    </div>
</div>
<section id="product_display_details">

    <div class="product-details-full">                            

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-5 col-sm-12">



                    <!--Start product slider-->

                    <div class="xzoom-container">

                        <img class="xzoom3" src="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" xoriginal="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" />

                        <div class="xzoom-thumbs">

                            <?php foreach ($product_details[0]['product_images_details'] as $id) { ?>

                                <a href="<?php echo base_url($id['url']) ?>"><img class="xzoom-gallery3" width="80" src="<?php echo base_url($id['url']) ?>"  xpreview="<?php echo base_url($id['url']) ?>" title="The description goes here"></a>

                            <?php } ?>

                        </div>

                    </div>

                    <!--End product slider-->



                </div>



                <!--                <div class="product-detail-image">

                <?php foreach ($product_details[0]['product_images_details'] as $id) { ?>

                                                                                                                                                                                                                                                                            <div id="demo" class="main-image-wapper">

                                                                                                                                                                                                                                                                                <img src="<?php echo base_url($id['url']) ?>" data-src="<?php echo base_url($id['url']) ?>">

                                                                                                                                                                                                                                                                            </div>

                <?php } ?>

                                        <div class="detail_tumbnail">

                <?php foreach ($product_details[0]['product_images_details'] as $id) { ?>

                                                                                                                                                                                                                                                                                <a data-url="<?php echo base_url($id['url']) ?>" class="active" href="#">

                                                                                                                                                                                                                                                                                    <img src="<?php echo base_url($id['url']) ?>" alt=""></a>

                <?php } ?>

                

                                        </div>

                

                                    </div>-->

                <div class="col-md-8 col-lg-7 col-sm-12">

                    <div class="product-details-right">

                        <div class="breadcrumbs">

                            <span><?php echo $product_details[0]['product_name'] ?></span>

                        </div>

                        <h3 class="product-name"><?php echo $product_details[0]['product_name'] ?></h3>

<!--                <p class="meta-info clearfix">
                        <span class="kopa-rating">
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <?php if ($i < $average_rating) { ?>
                                    <span class="fa fa-star"></span>                                   
                                <?php } else { ?>
                                    <span class="fa fa-star-o"></span>
                                <?php } ?>
                            <?php } ?>


                        </span>
                        <span class="review"><?php echo count($all_review) ?> Review</span>
                        <?php if ($this->ion_auth->logged_in()) { ?>
                            <?php echo $check; if (isset($check))  ?> 
                            <?php
                            if ($check == true) {
                                $user_id = $this->session->userdata('user_id');
                                foreach ($product_details as $d) {
                                    ?> 
                                    <a href="#" class="add-review" onclick="edit(<?php echo $d['id']; ?>,<?php echo $user_id; ?>)" data-toggle="modal" data-target="#reviewModal">Edit Review</a>
                                    <?php
                                }
                            }
                            ?> 
                            <?php if ($check == false) { ?> 

                                <a href="#" class="add-review" data-toggle="modal" data-target="#reviewModal">Add your review</a>
                            <?php } ?> 
                        <?php } ?>
                    </p>-->

                        <span class="price">

                            <ins>$<?php echo $product_details[0]['price']; ?></ins>

                            <del>$<?php echo $product_details[0]['price']; ?></del>

                        </span>



                        <div class="short-descript">

                            <p><?php echo $product_details[0]['description']; ?></p>

                        </div>  

                        <form class="cart" enctype="multipart/form-data" method="post">

                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id = $this->session->userdata('user_id'); ?>"/>

                            <input type="hidden" id="item_id_<?php echo $product_details[0]['id'] ?>" name="item_id" value="<?php echo $product_details[0]['id'] ?>"/>

                            <input type="hidden" id="name_<?php echo $product_details[0]['id'] ?>" name="name" value="<?php echo $product_details[0]['product_name'] ?>"/>

                            <?php if (isset($product_details[0]['discounted_price']) && !empty($product_details[0]['discounted_price'])) { ?>

                                <input type="hidden" id="price_<?php echo $product_details[0]['id'] ?>" name="price" value="<?php echo floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price']) ?>"/>    



                            <?php } else { ?>

                                <input type="hidden" id="price_<?php echo $product_details[0]['id'] ?>" name="price" value="<?php echo $product_details[0]['price'] ?>"/>

                            <?php } ?>

                            <input type="hidden" id="img_url_<?php echo $product_details[0]['id'] ?>" name="img_url" value="<?php echo $product_details[0]['url'] ?>"/>

                            <input type="hidden" id="stock_<?php echo $product_details[0]['id'] ?>" name="stock" value="<?php echo $product_details[0]['quantity'] ?>"/>

                            <div class="quantity">



                                <span>Quantity</span>

                                <input type="number" size="4" class="input-text qty text" width="50" title="Qty" value="1" id="quantity_<?php echo $product_details[0]['id'] ?>" name="quantity" min="1" step="1">

                            </div>

                            <div class="clearfix"></div>

                            <ul style="margin-top: 20px">

                                <li> <a class="new-btn" data-quantity="1"  href="javascript:;" onclick="funAddToCart(<?php echo $product_details[0]['id'] ?>)">ADD TO CART</a></li>

                                <li> <a class="new-btn" data-quantity="1"  href="#" id="wishlist" onclick="funAddTwishlist(<?php echo $product_details[0]['id'] ?>)">ADD TO WISHLIST</a></li>

                            </ul>

                        </form>  

                        <hr>

                        <div class="share_on_sm">

                            <h4>SHARE ON</h4>

                            <?php $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>

                            <ul class="social_icons_footer">

                                <li>

                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                                </li>

                                <li>

                                    <a href="https://twitter.com/home?status=<?php echo $actual_link; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                                </li>

                                <li>

                                    <a><i class="fa fa-instagram" aria-hidden="true"></i></a>

                                </li>

                            </ul>



                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>







<div class="product_display">

    <div class="container">



        <div class="title_text_div">

            <h2>VASKIA ESSENTIALS</h2>

        </div>



        <ul class="product-list-grid desktop-columns-3 tablet-columns-3 mobile-columns-1 row flex-flow">

            <?php foreach ($essential as $pd) {

                ?>

                <li class="product-item col-sm-4">

                    <div class="product-inner">

                        <div class="product-thumb has-back-image">

                            <a href="#"><img src="<?php echo base_url($pd['url']) ?>" alt=""></a>

                            <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $pd['product_id'] ?>/<?php echo $pd['category_id'] ?>"><img src="<?php echo base_url($pd['hover_img_url']) ?>" alt=""></a>



                        </div>

                    </div>

                </li>

            <?php } ?>







        </ul>

    </div>

</div>

<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="searchFilterModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" id="modal_id" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="searchFilterModalLabel">Review</h4>
            </div>
            <div class="modal-body">


                <form method="post">
                    <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_details[0]['id'] ?>">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ratting:</label>
                                <!--<div rating_star></div>-->

                                <input type="hidden" class="form-control" id="rating_star" postId="1" value="1">

                                <input type="hidden" class="form-control" id="rating_star" postId="1">
                                <input type="hidden" class="form-control" id="editid" value="">

                                <div class="clearfix"></div>
                                <div class="overall-rating"> <span id="avgrat"><?php // echo  $review[0]['review_total']                                                    ?></span>
                                    <span id="totalrat"><?php // echo $review[0]['review_total'];                                                    ?></span>  </span></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <label>Description:</label>
                            <div class="form-group">
                                <textarea  class="form-control" placeholder="Description" name="dis" id="dis" required="" rows="5"></textarea>

                            </div>
                        </div>

                        <div class="col-md-12 text-center">

                            <button type="submit" class="button button-add-cart editReview" id="rating" >Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function () {
// edit(pid, uid);

        $("#rating_star").spaceo_rating_widget({
            starLength: 5,
            initialValue: <?php echo isset($review[0]['review_total']) ? $review[0]['review_total'] : '1'; ?>,
//        callbackFunctionName: 'processRating',
            imageDirectory: '<?php echo base_url();?>assets/img/',
            inputAttr: 'postID'
        });

        $('.editReview').click(function () {

            var id = $('#rating_star').val();
            var pid = $('#product_id').val();
            var dis = $('#dis').val();
            var editid = $('#editid').val();
            if (dis == '') {
                $('#dis').focus();

                return false;
            } else {
                $('#rating').prop("disabled", true);
            }



//        console.log(id);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>home/review_rating/review',
                data: 'product_id=' + pid + '&points=' + id + '&dis=' + dis + '&editid=' + editid,
                dataType: 'json',
                success: function (data) {
                    if (data)
                    {
                        window.location.reload();
                    }
                }
            });
        });
    });
    function edit(pid, uid) {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>home/review_rating/edit',
            data: 'pid=' + pid + '&uid=' + uid,
            dataType: 'json',
            success: function (data) {

//                var obj=JSON.parse(data);
//                console.log(data);
                $.each(data, function (key, val) {
//            alert(key+val);
//                    console.log(val.id);
//a(this).next("ul").children("li").slice(0,val.review_total).css('background-position','0px -28px')
                    $('#rating_star').val(val.review_total);
                    $('#product_id').val(val.product_id);
                    $('#dis').val(val.discription);
                    $('#editid').val(val.id);
                });
//                $('#avgrat').text(data.average_rating);
//                $('#totalrat').text(data.rating_number);

            }
        });
    }
//    $(document).ready(function () {
//        
//    });
// Example of adding a item to the cart via a link.
    function funAddToCart(id)
    {

        var item_id = $('#item_id_' + id).val();
        var name = $('#name_' + id).val();
        var price = $('#price_' + id).val();
        var item_url = $('#img_url_' + id).val();
        var quantity = $('#quantity_' + id).val();
        var stock_quantity = $('#stock_' + id).val();
        //event.preventDefault();
        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url, 'quantity': quantity, 'stock_quantity': stock_quantity},
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
                        $('.id_cart_total').html(cart_count);
//                        $('#id_cart_total').html(cart_count);
                        $('#id_total').text(cart_total);
                        $(".item shopping-cart").show();
                        $(window).scrollTop(0);
                        return false;
//                        ajax_update_mini_cart(data);
                    }
                }
        );
    }
    function funAddTwishlist(id)
    {
        var item_id = $('#item_id_' + id).val();
        var user_id = $('#user_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>home/add_wishlist/add',
            data: 'product_id=' + item_id + '&user_id=' + user_id,
            success: function (data)
            {
             
                var parsed = $.parseJSON(data);
                   console.log(parsed.status);
                if(parsed.status==200)
                {
                    $.toaster({priority: 'success', title: 'Wishlist', message: 'Product has been added to the wishlist.'});
                }
                if(parsed.status==400)
                {
                    $.toaster({priority: 'danger', title: 'Wishlist', message: 'Already added to the wishlist.'});
                }
                
                  
               
            }
        });

    }
  function funAddTwishlist_login()
    {
        $.toaster({priority: 'info', title: 'Info', message: 'Please Login'});
    }
    function ajax_update_mini_cart(data)
    {

        // Replace the current mini cart with the ajax loaded mini cart data. 
        var ajax_mini_cart = $(data).find('#mini_cart');
        $('#mini_cart').replaceWith(ajax_mini_cart);

        // Display a status within the mini cart stating the cart has been updated.
        $('#mini_cart_status').show();

        // Set the new height of the menu for animation purposes.
        var min_cart_height = $('#mini_cart ul:first').height();
        $('#mini_cart').attr('data-menu-height', min_cart_height);
        $('#mini_cart').attr('class', 'js_nav_dropmenu');

        // Scroll to the top of the page.
        $('body').animate({'scrollTop': 0}, 250, function ()
        {
            // Notify the user that the cart has been updated by showing the mini cart.
            $('#mini_cart ul:first').stop().animate({'height': min_cart_height}, 400).delay(3000).animate({'height': '0'}, 400, function ()
            {
                $('#mini_cart_status').hide();
            });
        });
    }
//    function fun_success_message(msg) {

//    }
</script>