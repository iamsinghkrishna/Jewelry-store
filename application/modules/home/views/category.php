<!--link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"-->
<?php //echo '<pre>';print_r(count($total_product_details));     ?>
<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

            <h2>
                <?php
                if ($category_name != '') {
                    echo strtoupper($category_name.' ');
                }
                if ($sub_category_name != '') {
                    echo '- '.strtoupper($sub_category_name);
                }
                ?>

            </h2>

        </div>
    </div>
</div>

<div class="category_inner_header">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <label for="amount">Price range:</label>
                    <input type="text" id="amount" readonly style="border:0; color:#555555; font-weight:bold;">
                    <input type="hidden" id="category" value="<?php echo $category_ids; ?>">
                    <input type="hidden" id="sub_category" value="<?php echo $sub_catid; ?>">
                    <input type="hidden" id="sub_category_third" value="<?php echo $sub_cat_third; ?>">
                    <div id="slider-range"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="price-filters margin-top-20">
                    <select name="sort" id="order" class="orderby" onchange="filter(this.value)">
                        <option value="">Latest</option>
                        <option value="ASC">Price Low to High</option>
                        <option value="DESC">Price High to Low</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="margin-top-30">
    <div class="container">
        <div class="tab-product ">


            <div class="tab-content">
                <div style="text-align:center;display:none" id="loaderDiv"><img src='<?php echo base_url() ?>assets/images/loader_2.gif'></div>
                <div class="tab-container product_display product_content">

                    <?php if (isset($product_details) && !empty($product_details)) { ?>
                        <div class="tab-panel active">
                            <!--ul id="catproducts" class="product-list-grid2 tab-list owl-carousel-mobile" data-nav="true" data-dots="true" data-margin="0" data-loop="true"  data-items="1"-->
                            <ul id="catproducts" class="product-list-grid2 tab-list">

                                <?php
                                foreach ($product_details as $key => $dataAtt) {
                                    ?>
                                    <!--li class="product-item style3 mobile-slide-item col-sm-4 col-md-3"-->
                                    <li class="first product-item flash1 col-md-3 col-sm-4 col-xs-12 col-ts-12 post-183 product type-product status-publish has-post-thumbnail product_cat-clothings product_cat-fashion  outofstock sale shipping-taxable purchasable product-type-simple">

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
                                                    <img src="<?php echo ($dataAtt['product_images_details'][0]['url']
                                        == '') ? base_url('assets/images/product-no-image2.jpg')
                                                : base_url($dataAtt['product_images_details'][0]['url']) ?>" alt="" >
                                                </a>
        <?php ?>
                                                <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $dataAtt['id'] ?>/<?php echo base64_encode($dataAtt['category_id']); ?>">

                                                    <img src="<?php echo base_url($dataAtt['product_images_details'][0]['hover_img_url']) ?>" alt="" >
                                                </a>

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
        <?php if (isset($dataAtt['discounted_price'])
            && $dataAtt['discounted_price'] != NULL) { ?>
                                                                $<?php echo number_format(floatval($dataAtt['price'])
                - floatval($dataAtt['discounted_price']), 2); ?>
                                                                <del>$<?php echo number_format($dataAtt['price'],
                2); ?></del>

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

                                                                                                                            <!--<div style="text-align:center;margin:10px 0" id="loaderimg"> <img style="height:150px" src="<?php echo base_url('assets/images/loader_2.gif') ?>"></div>-->
                        <?php if (count($total_product_details)
                            > count($product_details)) { ?>
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

        <ul  class="product-list-grid desktop-columns-4 tablet-columns-3 mobile-columns-1 row flex-flow">
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
    <input type="hidden" name="page_limit" id="page_limit" value="<?php echo $page_limit; ?>" />
    <input type="hidden" name="total_page" id="total_page" value="<?php echo $page_limit; ?>" />
</div>
<script>
    $(document).on('click', '.loadmore', function () {
        $(this).text('Loading...');
        var ele = $(this).parent('div');
        var page_limit = $('#page_limit').val();
        var total_page = $('#total_page').val();
        var sub_category_third = $("#sub_category_third").val();
        var x = parseInt(page_limit) + parseInt(total_page);
        $.ajax({
            url: base_url + 'home/home/loadMoreProducts',
            type: 'POST',
            data: {
                page: $(this).data('page'),
                cat_id: $(this).data('service'),
                //cat_id: '<?php echo $category_ids; ?>',
                sub_cat_id: '<?php echo $sub_category_ids; ?>',
                subcatThird: sub_category_third,
                page_limit: page_limit,
                total_page: total_page,
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

    $(function () {

        $("#slider-range").slider({
            range: true,
            min: 1,
            max: 4000,
            values: [1, 4000],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ]);
            },
            stop: function (event, ui) {
                filter($("#order").val());
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));

//        $('.ui-slider-handle,#slider-range').on('click', function () {
//            filter('');
//        });
//         $('#slider-range').on('click', function () {
//            filter('');
//        });

//        $( "#slider-range" ).mouseup(function() {
//        filter('');
//        });
//        

//        $( "#slider-range" ).mouseup(function() {
//        filter('');
//        });

    });

    function filter(order) {
        $('#slider-range').slider('disable');
        $(".product_content").hide();
        $("#loaderDiv").show();
        if (order == '') {
            var order = '';
        } else {
            var order = order;
        }
        var min_price = $("#slider-range").slider("values", 0);
        var max_price = $("#slider-range").slider("values", 1);
        var category = $("#category").val();
        var sub_category = $("#sub_category").val();
        var sub_category_third = $("#sub_category_third").val();
        var order = order;
        var qs = "min_price=" + min_price + "&max_price=" + max_price + "&category=" + category + '&sub_category=' + sub_category + '&sub_category_third=' + sub_category_third + '&order=' + order;
        //alert(ctr_id);

        $.ajax({
            url: base_url + 'home/home/filterProducts',
            type: 'POST',
            data: qs,
            dataType: 'json',
            success: function (output) {
                $("#slider-range").slider("enable")
                if (output.status === 200) {
                    $("#loaderDiv").hide();
                    $('.product_content').fadeOut('slow', function () {
                        $('.product_content').html(output.data).fadeIn('fast');
                    });
                }
            }
        });
    }


</script>

<script>
    $(document).on('click', '#loadmore_filter', function () {
        $(this).text('Loading...');
        var ele = $(this).parent('div');
        var page_limit = $('#page_limit_filter').val();
        var total_page = $('#total_page_filter').val();
        var order = $("#order").val();
        var min_price = $("#slider-range").slider("values", 0);
        var max_price = $("#slider-range").slider("values", 1);

        var sub_category_third = $("#sub_category_third").val();



        var x = parseInt(page_limit) + parseInt(total_page);
        $.ajax({
            url: base_url + 'home/home/loadMoreProductsFilter',
            type: 'POST',
            data: {
                page: $(this).data('page'),
                cat_id: $(this).data('service_filter'),
                sub_cat_id: '<?php echo $sub_category_ids; ?>',
                page_limit: page_limit,
                order: order,
                total_page: total_page,
                min_price: min_price,
                max_price: max_price,
                subcatThird: sub_category_third,
            },
            success: function (response) {
                //alert(response);
                if (response) {
                    ele.hide();
                    $('#page_limit_filter').val(x);

                    $("#catproducts_filter").append(response);
                }
            }
        });
    });

    setTimeout(function() {   //calls click event after a certain time
              //$(".signature-container .nf-field-element").append( $('#signature-pad'));
              $(this).scrollTop(0); 
              //alert("Window Loaded");
        }, 3000);
</script>    

