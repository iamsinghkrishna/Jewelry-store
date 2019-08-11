<?php // echo '<pre>', print_r($product_details);die;        ?>
<?php if (isset($product_details))  ?>
<?php foreach ($product_details as $productData) { ?>
    <div class="shop-product-single">
        <h1><?php echo isset($productData['product_name']) ? $productData['product_name'] : '' ?></h1>
        <div class="kopa-divider divider-1"></div>

        <div class="product-content clearfix">
            <div class="row">

                <div class="product-thumbnail col-sm-12 col-xs-12">
                    <div class="big-thumb">

                        <img class="img-re" src="<?php echo base_url() . $productData['url'] ?>" height="488" width="470" alt="">
                        <!--<img src="<?php echo base_url() ?>assets/placeholders/car/Shop-Product_470-488.jpg" height="488" width="470" alt="">-->
                    </div>

                    <div class="small-thumb">
                        <ul class="row">
                            <?php if (isset($productData['product_images_details']))  ?>
                            <?php foreach ($productData['product_images_details'] as $imgData) { ?>
                                <li class="col-sm-4 col-xs-4">
                                    <img src="<?php echo base_url() . $imgData['url']; ?>" height="110" width="150" alt="">
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="product-detail col-sm-12 col-xs-12">
                    <div class="product-price-wrap">
                        <p class="product-price"><span>$<?php echo isset($productData['price']) ? $productData['price'] : '' ?></span></p>
                    </div>                                    
                    <p class="meta-info clearfix">
                        <span class="kopa-rating">
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star-half-o"></span>
                        </span>
                        <span class="review">1 Review</span>
                        <a href="#" class="add-review">Add your review</a>
                    </p>

                    <p class="intro"><?php echo html_entity_decode(isset($productData['description']) ? ($productData['description']) : '') ?></p>
                    <div class="features">
                        <p><span>car make</span><?php echo $product_make[$productData['make_id']] ?></p>
                        <?php if (isset($productData['prodcut_cat_edit_detail']))  ?>
                        <?php foreach ($productData['prodcut_cat_edit_detail'] as $productSD) { ?>
                            <?php if ($productSD['attribute_type'] == '1') { ?>
                                <p><span><?php echo $productSD['attribute_value'] ?></span><?php echo $productSD['subattribute_name'] ?></p>
                            <?php } else { ?>
                                <p><span><?php echo $productSD['subattribute_name'] ?></span><?php echo $productSD['sub_attribute_value'] ?></p>
                            <?php } ?>

                        <?php } ?>

                    </div>
                    <p class="add-to-cart-wrap">
                        <input type="number" class="amount" title="Qty" value="1" name="quantity" min="1" step="1">
                        <a href="<?php echo ''; ?>" class="add-to-cart"><span><i class="fa fa-plus"></i>add to cart</span></a>
                    </p>
                    <p class="categories">
                        <span class="title">Categories:</span>
                        <a href="#"></a>,
                    </p>
                </div>
            </div>

        </div>

        <div role="tabpanel" class="kopa-tab-2 mb-40 clearfix">

            <ul class="nav nav-tabs product-nav-tab">
                <li class="active"><a href="#tab1-1" data-toggle="tab">description</a></li>
                <li><a href="#tab1-2" data-toggle="tab">product tags</a></li>
                <li><a href="#tab1-3" data-toggle="tab">review <span>(1)</span></a></li>
            </ul>
            <!-- Nav tabs -->

            <div class="tab-content product-tab-content">
                <div class="tab-pane active" id="tab1-1">
                    <p><?php echo html_entity_decode(isset($productData['description']) ? ($productData['description']) : '') ?></p>
                </div>
                <div class="tab-pane" id="tab1-2">
                    <p>2A 2014 LP700 Roadster in a dazzling Grigio Telesto with Nero leather and Giallo Contrast Stitch, this stand out Lamborghini makes a powerful statement without saying a word. The new LP700 Roadster boasts breath taking performance, with acceleration from 0-100 km/hr in only 3 second flat and a maximum speed of 350 km/hr. Lamborghini made changes to the engine hood on the with two pairs of hexagonal windows connected at the sides, separated with a central spinal column.</p>
                    <p>Extensive factory options include Out of Range Paint, T Engine Cover in Carbon Fiber, Carbon Fiber Engine Bay, Front Exterior Carbon Fiber Package, Rear Exterior Carbon Fiber Package, Exterior Details in Carbon Fiber Small, Transparent Engine Bonnet, Yellow Brake Callipers, Yellow Rear Suspension Springs, Lamborghini Sound System, Park Assist Front and Rear with Rear Camera, Multifunction Steering Wheel with Perforated Leather, Branding Package, Homelink and Unicolour Interior with Giallo Contrast Stitch. Additional factory options include an Ad Personum Element with Q-Citura Stitching throughout the </p>
                </div>
                <div class="tab-pane" id="tab1-3">
                    <p>3A 2014 LP700 Roadster in a dazzling Grigio Telesto with Nero leather and Giallo Contrast Stitch, this stand out Lamborghini makes a powerful statement without saying a word. The new LP700 Roadster boasts breath taking performance, with acceleration from 0-100 km/hr in only 3 second flat and a maximum speed of 350 km/hr. Lamborghini made changes to the engine hood on the with two pairs of hexagonal windows connected at the sides, separated with a central spinal column.</p>
                    <p>Extensive factory options include Out of Range Paint, T Engine Cover in Carbon Fiber, Carbon Fiber Engine Bay, Front Exterior Carbon Fiber Package, Rear Exterior Carbon Fiber Package, Exterior Details in Carbon Fiber Small, Transparent Engine Bonnet, Yellow Brake Callipers, Yellow Rear Suspension Springs, Lamborghini Sound System, Park Assist Front and Rear with Rear Camera, Multifunction Steering Wheel with Perforated Leather, Branding Package, Homelink and Unicolour Interior with Giallo Contrast Stitch. Additional factory options include an Ad Personum Element with Q-Citura Stitching throughout the </p>
                </div>
            </div>
            <!-- Tab panes -->

        </div>

    </div> 
<?php } ?>