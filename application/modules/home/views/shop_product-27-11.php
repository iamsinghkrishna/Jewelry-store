<style>
    .inicial_neck, .inicial_neck1{
        margin: 10px 3px 10px 3px;
        float: left;

    }
    label {
        padding: 6px 12px;
        background-color: #ccc;
        color: #fff;
        cursor: pointer
    }
    input[type=radio] {
        display: none;
    }
    .selected {
        background-color: #000;
    }

</style>
<section id="product_display_details">

    <div class="product-details-full">                            

        <div class="container">
            <?php if (!empty($product_details)) { ?>
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-sm-5">
                        <!--Start product slider-->

                        <div class="xzoom-container">
                            <?php if (!empty($product_details[0]['product_images_details'])) { ?>
                                <img class="xzoom3" src="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" xoriginal="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" />

                                <div class="xzoom-thumbs">

                                    <?php foreach ($product_details[0]['product_images_details'] as $id) { ?>

                                        <a href="<?php echo base_url($id['url']) ?>"><img class="xzoom-gallery3" width="80" src="<?php echo base_url($id['url']) ?>"  xpreview="<?php echo base_url($id['url']) ?>" title="The description goes here"></a>

                                    <?php } ?>

                                </div>

                                <?php
                            } else {
                                echo "<img src='".base_url('assets/images/product-no-image2.jpg')."'>";
                            }
                            ?>
                        </div>

                        <!--End product slider-->



                    </div>

                    <div class="col-md-7 col-lg-7 col-sm-7">

                        <div class="product-details-right">

                            <div class="breadcrumbs">

                                <span><?php echo $product_details[0]['product_name'] ?></span>

                            </div>

                            <h3 class="product-name"><?php echo $product_details[0]['product_name'] ?></h3>


                            <span class="price">


                                <?php
                                if (isset($product_details[0]['discounted_price'])
                                    && $product_details[0]['discounted_price'] != NULL) {
                                    ?>
                                    <ins>$<?php
                                        echo number_format(($product_details[0]['price']
                                            - $product_details[0]['discounted_price']),
                                            2);
                                        ?></ins>
                                    <del>$<?php
                                        echo number_format($product_details[0]['price'],
                                            2);
                                        ?></del>
                                <?php } else { ?>
                                    <ins>$<?php
                                        echo number_format($product_details[0]['price'],
                                            2);
                                        ?></ins>
                                <?php } ?>




                            </span>



                            <div class="short-descript">

                                <p><?php echo $product_details[0]['description']; ?></p>
                                
                            </div>

                            <form class="cart" enctype="multipart/form-data" method="post">

                                <input type="hidden" id="user_id" name="user_id" value="<?php
                                echo $user_id = $this->session->userdata('user_id');
                                ?>"/>

                                <input type="hidden" id="item_id_<?php echo $product_details[0]['id'] ?>" name="item_id" value="<?php echo $product_details[0]['id'] ?>"/>

                                <input type="hidden" id="name_<?php echo $product_details[0]['id'] ?>" name="name" value="<?php echo $product_details[0]['product_name'] ?>"/>

                                <?php
                                if (isset($product_details[0]['discounted_price'])
                                    && $product_details[0]['discounted_price'] != NULL) {
                                    ?>

                                    <input type="hidden" id="price_<?php echo $product_details[0]['id'] ?>" name="price" value="<?php
                                    echo floatval($product_details[0]['price']) - floatval($product_details[0]['discounted_price'])
                                    ?>"/>



                                <?php } else { ?>

                                    <input type="hidden" id="price_<?php echo $product_details[0]['id'] ?>" name="price" value="<?php echo $product_details[0]['price'] ?>"/>

                                <?php } ?>

                                <input type="hidden" id="img_url_<?php echo $product_details[0]['id'] ?>" name="img_url" value="<?php echo $product_details[0]['url'] ?>"/>

                                <input type="hidden" id="stock_<?php echo $product_details[0]['id'] ?>" name="stock" value="<?php echo $product_details[0]['quantity'] ?>"/>

                                <div class="quantity">



                                    <span>Quantity</span>

                                    <input type="number" size="4" class="input-text qty text" width="50" title="Qty" value="1" id="quantity_<?php echo $product_details[0]['id'] ?>" name="quantity" min="1" step="1">

                                </div>

                                <div><?php
                                    if ($product_details[0]['quantity'] < 1) {
                                        echo "<span style='color:red'>Out of stock</span>";
                                    }
                                    if ($product_details[0]['quantity'] <= 2 && $product_details[0]['quantity']
                                        > 0)
                                            echo "<span style='color:red'>Only ".$product_details[0]['quantity']." Left in stock</span>";
                                    ?></div>

                                <?php
                                if (!empty($product_details[0]['product_varient_details'])) {
                                    $vari   = array();
                                    $newarr = array();
                                    $i      = 0;
                                    foreach ($product_details[0]['product_varient_details'] as $varient) {
                                        if (!in_array($varient['varient_name'],
                                                $vari)) {
                                            array_push($vari,
                                                $varient['varient_name']);
                                            $i                                    = 0;
                                            $newarr[$varient['varient_name']][$i]
                                                = $varient['varient_value'];
                                            $i++;
                                        } else {
                                            $newarr[$varient['varient_name']][$i]
                                                = $varient['varient_value'];
                                            $i++;
                                        }
                                    }
                                    ?><div id="getVarients">
                                    <?php foreach ($newarr as $key => $na) { ?>

                                            <input type="hidden" id="varid<?php echo $key ?>" value="<?php echo $key ?>">

                                            <div class="clearfix margin-top-20"></div>
                                            <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0"><?php echo $key; ?></span>
                                            <div class="col-md-10 col-xs-10">
                                                <select onchange="getVarientDetails(this.value,<?php echo $product_details[0]['id'] ?>)" id="getvar<?php echo $key ?>" name="initial">
                                                    <?php foreach ($na as $nn) { ?>
                                                        <option value="<?php echo $nn; ?>"><?php echo $nn; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php
                                        }
                                        echo "</div>";
                                    }
//                                echo "<pre>";
//                                print_r($newarr);die;
                                    ?>


                                    <div class="clearfix"></div>
                                    <?php
                                    $catar = explode(',',
                                        $product_details[0]['sub_category_id']);
                                    if (in_array('39', $catar)) {
                                        ?>

                                        <div class="clearfix margin-top-20"></div>
                                        <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Inicial</span>
                                        <div class="col-md-10 col-xs-10">
                                            <select id="getinicial" name="initial">
                                                <!--							  <option value="A" selected>A</option>
                                                                                                          <option value="B">B</option>
                                                                                                          <option value="C">C</option>
                                                                                                          <option selected value="D">D</option>
                                                <!--<option value="E">E</option>-->
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <!--<option value="H">H</option>-->
                                                <option value="I">I</option>
                                                <!--<option value="J">J</option>-->
                                                <option value="K">K</option>
                                                <!--<option value="L">L</option>-->
                                                <!--							  <option value="M">M</option>
                                                                                                          <option value="N">N</option>
                                                                                                          <option value="O">O</option>
                                                                                                          <option value="P">P</option>
                                                                                                          <option value="Q">Q</option>-->
                                                <option value="R">R</option>
                                                <!--							  <option value="S">S</option>
                                                                                                          <option value="T">T</option>
                                                                                                          <option value="U">U</option>
                                                                                                          <option value="V">V</option>
                                                                                                          <option value="W">W</option>
                                                                                                          <option value="X">X</option>
                                                                                                          <option value="Y">Y</option>
                                                                                                          <option value="Z">Z</option>-->
                                            </select>
                                        </div>
                                        <div class="clearfix margin-bottom-20"></div>


                                        <div class="clearfix margin-top-20"></div>
                                        <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">Color</span>
                                        <div class="col-md-10 col-xs-10">
                                            <select id="getcolor" name="getcolor">
                                                <option value="White" selected>White</option>
                                                <option value="Pink">Pink</option>
                                                <option value="Gold">Gold</option>
                                            </select>
                                        </div>
                                        <div class="clearfix margin-bottom-20"></div>

                                    <?php } ?>


                                    <ul style="margin-top: 20px">

                                        <li> <a class="new-btn cart-dis" data-quantity="1"  href="javascript:;" onclick="funAddToCart(<?php echo $product_details[0]['id'] ?>)">ADD TO CART</a></li>
                                        <?php
                                        if ($this->session->userdata('user_id') != '') {
                                            ?>
                                            <li> <a class="new-btn" data-quantity="1"  href="javascript:;" id="wishlist" onclick="funAddTwishlist(<?php echo $product_details[0]['id'] ?>)">ADD TO WISHLIST</a></li>
                                        <?php } else { ?>
                                            <li> <a class="new-btn" data-quantity="1"  href="javascript:;" id="wishlist" onclick="funAddTwishlist_login()">ADD TO WISHLIST</a></li>
                                        <?php } ?>

                                    </ul>



                            </form>

                            <hr>

                            <div class="share_on_sm">

                                <h4>SHARE ON</h4>

                                <?php $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>

                                <ul class="social_icons_footer">

                                    <li>

                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                                    </li>

                                    <li>

                                        <a href="https://twitter.com/home?status=<?php echo $actual_link; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                                    </li>



                                </ul>



                            </div>

                        </div>

                    </div>

                </div>
            <?php } else { ?>
                <div class="row" style="text-align: center; margin-bottom: 50px;"><h3>Either this product is not active or removed by admin</h3></div>
            <?php } ?>

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





<script>

// Example of adding a item to the cart via a link.
    function  funAddToCart(id) {
        var total_quantity = $('#quantity_' + id).val();
        $(".cart-dis").html('ADDING <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        $(".cart-dis").prop('disabled', true);
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
                            $.toaster({priority: 'danger', title: 'Cart', message: 'Selected product quantity is not available but you can order it.It will take approx 2 weeks for shipment.'});
                            $('.cart-dis').attr('onclick', '').unbind('click');
                            $('.cart-dis').attr('onclick', 'funAddToCartSuccessCheckAvailable(' + id + ',"1")').bind('click');
                            $(".cart-dis").html('ORDER IN ADVANCE');
                            $(".cart-dis").prop('disabled', false);
                        }
                    }
                }
        );

        //funAddToCartSuccess(id);
    }

    function funAddToCartSuccessCheckAvailable(id, prebook) {
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
                            funAddToCartSuccess(id, '1');
                        }
                    }
                }
        );
    }

    function funAddToCartSuccess(id, prebook)
    {

        var item_id = $('#item_id_' + id).val();
        var name = $('#name_' + id).val();
        var price = $('#price_' + id).val();
        var item_url = $('#img_url_' + id).val();
        var quantity = $('#quantity_' + id).val();
        var stock_quantity = $('#stock_' + id).val();
        var init = $('#getinicial').val();
        var color = $('#getcolor').val();

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
        if (prebook === '1') {
            var prebook = 'true';
        } else {
            var prebook = 'false';
        }
        var data1 = {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url, 'quantity': quantity, 'stock_quantity': stock_quantity, 'prebook': prebook, 'init': init, 'color': color};
        data1['options'] = {};
        $("#getVarients").children("input[type=hidden]").each(function () {
            var varient_value = $("#getvar" + $(this).val()).val();
            var varient_key = $(this).val();
            data1['options'][varient_key] = varient_value;
        });
        //event.preventDefault();
        $.ajax(
                {
                    method: "POST",
                    data: data1,
                    url: href = "<?php echo base_url(); ?>standard_library/insert_ajax_link_item_to_cart/" + id,
                    success: function (data)
                    {
                        var parsed = $.parseJSON(data);

//                        alert(JSON.stringify(parsed.content));

                        $.toaster({priority: 'success', message: 'Product added'});
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
                        $(".cart-dis").html('ADDED <i class="fa fa-check" aria-hidden="true"></i>');
                        $(".cart-dis").prop('disabled', false);
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
        $("#wishlist").html('ADDING <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        $("#wishlist").prop('disabled', true);
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
                    $("#wishlist").html('ADDED <i class="fa fa-check" aria-hidden="true"></i>');
                    $("#wishlist").prop('disabled', false);
                    $.toaster({priority: 'success', title: 'Wishlist', message: 'Product has been added to the wishlist.'});
                }
                if (parsed.status == 400)
                {
                    $("#wishlist").html('ADD TO WISHLIST');
                    $("#wishlist").prop('disabled', false);
                    $.toaster({priority: 'danger', title: 'Wishlist', message: 'Already added to the wishlist.'});
                }



            }
        });

    }

    function getVarientDetails(val, id)
    {
        var item_id = $('#item_id_' + id).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>home/getVarientDetails',
            data: 'product_id=' + item_id + '&varient=' + val,
            success: function (data)
            {

                var parsed = $.parseJSON(data);
                console.log(parsed.status);
                if (parsed.status == "1")
                {
                    $(".price").html("$" + parsed.price);
                    $("#price_" + id).val(parsed.price);
                    $(".short-descript").html(parsed.desc);
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

    $(function () {
        $('.inicial_neck input[name="initial"]').each(function (index) {
            console.log($(this));
            $(this).attr('id', 'radio' + index);
            var label = $('<label />', {'for': 'radio' + index}).html($(this).parent().html());
            $(this).parent().empty().append(label);
        });
        $('.inicial_neck label').click(function () {
            $('.inicial_neck label').removeClass('selected');
            $(this).addClass('selected');
        });
    });
    $(function () {
        $('.inicial_neck1 input[name="color"]').each(function (index) {
            console.log($(this));
            $(this).attr('id', 'radio1' + index);
            var label = $('<label />', {'for': 'radio1' + index}).html($(this).parent().html());
            $(this).parent().empty().append(label);
        });
        $('.inicial_neck1 label').click(function () {
            $('.inicial_neck1 label').removeClass('selected');
            $(this).addClass('selected');
        });
    });
</script>