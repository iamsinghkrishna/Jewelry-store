<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

            <h2>SHOP</h2>

        </div>
    </div>
</div>

<div class="margin-top-30">
    <div class="container">
        <div class="tab-product ">
            <ul class="box-tabs nav-tab">
                <li class="active"><a onclick="getProductsByCat('all')" data-animated="" data-toggle="tab" href="#tab-1">All</a></li>
                <?php
                if (isset($prodcut_cat_detail)) {
                    $i = 1;
                    foreach ($prodcut_cat_detail as $key => $dataAtt) {
                        $i++;
                        ?>
                        <li><a onclick="getProductsByCat(<?php echo $dataAtt['id'] ?>)" data-animated="fadeInLeft" data-toggle="tab" href="#tab-1"><?php echo $dataAtt['name']; ?></a></li>
                        <?php
                    }
                }
                ?>


            </ul>

            <div class="tab-content">
                <div class="tab-container product_display">

                    <div class="tab-panel active">
                        <ul id="catproducts" class="product-list-grid2 tab-list" data-nav="true" data-dots="true" data-margin="0" data-loop="true"  data-items="3">

                            <?php
                            if (isset($product_details)) {
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
                            }
                            ?>
                        </ul>

                    </div>
                    <div style="text-align:center;margin:10px 0" id="loaderimg"> <img style="height:150px" src="<?php echo base_url('assets/images/loader_2.gif') ?>"></div>
                    <div id="lst"><div style="text-align: center;"><a class="button-loadmore loadmore" id="loadmore"  data-service="all" data-page="1">load more</a></div></div>
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
</div>
<script>
    $("#loaderimg").hide();
    function getProductsByCat(catid) {
        $("#catproducts").hide();
        $("#loaderimg").show();

        $.ajax(
                {
                    method: "POST",
                    data: {'cat_id': catid, 'page': $("#loadmore").attr('data-page')},
                    url: href = "<?php echo base_url(); ?>home/home/getProducts",
                    dataType :"json",
                    success: function (data)
                    {
//                        alert(data);
//                        $.toaster({priority: 'success', title: 'Cart', message: 'Product has been added to the cart.'});
                        $("#catproducts").show();
                        $("#loaderimg").hide();
                        $("#catproducts").html(data.out);
                        $("#loadmore").attr('data-service', catid);
                        $("#lst").html(data.out1);
//                        $("#lst").remove();   

                    }
                });
    }

    $(document).on('click', '.loadmore', function () {
        $(this).text('Loading...');
        var ele = $(this).parent('div');
        $.ajax({
            url: base_url + 'home/home/loadMoreProducts',
            type: 'POST',
            data: {
                page: $(this).data('page'),
                cat_id: $(this).data('service'),
            },
            success: function (response) {
                //alert(response);
                if (response) {
                    ele.hide();
                    $("#catproducts").append(response);
                }
            }
        });
    });

</script>

