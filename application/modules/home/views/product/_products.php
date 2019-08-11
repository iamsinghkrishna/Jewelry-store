<?php // echo '<pre>', print_r($product_details);die;                                            ?>
<?php // echo '<pre>', print_r($cart_items);                             ?>
<?php if (isset($product_details) && !empty($product_details)) { ?>
    <div id="main-col" class="col-md-9">   
        <div class="product-list-1">

            <div class="row">
                <h2>
                    SEARCH RESULT FOR 
                    <span class="text-danger"><?php echo $category_title ?></span>
                </h2>
                <?php $i = 1; ?>
                <?php foreach ($product_details as $pk => $pkData) { ?>
                    <div class="col-sm-6 col-md-4">
                        <article class="item">
                            <div class="item-top">
                                <a class="thumbnail" href="#">
                                    <span><img src="<?php echo base_url() . $pkData['url'] ?>" height="219" width="280" alt=""></span>
                                    <span class="hexagon-1">
                                        <span><i class="fa fa-mail-forward"></i></span>
                                    </span>
                                </a>    
                                <h6 class="product-title">
                                    <a href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>" title="<?php echo $pkData['product_name'] ?>">
                                        <?php if (strlen($pkData['product_name']) > 20) { ?>
                                            <?php echo substr($pkData['product_name'], 0, 18) . '..'; ?>
                                        <?php } else { ?>
                                            <?php echo $pkData['product_name'] ?>
                                        <?php } ?>

                                    </a></h6>
                                <span class="kopa-rating">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                </span>
                            </div>

                            <div class="price-box">                                    
                                <footer>
                                    <?php if (isset($pkData['discounted_price']) && !empty($pkData['discounted_price'])) { ?>
                                        <span class="old-price">$<?php echo $pkData['price'] ?></span>
                                        <span class="new-price">$<?php echo floatval($pkData['price']) - floatval($pkData['discounted_price']) ?></span>

                                    <?php } else { ?>
                                        <span class="new-price">$<?php echo $pkData['price'] ?></span>
                                    <?php } ?>

                                </footer>
                                <span class="white-bg"></span>
                                <a  onclick="funAddToCart(<?php echo $pkData['id'] ?>)"  class="add_item_via_ajax_link cart-icon"><i class="fa fa-shopping-cart"></i></a>  
                                <input type="hidden" id="item_id_<?php echo $pkData['id'] ?>" name="item_id" value="<?php echo $pkData['id'] ?>"/>
                                <input type="hidden" id="name_<?php echo $pkData['id'] ?>" name="name" value="<?php echo $pkData['product_name'] ?>"/>
                                <input type="hidden" id="price_<?php echo $pkData['id'] ?>" name="price" value="<?php echo $pkData['price'] ?>"/>
                                <input type="hidden" id="img_url_<?php echo $pkData['id'] ?>" name="img_url" value="<?php echo $pkData['url'] ?>"/>
                            </div>                            
                        </article>
                    </div>
                    <?php if ($i == 3) { ?>
                        <div class="clearfix"></div>

                        <?php
                        $i = 0;
                    }
                    ?>
                    <?php
                    $i++;
                }
                ?>

            </div>  


        </div>    

        <div class="kopa-divide"></div>  

        <div class="kopa-pagination clearfix">
            <ul class="clearfix">
                <?php // echo $this->pagination->create_links(); ?>    
                <li><a href="#" class="first page-numbers fa fa-angle-double-left"></a></li>
                <li><a href="#" class="page-numbers">1</a></li>
                <li class="current"><span class="page-numbers">2</span></li>                           
                <li><a href="#" class="page-numbers">3</a></li>
                <li><a href="#" class="last page-numbers fa fa-angle-double-right" ></a></li>
            </ul><!--page-numbers-->
        </div>
        <!-- kopa pagination -->  

    </div>
<?php } else { ?>
    <div id="main-col" class="col-md-9">   
        <div class="product-list-1">

            <div class="row">
                <div class="text-center">
                    <h4>WE'RE SORRY.</h4>
                    <h6>There are no <span class="text-danger"><?php echo $category_title ?></span> available for your vehicle.</h6>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>

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


        event.preventDefault();

        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url},
                    url: href = "<?php echo base_url(); ?>standard_library/insert_ajax_link_item_to_cart/" + id,
                    success: function (data)
                    {
                        $.toaster({priority: 'info', title: 'Cart', message: 'Product has been added to the cart.'});
                        ajax_update_mini_cart(data);
                    }
                }
        );
    }

    function ajax_update_mini_cart(data)
    {
        var cart_count = <?php echo isset($cart_items) ? count($cart_items) : '0'; ?>;
        $('#id_cart_total').text('');
        $('#id_cart_total').text(cart_count);
        return false;
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
