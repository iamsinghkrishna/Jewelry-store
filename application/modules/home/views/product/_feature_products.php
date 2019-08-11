<div class="widget-top">
    <div class="widget-title title-s3">                        
        <h3>Featured Product</h3>
        <span class="red-bg"></span>
    </div>                    
    <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
</div>  
<div class="widget-content parallax clearfix">
    <div class="mask"></div>
    <div class="container product-list-1">
        <div class="content-inner row">
            <?php $i = 1; ?>
            <?php foreach ($product_feature_details as $pk => $pkData) { ?>
                <div class="col-sm-6 col-md-3">
                        <article class="item">
                            <div class="item-top">
                            <a class="thumbnail" href="#">
                                <span><img class="img-feature img-responsive" src="<?php echo base_url() . $pkData['url'] ?>" height="219" width="280" alt=""></span>
                                <span class="hexagon-1">
                                    <span><i class="fa fa-mail-forward"></i></span>
                                </span>
                            </a>    
                            <h6 class="product-title"><a href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>" title="<?php echo $pkData['product_name']?>">
                                     <?php if (strlen($pkData['product_name']) > 20) { ?>
                                        <?php echo substr($pkData['product_name'], 0, 18).'..'; ?>
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
                                <!--<span class="old-price"><?php echo $pkData['price'] ?></span>-->
                                <span class="new-price">$<?php echo $pkData['price'] ?></span>
                            </footer>
                            <span class="white-bg"></span>
                            <a href="#" class="cart-icon"><i class="fa fa-shopping-cart"></i></a>  
                        </div>                            
                    </article>
                </div>
                <?php // if ($i == 3) { ?>
                <!--<div class="clearfix"></div>-->

                <?php
//                    $i = 1;
//                }
                ?>
                <?php
                $i++;
            }
            ?>
        </div>

        <div class="clear"></div>

        <div class="read-more">  
            <span class="bg-1"></span>              
            <span class="bg-2"></span>
            <span class="bg-3"></span>
            <a href="<?php echo base_url()?>home/shop/" class="link">view all new products</a>                  
        </div> 
    </div>                           
</div>  