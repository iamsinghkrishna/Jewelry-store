<?php if (isset($product_details) && !empty($product_details)) { ?>
    <div class="tab-panel active">
        <ul id="catproducts_filter" class="product-list-grid2 tab-list" >

            <?php
            foreach ($product_details as $key => $dataAtt) {
                ?>
                <li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">
                    <div class="product-inner">
                        <div class="product-thumb has-back-image">
                           <?php
                                if ($dataAtt['quantity'] <= 0) {
                                    ?>
                                    <div class="status">
                                        <span class="onsale">
                                            <?php if($dataAtt['back_order_flag']=='yes'){?>
                                            <span class="text">Out Of Stock!<br> Pre-Order Now</span>
                                            <?php }else{?>
                                            <span class="text">Out Of Stock!</span>
                                            <?php }?>
                                        </span>
                                    </div>
                                <?php } ?>
                                                <?php
                                                if ($dataAtt['quantity'] <= 5 && $dataAtt['quantity']
                                                    > 0) {
                                                    ?>
                                                    <div class="status">
                                                        <span class="onsale">
                                                            <span class="text"><?php echo $dataAtt['quantity'] ?> Available</span>
                                                        </span>
                                                    </div>
                                                <?php } ?>
                            <a href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo base64_encode($dataAtt['category_id']) ?>">
                                <img src="<?php
                                echo ($dataAtt['url'] == '') ? base_url('assets/images/product-no-image2.jpg')
                                        : base_url($dataAtt['url'])
                                ?>" alt="">
                            </a>
                            <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo base64_encode($dataAtt['category_id']); ?>"><img src="<?php echo base_url($dataAtt['product_images_details'][0]['hover_img_url']) ?>" alt=""></a>

                            <div class="col-md-12 text-center no-padding">
                                                    <div class="product-info">
                                                        <div class="">
                                                            <h2 class="product-name"><a href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo base64_encode($dataAtt['category_id']); ?>"><?php echo $dataAtt['product_name'] ?></a></h2>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 text-center">
                                                    <div class="clearfix"></div>
                                                    <div class="pricing_grid">
                                                        <h5 class="item-price">
                                                            <?php if (isset($dataAtt['discounted_price']) && $dataAtt['discounted_price'] != NULL) { ?>
                                                                $<?php echo number_format(floatval($dataAtt['price']) - floatval($dataAtt['discounted_price']),2); ?>
                                                                <del>$<?php echo number_format($dataAtt['price'],2); ?></del>

                                                            <?php } else { ?>
                                                                $<?php echo $dataAtt['price']; ?>
                                                            <?php } ?>
                                                        </h5>
                                                    </div>
                                                </div>
                        </div>

                    </div>
                </li>
                <?php
            }
            ?>
        </ul>

    </div>

    <input type="hidden" name="page_limit" id="page_limit_filter" value="<?php echo $page_limit; ?>" />
    <input type="hidden" name="total_page" id="total_page_filter" value="<?php echo $page_limit; ?>" />                                                                                         <!--<div style="text-align:center;margin:10px 0" id="loaderimg"> <img style="height:150px" src="<?php echo base_url('assets/images/loader_2.gif') ?>"></div>-->
    <?php if (count($total_product_details) > count($product_details)) { ?>
        <div id="lst"><div style="text-align: center;">
                <a class="button-loadmore loadmore_filter" id="loadmore_filter"  data-service_filter="<?php echo $catid; ?>" data-page="1">load more</a>
            </div>
        </div>
    <?php } ?>
    <?php
} else {
    echo "<h3 style=text-align:center>No Products found in this category</h3>";
}
?>
