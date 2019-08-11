<!-- Home slide -->

<div class="home-slide5 slide-fullscreen owl-carousel nav-style4 nav-center-center" data-animateout="fadeOut" data-animatein="fadeIn" data-items="1" data-nav="true" data-dots="false" data-loop="true" data-autoplay="true">



    <?php  foreach($slide as $sld){ ?>

    <div class="item-slide full-height" data-background="<?php echo base_url($sld['banner_image']) ?>">	

        <div class="row">		

            <div class="container">		

                <div class="slider-content">		

<!--                <div class="col-md-6">		
                    </div>
<-->

                    <div class="col-md-12 text-<?php echo $sld['style'];?>">		

                        <img class="logo-banner img-parallax" src="<?php echo base_url('assets/images/Vaskia_Logo_banner.png') ?>"/>	

                        <!--div class="banner-divider"></div-->	

                        <div style="clear:both"></div>		

                        <h1><?php echo $sld['title'];?></h1>		

                        <p><?php echo $sld['description'];?></p>

                        <!--<a class="banner-btn" href="<?php echo $sld['link'];?>">View More</a>-->

                    </div>



                </div>

            </div>	

        </div>	

    </div>

    <?php   }?>

   

</div>

<!-- ./Home slide -->




<div class="product_display margin-top-80">

    <div class="container">


       <a href="javascript:;" class="no-style">
        <div class="title_text_div">

            <h2>BEST SELLERS</h2>

        </div>
        </a>



        <ul class="product-list-grid desktop-columns-3 tablet-columns-3 mobile-columns-1 row flex-flow">

            <?php

            if (isset($best_seller)) {

//                echo "<pre>";

//                print_r($best_seller);die;

                foreach ($best_seller as $bs) {

//                        print_r($bs['product_images_details']);die;

                    ?>

                    <li class="product-item col-sm-4">

                        <div class="product-inner">

                            <div class="product-thumb has-back-image">

                                <a href="<?php echo base_url() ?>home/shop_product/<?php echo $bs['product_id'] ?>/<?php echo $bs['category_id'] ?>"><img src="<?php echo base_url($bs['product_images_details'][0]['url']) ?>" alt=""></a>

                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $bs['product_id'] ?>/<?php echo $bs['category_id'] ?>"><img src="<?php echo base_url($bs['product_images_details'][0]['hover_img_url']) ?>" alt=""></a>



                            </div>



                        </div>

                    </li>

                    <?php

                }

            }

            ?>







        </ul>

    </div>

</div>





<div class="product_display margin-top-80">

    <div class="container">


        <a href="javascript:;" class="no-style">
        <div class="title_text_div">

            <h2>NEW ARRIVALS</h2>

        </div>
        </a>



        <ul class="product-list-grid desktop-columns-3 tablet-columns-3 mobile-columns-1 row flex-flow">

            <?php

            if (isset($new_arrivals)) {

                foreach ($new_arrivals as $na) {

                    ?>

                    <li class="product-item col-sm-4">

                        <div class="product-inner">

                            <div class="product-thumb has-back-image">

                                <a href="<?php echo base_url() ?>home/shop_product/<?php echo $na['product_id'] ?>/<?php echo $na['category_id'] ?>"><img src="<?php echo base_url($na['product_images_details'][0]['url']) ?>" alt=""></a>

                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $na['product_id'] ?>/<?php echo $na['category_id'] ?>"><img src="<?php echo base_url($na['product_images_details'][0]['hover_img_url']) ?>" alt=""></a>



                            </div>



                        </div>

                    </li>

                    <?php

                }

            }

            ?>







        </ul>

    </div>

</div>





<div class="product_display margin-top-80">

    <div class="container">


        <a href="javascript:;" class="no-style">
        <div class="title_text_div">

            <h2>VASKIA ESSENTIALS</h2>

        </div>
        </a>



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

<a href="" data-toggle="modal" data-target="#instadetails">Insta pop up</a>



<!-- Modal -->

<div class="modal fade product_view" id="instadetails">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Dummy Product</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 product_img">
                        
                        <img src="<?php echo base_url() ?>assets/images/loginimage.jpg" class="img-responsive">
                    </div>
                    <div class="col-md-6 product_content">
                        <h4>Product Id: <span>51526</span></h4>
                        <div class="rating">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            (10 reviews)
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        <h3 class="cost"><span class="glyphicon glyphicon-usd"></span> 75.00 <small class="pre-cost"><span class="glyphicon glyphicon-usd"></span> 60.00</small></h3>
                        
                        <div class="space-ten"></div>
                        <div class="btn-ground">
                            <button type="button" class="my-theme-btn"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>
                            <button type="button" class="my-theme-btn"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Section -->



<div id="promoModal" class="modal fade in" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="mobalclose-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <?php 
                if($promotions[0]['type'] == '1') { echo $promotions[0]['content'];
                }else{
                    echo "<img src='".base_url()."backend/uploads/promotional_banners/".$promotions[0]['banner_image']."'>";
                }
                ?>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('#promoModal').modal();
        }, <?php echo $promotions[0]['display_after']; ?>);
    });
</script>