<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

             <h2>
            <?php
                if($category_name != ''){
                   echo  strtoupper($category_name.' ');
                }
                if($sub_category_name != ''){
                  echo '- '.strtoupper($sub_category_name);  
                }
            ?>
                
            </h2>

        </div>
    </div>
</div>

<div class="margin-top-30">
    <div class="container">
        <div class="tab-product ">


            <div class="tab-content">
                <div class="tab-container product_display">
                    <?php if (isset($product_details) && !empty($product_details)) { ?>
                        <div class="tab-panel active">
                            <ul id="catproducts" class="product-list-grid2 tab-list owl-carousel-mobile" data-nav="true" data-dots="true" data-margin="0" data-loop="true"  data-items="1">

                                <?php
                                foreach ($product_details as $key => $dataAtt) {
                                    ?>
                                    <li class="product-item style3 mobile-slide-item col-sm-4 col-md-3">
                                        <div class="product-inner">
                                            <div class="product-thumb has-back-image">
                                                <a href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo $dataAtt['category_id'] ?>"><img src="<?php echo base_url($dataAtt['product_images_details'][0]['url']) ?>" alt=""></a>
                                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo $dataAtt['category_id'] ?>"><img src="<?php echo base_url($dataAtt['product_images_details'][0]['hover_img_url']) ?>" alt=""></a>

                                                <div class="col-md-8">
                                                    <div class="product-info">
                                                        <div class="">
                                                            <h2 class="product-name"><a href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo $dataAtt['category_id'] ?>"><?php echo $dataAtt['product_name'] ?></a></h2>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="clearfix"></div>
                                                    <div class="pricing_grid">
                                                        <h5 class="item-price">$<?php echo $dataAtt['price'] ?></h5>
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

    <!--<div style="text-align:center;margin:10px 0" id="loaderimg"> <img style="height:150px" src="<?php echo base_url('assets/images/loader_2.gif') ?>"></div>-->
                         <?php if(count($total_product_details) > count($product_details)){ ?>
                        <div id="lst"><div style="text-align: center;"><a class="button-loadmore loadmore" id="loadmore"  data-service="<?php echo $catid; ?>" data-page="1">load more</a></div></div>
                        <?php } ?>
                    <?php
                    } else {
                        echo "<h3 style=text-align:center>No Products found in this category</h3>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="product_display margin-top-80">
    <div class="container">

        <div class="title_text_div">
            <h2>VASKIA ESSENTIALS</h2>
        </div>

        <ul  class="product-list-grid desktop-columns-3 tablet-columns-3 mobile-columns-1 row flex-flow">
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
     <input type="hidden" name="page_limit" id="page_limit" value="<?php echo $page_limit; ?>" />
    <input type="hidden" name="total_page" id="total_page" value="<?php echo $page_limit; ?>" />
</div>
<script>
    $(document).on('click', '.loadmore', function () {
        $(this).text('Loading...');
        var ele = $(this).parent('div');
        var page_limit = $('#page_limit').val();
        var total_page = $('#total_page').val();
        var x = parseInt(page_limit) + parseInt(total_page);
        $.ajax({
            url: base_url + 'home/home/loadMoreProducts',
            type: 'POST',
            data: {
                page: $(this).data('page'),
                cat_id: $(this).data('service'),
                //cat_id: '<?php echo $category_ids; ?>',
                sub_cat_id: '<?php echo $sub_category_ids; ?>',
                subcatThird: '<?php echo $subcatThird; ?>',
                page_limit:page_limit,
                total_page:total_page,
            },
            success: function (response) {
                //alert(response);
                if (response) {
                    ele.hide();
                    
                     $('#page_limit').val(x);
                    
                    $("#catproducts").append(response);
                }
            }
        });
    });

</script>

