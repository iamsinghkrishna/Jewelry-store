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
                                <div class="clearfix margin-top-20"></div>
                                        <span class="col-md-1 col-xs-1" style="margin-top: 7px; padding-left:0">Available in</span>
                                        <div class="col-md-10 col-xs-10">
                                <?php

                                if (!empty($group_variant_products)) {
                                    echo "<select onchange='getVariantProducts(this.value);' name='variant'>";
                                    $vari   = array();
                                    $newarr = array();
                                    $i      = 0;
                                    foreach ($group_variant_products as $varient) {
                                       echo "<option value='".$varient['id']."'>".ucfirst($varient['variant_color']). " (" .$varient['variant_size'].")"."</option>";
                                    }
                                   echo "</select>";

                                    }
//                                echo "<pre>";
//                                print_r($newarr);die;
                                    ?>
                                        </div>


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