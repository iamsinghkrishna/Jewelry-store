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

        <div class="container" id="mainProductDiv">
            <center>
            <img style="display:none;" src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader_img" name="loader_img" />
            </center>
            <div id="submainProductDiv">
             <?php if (!empty($product_details)) { ?>
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-sm-5">
                        <!--Start product slider-->

                        <div class="xzoom-container">
                            <?php if (!empty($product_details[0]['product_images_details'])) { ?>
                                <img class="xzoom3" onerror="this.src='<?php echo base_url('assets/images/product-no-image2.jpg'); ?>'" src="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" xoriginal="<?php echo base_url($product_details[0]['product_images_details'][0]['url']) ?>" />

                                <div class="xzoom-thumbs">

                                    <?php foreach ($product_details[0]['product_images_details'] as $id) { ?>

                                        <a href="<?php echo base_url($id['url']) ?>"><img onerror="this.src='<?php echo base_url('assets/images/product-no-image2.jpg'); ?>'" class="xzoom-gallery3" width="80" src="<?php echo base_url($id['url']) ?>"  xpreview="<?php echo base_url($id['url']) ?>" title=""></a>

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

<!--                            <div class="breadcrumbs">

                                <span><?php echo $product_details[0]['product_name'] ?></span>

                            </div>-->

                            <h3 class="product-name"><?php echo $product_details[0]['product_name'] ?></h3>


                            <span class="price">


                                <?php
                                if (isset($product_details[0]['discounted_price'])
                                    && $product_details[0]['discounted_price'] != NULL) {
                                    ?>
                                    <ins>$<label id="new_product_price" style="background-color:#fff  !important;color:#222;cursor:default;padding:6px 2px;"><?php
                                        echo number_format(($product_details[0]['price']
                                            - $product_details[0]['discounted_price']),
                                            2);
                                        ?></label></ins>
                                    <del>$<label id="new_product_price" style="background-color:#fff  !important;color:#222;cursor:default;padding:6px 2px;"><?php
                                        echo number_format($product_details[0]['price'],
                                            2);
                                        ?></label></del>
                                <?php } else { ?>
                                    <ins>$<label id="new_product_price" style="background-color:#fff !important;color:#222;cursor:default;padding:6px 2px;"><?php
                                        echo number_format($product_details[0]['price'],
                                            2);
                                        ?></label></ins>
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
                                <div class="clearfix">
                                <div class="quantity">



                                    <span style="display:block;">Quantity</span>

                                    <input type="number" size="4" class="input-text qty text" width="50" title="Qty" value="1" id="quantity_<?php echo $product_details[0]['id'] ?>" name="quantity" min="1" step="1">
                                    <!--<span class="errormsgforqty" style='display:table;font-size:11px;color:red'></span>-->

                                </div>
                                </div>


                                <div><?php
                                    if ($product_details[0]['quantity'] < 1) {
                                        if ($product_details[0]['back_order_flag']
                                            == 'yes') {
                                            echo "<span style='font-size:11px;color:red;'>Out of stock</span>";
                                        } else {
                                            echo "<span style='font-size:11px;color:red;'>Out of stock</span>";
                                        }
                                    }
                                    if ($product_details[0]['quantity'] <= 2 && $product_details[0]['quantity']
                                        > 0) {
										 if($product_details[0]['quantity'] == 0){
                                                $msg = 'No';
                                         }else{
                                             $msg = 'Only '.$product_details[0]['quantity'];
                                         }
                                        if ($product_details[0]['back_order_flag']
                                            == 'yes') {
                                            echo "<span id='errormsgforqty' style='font-size:11px;color:red'>".$msg." item(s) left in stock</span>";
                                        } else {
                                            echo "<span  id='errormsgforqty' style='font-size:11px;color:red'>".$msg." item(s) left in stock</span>";
                                        }
                                    }
                                    ?></div>
                                <div style="clear: both; margin: 20px;"></div>
                                <?php if (!empty($group_variant_products)) { ?>
                                    <div class="clearfix margin-top-20">
                                    <span class="" style="margin-top: 7px; padding-left:0;float:left">Available in</span>
                                    <div class="" style="float: left;margin-left: 10px">
                                        <?php
                                        echo "<select onchange='getVariantProducts(this.value);' name='variant'>";
                                        $i = 0;
                                        foreach ($group_variant_products as $varient) {
                                            if ($varient['id'] == $product_details[0]['id'])
                                                    $selected = "selected";
                                            else $selected = "";
                                            echo "<option ".$selected." value='".$varient['id']."'>".ucfirst($varient['variant_color'])." (".$varient['variant_size'].")"."</option>";
                                        }
                                        echo "</select>";
                                        ?>
                                    </div>
                                    </div>
                                    <input type="hidden" id="variantUp" value="<?php echo ucfirst($product_details[0]['variant_color'])." (".$product_details[0]['variant_size'].")" ?>">
                                <?php } ?>


                                <div class="clearfix"></div>
<!--                                
                                <?php
                                $catar = explode(',',
                                    $product_details[0]['sub_category_id']);
                                if (in_array('39', $catar)) {
                                    ?>

                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Inicial</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select id="getinicial" name="initial">
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="I">I</option>
                                            <option value="K">K</option>
                                            <option value="R">R</option>
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
-->


                                <?php
                                $catar = explode(',',
                                    $product_details[0]['sub_category_id']);
                                if (in_array('39', $catar)) {
                                 if(count($arr_inicial_product_details) >0){   
                                    ?>
                                    <input type="hidden" name="inicial_product_available" id="inicial_product_available" value="1" />
                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Inicial</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select id="getinicial" name="initial" onchange="getInicialProducts();">
                                            <?php 
                                            $arr_block_letters=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_letter'] != ''){
                                                    if (in_array(trim($inicials['initial_letter']), $arr_block_letters)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_letter']; ?>" <?php if($inicials['initial_letter'] == $product_details[0]['initial_letter']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_letter']; ?></option>
                                                <?php 
                                                    $arr_block_letters[]=$inicials['initial_letter'];
                                                    }}} ?>
                                           
                                        </select>
                                    </div>
                                    <div class="clearfix margin-bottom-20"></div>


                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">Color</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select id="getcolor" name="getcolor" onchange="getInicialProducts();">
                                            
                                             <?php 
                                            $arr_block_colors=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_color'] != ''){
                                                    if (in_array(trim($inicials['initial_color']), $arr_block_colors)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_color']; ?>" <?php if($inicials['initial_color'] == $product_details[0]['initial_color']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_color']; ?></option>
                                                <?php 
                                                    $arr_block_colors[]=$inicials['initial_color'];
                                                    }}} ?>
                                            
                                            
                                        </select>
                                    </div>
                                    <div class="clearfix margin-bottom-20"></div>
                                    
                                    
                                    <div class="clearfix margin-top-20"></div>
                                    <span class="col-md-1 col-xs-1" style="margin-top: 7px;padding-left:0">MM</span>
                                    <div class="col-md-10 col-xs-10">
                                        <select id="getinicialmm" name="getinicialmm" onchange="getInicialProducts();">
                                            
                                             <?php 
                                            $arr_block_mm=array();
                                            foreach($arr_inicial_product_details as $keys=> $inicials){
                                                if($inicials['initial_mm'] != ''){
                                                    if (in_array(trim($inicials['initial_mm']), $arr_block_mm)) {
                                                           
                                                    }else{
                                            ?>
                                            <option value="<?php echo $inicials['initial_mm']; ?>" <?php if($inicials['initial_mm'] == $product_details[0]['initial_mm']){ ?>selected="selected" <?php } ?>><?php echo $inicials['initial_mm']; ?></option>
                                                <?php 
                                                    $arr_block_mm[]=$inicials['initial_mm'];
                                                    }}} ?>
                                            
                                            
                                        </select>
                                    </div>
                                    <div class="clearfix margin-bottom-20"></div>
                                    

                                <?php } }else{ ?>
                                    <input type="hidden" name="inicial_product_available" id="inicial_product_available" value="0" />
                                <?php } ?>
                                    
                                    
                                    
                                    

                                <ul style="margin-top: 20px">
                                    <?php if ($product_details[0]['back_order_flag'] == 'yes' && $product_details[0]['quantity'] <=0) { ?>
                                    <li> <a class="new-btn cart-dis" data-quantity="1"  href="javascript:;" onclick="funAddToCartSuccess(<?php echo $product_details[0]['id'] ?>,'1')">Pre-Order</a></li>
                                    <?php } else { ?>
                                    <li> <a class="new-btn cart-dis" data-quantity="1"  href="javascript:;" onclick="funAddToCart(<?php echo $product_details[0]['id'] ?>)">ADD TO CART</a></li>
                                    <?php
                                    }
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

                                <?php
                                $actual_link = current_url();
                                ?>

                                <ul class="social_icons_footer">

                                    <li>

                                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                                    </li>

                                    <li>

                                        <a href="https://twitter.com/home?status=<?php echo $actual_link; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                                    </li>
                                    <li>

                                       <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
        <i class="fa fa-pinterest" aria-hidden="true"></i>
    </a>

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
    </div>

</section>






<div class="product_display">

    <div class="container">



        <div class="title_text_div">

            <h2>VASKIA ESSENTIALS</h2>

        </div>



        <ul class="product-list-grid desktop-columns-4 tablet-columns-3 mobile-columns-1 row flex-flow">

            <?php foreach ($essential as $pd) {
                ?>

                <li class="product-item col-sm-3">

                    <div class="product-inner">

                        <div class="product-thumb has-back-image">

                            <a href="<?php echo base_url() ?>home/shop_product/<?php echo $pd['product_id'] ?>/<?php echo base64_encode($pd['category_id']) ?>"><img src="<?php echo base_url($pd['url']) ?>" alt="" ></a>
                            <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $pd['product_id'] ?>/<?php echo base64_encode($pd['category_id']) ?>"><img src="<?php echo ($pd['hover_img_url']!="" || file_exists(base_url($pd['hover_img_url']))) ? base_url($pd['hover_img_url']): base_url($pd['url']) ?>" alt="" ></a>

                        </div>

                    </div>

                </li>

            <?php } ?>







        </ul>

    </div>

</div>





<script>
$("input[name='quantity']").keyup(function(){
   if($(this).val() <=0){
       $('#errormsgforqty').html("Value must be greater than 0");
   }else{
       $('#errormsgforqty').html("");
   }
});
// Example of adding a item to the cart via a link.
    function  funAddToCart(id) {
        var total_quantity = $('#quantity_' + id).val();
        
        
        //Product is not inicials
        var inicial_product_available = $('#inicial_product_available').val();
        //if(inicial_product_available != 1){
            if (total_quantity <= 0) {

                $('#errormsgforqty').html("Value must be greater than 0");
                $('#quantity_' + id).val("");
                return false;
            }

             if($("#stock_"+id).val() < total_quantity){
                var to_quantity = $("#stock_"+id).val();
                if(to_quantity == 0){
                    var msg = 'No items left in stock';
                }else{
                 var msg = "Only "+$("#stock_"+id).val()+" item left in stock";
                }
                //$('#errormsgforqty').html("Only "+$("#stock_"+id).val()+" item left in stock");
                 $('#errormsgforqty').html(msg);
                return false;
            }
       // }
        
        //For inicials products
//        if(inicial_product_available == 1){ 
//             if (total_quantity <= 0) {
//
//                $('#errormsgforqty').html("Value must be greater than 0");
//                $('#quantity_' + id).val("");
//                return false;
//            }
//            
//            var getinicial = $('#getinicial').val();
//            var color = $('#getcolor').val();
//            var getinicialmm = $('#getinicialmm').val();
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
////                            var new_product_price = number( true, response.new_price );
////                            $('#new_product_price').html(response.new_price);
//                                $('#item_id_'+id).val(response.new_item_id);
//                                $('#stock_'+id).val(response.new_stock);
//                                $('#name_'+id).val(response.new_name);
//                                $('#img_url_'+id).val(response.new_img_url);
//                                $('#price_'+id).val(response.new_price);
//                                //alert(response.new_product_id);
//                            funAddToCartSuccess(id, '0');
//                        }else if(response.status === '3'){
//                            $.toaster({priority: 'danger', title: 'Cart', message: 'This product is out of stock and can not be pre ordered.'});
//                            $(".cart-dis").html('Add to cart');
//                            $(".cart-dis").prop('disabled', false);
//                            return false;
//                        } else {
////                             var new_product_price = number( true, response.new_price );
////                            $('#new_product_price').html(response.new_price);
//                            $('#item_id_'+id).val(response.new_item_id);
//                            $('#stock_'+id).val(response.new_stock);
//                            $('#name_'+id).val(response.new_name);
//                            $('#img_url_'+id).val(response.new_img_url);
//                            $('#price_'+id).val(response.new_price);
//                            $.toaster({priority: 'danger', title: 'Cart', message: 'Selected product quantity is not available but you can order it.It will take approx 2 weeks for shipment.'});
//                            $('.cart-dis').attr('onclick', '').unbind('click');
//                            $('.cart-dis').attr('onclick', 'funAddToCartSuccessCheckAvailable(' + response.new_item_id + ',"1")').bind('click');
//                            $(".cart-dis").html('ORDER IN ADVANCE');
//                            $(".cart-dis").prop('disabled', false);
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
//        }else{
//        
        
        
        $('#quantity_' + id).next("span").remove();
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
//}

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
        var product_not_available = 0;
      var inicial_product_available = $('#inicial_product_available').val();

//       if(inicial_product_available == 1){
//            var total_quantity = $('#quantity_' + id).val();
//             if (total_quantity <= 0) {
//
//                $('#errormsgforqty').html("Value must be greater than 0");
//                $('#quantity_' + id).val("");
//                return false;
//            }
//            
//            var getinicial = $('#getinicial').val();
//            var color = $('#getcolor').val();
//            var getinicialmm = $('#getinicialmm').val();
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
//                            
////                             var new_product_price = number( true, response.new_price );
////                             $('#new_product_price').html(response.new_price);
//                            
//                              var back_order_flag = response.back_order_flag;
//                              if(back_order_flag == 'no'){
//                                prebook = 0; 
//                                $(".cart-dis").html('Add to cart');
//                              }else{
//                                  prebook = 1;
//                                  $(".cart-dis").html('Pre-Order');
//                              }
//                                $('#item_id_' + id).val(response.new_item_id);
//                                $('#stock_'+id).val(response.new_stock);
//                                $('#name_'+id).val(response.new_name);
//                                $('#img_url_'+id).val(response.new_img_url);
//                                $('#price_'+id).val(response.new_price);
//                               
//                           // funAddToCartSuccess(id, '1');
//                           $('.cart-dis').attr('onclick', 'funAddToCartSuccessCheckAvailable(' + response.new_item_id + ',"1")').bind('click');
//                        }else if(response.status === '3'){
//                              product_not_available = 1;
//                            $.toaster({priority: 'danger', title: 'Cart', message: 'This product is out of stock and can not be pre ordered.'});
//                            $(".cart-dis").html('Add to cart');
//                            $(".cart-dis").prop('disabled', false);
//                            return false;
//                        } else { 
////                            var new_product_price = number( true, response.new_price );
////                            $('#new_product_price').html(response.new_price);
//                            $('#item_id_' + id).val(response.new_item_id);
//                            $('#stock_'+id).val(response.new_stock);
//                            $('#name_'+id).val(response.new_name);
//                            $('#img_url_'+id).val(response.new_img_url);
//                            $('#price_'+id).val(response.new_price);
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
        //alert(product_not_available);
       // setTimeout(function(){  
        if (id != '') {
        var item_id = $('#item_id_' + id).val();
        var name = $('#name_' + id).val();
        var price = $('#price_' + id).val();
        var item_url = $('#img_url_' + id).val();
        var quantity = $('#quantity_' + id).val();
        var stock_quantity = $('#stock_' + id).val();
        var init = $('#getinicial').val();
        var color = $('#getcolor').val();
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
                    url: href = "<?php echo base_url(); ?>standard_library/insert_ajax_link_item_to_cart/" + item_id,
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
   // }, 3000);
    
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
    function getVariantProducts(id)
    {
        var item_id = id;
        var cat_id = '<?php echo base64_encode($category_id); ?>';
        window.location.href = "<?php echo base_url() ?>home/shop_product/" + item_id + "/" + cat_id;
//        $.ajax({
//            type: 'POST',
//            url: '<?php echo base_url() ?>home/getVarientProducts',
//            data: 'product_id=' + item_id+ '&category_id=' + cat_id,
//            success: function (data)
//            {
//
//                var parsed = $.parseJSON(data);
//                console.log(parsed.status);
//                if (parsed.status == "1")
//                {
//                    $("#product_display_details").html(parsed.data);
//                }
//            }
//        });

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
    
    
    function getInicialProducts(){ 
        var initial_letter = $('#getinicial').val();
        var initial_color = $('#getcolor').val();
        var initial_mm = $('#getinicialmm').val();
        if(initial_letter != '' && initial_color != '' && initial_mm != ''){
            $.ajax({
                   url: '<?php echo base_url() ?>home/getInicialProducts',
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
                        $('#submainProductDiv').css('display','none');
                        $('#loader_img').css('display','block');
                        
                        if(data != '' && data != 1){
                            $('#mainProductDiv').html(data);
                        }else{
                            $.toaster({priority: 'danger', title: 'Cart', message: 'Selected product is not available,please check for another combination.'});
                            $('#submainProductDiv').css('display','inline');
                             $('#loader_img').css('display','none');
                        }
                    }
                }); 
        }
    }
</script>