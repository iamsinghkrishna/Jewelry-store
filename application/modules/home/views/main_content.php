<!-- Home slide -->
<div class="se-pre-con">
    <div class="loader-div">
        <div class="center-loader-div"></div>
    </div>
</div>

<div class="full-window-height">
    <div class="paralax_effect">
        <div class="home-slide5 slide-fullscreen owl-carousel nav-style4 nav-center-center" data-animateout="fadeOut" data-animatein="fadeIn" data-items="1" data-nav="true" data-dots="true" data-loop="true" data-autoplay="true">

            <?php foreach ($slide as $sld) { ?>

                <div class="item-slide full-height" data-background="<?php echo base_url($sld['banner_image']) ?>">

                    <div class="row">

                        <div class="container">

                            <div class="slider-content">

                                <!--                <div class="col-md-6">
                                                    </div>
                                <-->

                                <div class="col-md-12 text-<?php echo $sld['style']; ?>">

                                    <img class="logo-banner img-parallax" src="<?php echo base_url('assets/images/Vaskia_Logo_banner.png') ?>"/>

                                    <!--div class="banner-divider"></div-->

                                    <div style="clear:both"></div>

                                    <h1><?php echo $sld['title']; ?></h1>

                                    <p><?php echo $sld['description']; ?></p>
                                    <?php
                                    if ($sld['link'] != '' && isset($sld['link'])
                                        && !empty($sld['link'])) {
                                        ?>
                                        <a style="    color: #fff !important;
                                           /*background: #AEA46F;*/
                                           border:2px solid #fff;
                                           -webkit-transition: all .1s ease-out;
                                           padding: 10px;
                                           font-size: 15px;
                                           font-weight: normal;" class="banner-btn" href="<?php echo $sld['link']; ?>"><?php echo $sld['call_to_action']; ?></a>
                                       <?php } ?>
                                </div>



                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>



        </div>
    </div>
</div>

<!-- ./Home slide -->


<div class="bg_color_white">

    <!-- <center class="slider_below_text">
        "<span class="fontbig">Make This Valentine Special For Her</span> <br/>
        Express your love this Valentine...<br/>
        not with words but with our Valentine special love collection"
    </center> -->
     <center class="slider_below_text">
        "<span class="fontbig">Vaskia is timeless elegance</span> <br/>
        Untouched by fast trends and disposable fashions.<br/>
        We are for the effortlessly cool, the sophisticated and the refined."
    </center>

    <?php
    if (!empty($product_feature_details)) {
//    echo "<pre>";
//    print_r($product_feature_details);
//    die;
        foreach ($product_feature_details as $key => $val) {
            ?>


            <div class="product_display margin-top-25">

                <div class="container">


                    <a href="javascript:;" class="no-style">
                        <div class="title_text_div">

                            <a href="<?php echo base_url(); ?>home/category/<?php echo $val['p_category_id']; ?>/<?php echo $val['p_sub_category_id']; ?>"><h2><?php echo $val['attrubute_value']; ?><i class="fa fa-caret-down" aria-hidden="true"></i></h2></a>

                        </div>
                    </a>



                    <ul class="product-list-grid desktop-columns-3 tablet-columns-3 mobile-columns-1 row flex-flow">

                        <?php
                        if (isset($val['product_details'])) {

                

                            foreach ($val['product_details'] as $bs) {

//                        print_r($bs['product_images_details']);die;
                                ?>

                                <li class="product-item col-sm-4">

                                    <div class="product-inner">

                                        <div class="product-thumb has-back-image">

                                            <a href="<?php echo base_url() ?>home/shop_product/<?php echo $bs['id'] ?>/<?php echo base64_encode($bs['category_id']); ?>"><img src="<?php echo base_url($bs['url']) ?>" alt=""></a>

                                            <a class="back-image" href="<?php echo base_url() ?>home/shop_product/<?php echo $bs['id'] ?>/<?php echo base64_encode($bs['category_id']); ?>"><img src="<?php echo base_url($bs['hover_img_url']) ?>" alt=""></a>



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
            <?php
        }
    }
    ?>


    <!--<a href="" data-toggle="modal" data-target="#instadetails">Insta pop up</a>-->



    <!-- Modal -->



    <!-- End Section -->

<!--
    <?php //if (count($promotions) > 0) { ?>
        <div id="promoModal" class="modal fade in" role="dialog">
            <div class="modal-dialog">

                 Modal content
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="mobalclose-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                        <?php
//                        if ($promotions[0]['type'] == '1') {
//                            echo $promotions[0]['content'];
//                        } else {
//                            echo "<img src='".base_url()."backend/uploads/promotional_banners/".$promotions[0]['banner_image']."'>";
//                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    <?php //} ?>
    
    -->
    
        <div id="promoModalNewsletter" class="modal fade in" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="mobalclose-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                        <img class="img-responsive" style="width: 100%" src="<?php echo base_url() ?>assets/images/Pop_Up_Img.png">
                        <!--p>Subscribe to our newsletters and don’t miss our exclusive offers and promotions.</p-->
                        <form id="promo_newsletter_frm" name="promo_newsletter_frm" class="newletter" action="<?php echo base_url(); ?>/admin/newsletter_subscriber/addNewsletterSubscriberPromo" method="post">
                            <div class="input_email">
                                <input class="email-text" id="user_email_newsletter" name="user_email_newsletter" required="required" type="email" value="" placeholder="Your email address here...">
                                <input type="submit" name="promo_newsletter" id="promo_newsletter" value="SUBSCRIBE" >
                                <img style="display:none;" id="promo_loader" name="promo_loader" src="<?php echo base_url() ?>assets/images/xloading.gif" />
                            </div>
                            <div id="message_success" style="display:none;">
                                <span style="color:green">You have successfully subscribed to our newsletter.</span>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    <script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
    <input type="hidden" name="total_promotions" id="total_promotions" value="<?php echo count($promotions); ?>" />
    <script>
        $(document).ready(function () {
//            var total_promotions = $('#total_promotions').val();
//
//            if (total_promotions != '' && total_promotions > 0) {
//                setTimeout(function () {
//                    $('#promoModal').modal();
//                }, <?php echo $promotions[0]['display_after']; ?>);
//            }


            $('#promoModalNewsletter').modal();
            
            
             
    $("#promo_newsletter_frm").validate({
        errorElement: "div",
        highlight: false,
        rules: {
             user_email_newsletter: {
                required: true,
                remote:{
                    url: '<?php echo base_url(); ?>' + 'admin/Newsletter_Subscriber/newsletterSubscribtionchk',
                    method: 'post',
                    //data: {old_user_name: $('#old_user_name').val()}
                }
            },
            
        },
        messages: {
            user_email_newsletter:{
                required: "Please enter your email",
                remote:"You have already subscribed to our newsletter.",
                //lettersonly: "Please enter valid name."
            },
           
        },
        submitHandler: function(form) {
            $("#promo_newsletter").css('display','none')
            $('#promo_loader').css('display','inline');
            
            sendNewsletter();
            
                //form.submit();
            
            
        }
    });
    
            
        });
        
        function sendNewsletter(){
            var formData = new FormData($("#promo_newsletter_frm")[0]);
                //alert(formData);
                $.ajax({
                    type: "POST",
                     url: '<?php echo base_url(); ?>'+'admin/Newsletter_Subscriber/addNewsletterSubscriberPromo',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    mimeType: "multipart/form-data",
                    dataType: 'html',
                    success: function (data)
                    {
                        $('#user_email_newsletter').val('');
                         $('#promo_loader').css('display','none');  
                       if(data == 1){
                         $('#message_success').css('display','inline');
                         setTimeout(function(){ 
                           $('#promoModalNewsletter').modal('hide');
                         }, 900);
                       }
                    }
                });
        }
    </script>