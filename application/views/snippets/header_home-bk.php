<style type="text/css">

   #header .logo{
	   margin-top:10px
   }

   
   #header-ontop.is-sticky.on-sticky nav_bar_Logo{
	       margin-top: 10px;
    margin-bottom: 10px;
   }

    .is-sticky.on-sticky .header .nav_bar_Logo {
        display: block !important;
    }

    .is-sticky.on-sticky .header .logo {
        display: none !important;
    }

    .is-sticky.on-sticky .header .main-menu>li>a {
        color: #656a92;
    }

    .is-sticky.on-sticky .header .main-menu>li>a:hover {
        color: #b0a46e;
    }

    .main-menu>li>a {
        color: #ffffff;
    }

    .main-menu>li>a:hover {
        color: #ffffff;
    }

	
    .header.style20 .main-menu>li>a:before, 
    .header.style20 .main-menu>li>a:after {
        background-color: #ffffff;
    }

    .is-sticky.on-sticky .header.style20 .main-menu>li>a:before, 
    .is-sticky.on-sticky .header.style20 .main-menu>li>a:after {
        background-color: #b0a46e;
    }

    .header.style20 .main-menu{
        float: left;
        margin: 0;
        margin-top: 33px;
        margin-bottom: 14px;
    }

    .home-slide5 {
        top: -120px;
        z-index: -1;
    }

    .slide-fullscreen .item-slide {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    } 

    .img-parallax {
        width: 100vmax;
        z-index: -1;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-50%,0);
        pointer-events: none
    }

    .header.style20 .main-menu>li>a.noeffect:before, .header.style20 .main-menu>li>a.noeffect:after {
        content:'';
        height: 0;
    }
	
	.title_text_div {
		-webkit-transition: all 0.3s ease 0s;
		-o-transition: all 0.3s ease 0s;
		transition: all 0.3s ease 0s;
	} 

	.title_text_div:hover {
		background: rgba(223, 217, 192, 0.74);
		/*background: -moz-linear-gradient(left, #ffffff 0%, #878cb4 23%, #878cb4 49%, #878cb4 79%, #ffffff 100%);
		background: -webkit-linear-gradient(left, #ffffff 0%,#878cb4 23%,#878cb4 49%,#878cb4 79%,#ffffff 100%);
		background: linear-gradient(to right, #ffffff 0%,#878cb4 23%,#878cb4 49%,#878cb4 79%,#ffffff 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=1 );*/
	}
	#header .logo {
		margin-top: 0px;
		padding-top:0;
	}
</style>



<header id="header" class="header style2 style20">

    <div class="container">

        <div class="main-header">

         

            <div class="main-menu-wapper">

                <div class="main-menu-inner">

                    <span class="mobile-navigation"><i class="fa fa-bars"></i></span>

					   <div class="col-md-2 left-alignment">

                        <div class="nav_bar_Logo">

                            <a href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/images/Logo_Vaskia.png') ?>" alt=""></a>

                        </div>

                        <div class="logo">

                            <a href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/images/White_logo.png') ?>" alt=""></a>

                        </div>

                    </div>
					
					


                    <div class="col-md-10">

                        <ul class="boutique-nav main-menu clone-main-menu">
                            <li class="">

                                <a href="<?php echo base_url() ?>home/">Home</a>

                            </li>
                            <?php

                             //echo "<pre>";print_R($prodcut_cat_detail_original);die; 

                            if (isset($prodcut_cat_detail_original)) {

                                ?>

                                <?php

                                foreach ($prodcut_cat_detail_original as $key => $dataAtt) {

                                    if ($dataAtt['is_subcategory'] == '0' && $key < 3) {

                                        ?>

                                        <li class="<?php

                                        if (isset($dataAtt['sub_attibutes']) && !empty($dataAtt['sub_attibutes'])) {

                                            echo 'menu-item-has-children';

                                        }

                                        ?> item-megamenu">



                                            <a href="<?php echo base_url() ?>home/category/<?php echo $dataAtt['id'] ?>"><?php echo $dataAtt['name']; ?></a>



                                            <span class = "item-menu-arow"></span>

                                            <?php if (isset($dataAtt['sub_attibutes'])) { ?>

                                                <div style="width:900px;" class="sub-menu megamenu">

                                                    <div class="row">

                                                        <div class="col-sm-4">

                                                            <div class="mega-custom-menu">

                                                                <h3 class="new-title"><span><?php echo $dataAtt['name']; ?></span></h3>

                                                                <p>

                                                                    <?php echo $dataAtt['description'] ?>

                                                                </p>



                                                            </div>

                                                        </div>

                                                        <div class="col-sm-4">

                                                            <div class="mega-custom-menu">

                                                                <h3 class="new-title"><span></span></h3>



                                                                <ul>



                                                                    <?php

//                                                    echo "count is ".floor(count($dataAtt['sub_attibutes']) / 2);

                                                                    $array1 = array_slice($dataAtt['sub_attibutes'], 0, ceil(count($dataAtt['sub_attibutes']) / 2));

                                                                    $array2 = array_slice($dataAtt['sub_attibutes'], ceil(count($dataAtt['sub_attibutes']) / 2), count($dataAtt['sub_attibutes']));

//                                                    echo "<pre>";print_r($array1);die;

                                                                    foreach ($array1 as $k => $dataSubAtt) {

                                                                        ?>



                                                                        <li <?php if(count($dataSubAtt['third_level_sub_attributes']) > 0) {?> <?php } ?> id = "menu-item-246" class = "menu-item menu-item-type-custom menu-item-object-custom menu-item-246">

                                                                            <a href="<?php echo base_url() . 'home/category/' . $dataSubAtt['p_category_id'] . '/' . $dataSubAtt['p_sub_category_id'] ?>" id="id_filter_term_<?php echo $dataSubAtt['id'] ?>" >

                                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                                                 <?php if(count($dataSubAtt['third_level_sub_attributes']) > 0) {?>
                                                                                    <span class="caret"></span>
                                                                                 <?php } ?>

                                                                            </a>
                                                                             <?php if(count($dataSubAtt['third_level_sub_attributes']) > 0) {?>
                                                                            <ul class="dropdown-menu">
                                                                                <?php foreach($dataSubAtt['third_level_sub_attributes'] as $keysss=> $third_level_sub_attributes){ ?>
                                                                                <li><a href="<?php echo base_url() . 'home/category/' . $dataSubAtt['p_category_id'] . '/' . $dataSubAtt['p_sub_category_id'] .'/'.$third_level_sub_attributes['id'];?>"><?php echo $third_level_sub_attributes['name']; ?></a></li>
                                                                                <?php } ?>
                                                                               
                                                                            </ul>
                                                                            <?php } ?>

                                                                        </li>

                                                                    <?php } ?>



                                                                </ul>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-4">

                                                            <div class="mega-custom-menu">

                                                                <h3 class="new-title"><span></span></h3>

                                                                <ul>

                                                                    <?php

                                                                    foreach ($array2 as $k => $dataSubAtt1) {

                                                                        ?>
                                                                        <li id = "menu-item-246" class = "menu-item menu-item-type-custom menu-item-object-custom menu-item-246">

                                                                            <a <?php if(count($dataSubAtt1['third_level_sub_attributes']) > 0) {?> <?php } ?> href="<?php echo base_url() . 'home/category/' . $dataSubAtt1['p_category_id'] . '/' . $dataSubAtt1['p_sub_category_id'] ?>" id="id_filter_term_<?php echo $dataSubAtt1['id'] ?>" >

                                                                                <?php echo $dataSubAtt1['attrubute_value']; ?>
                                                                                 <?php if(count($dataSubAtt1['third_level_sub_attributes']) > 0) {?>
                                                                                    <span class="caret"></span>
                                                                                 <?php } ?>

                                                                            </a>
                                                                             <?php if(count($dataSubAtt1['third_level_sub_attributes']) > 0) {?>
                                                                            <ul class="dropdown-menu">
                                                                                <?php foreach($dataSubAtt1['third_level_sub_attributes'] as $keysss=> $third_level_sub_attributes){ ?>
                                                                                <li><a href="<?php echo base_url() . 'home/category/' . $dataSubAtt1['p_category_id'] . '/' . $dataSubAtt1['p_sub_category_id'] .'/'.$third_level_sub_attributes['id'];?>"><?php echo $third_level_sub_attributes['name']; ?></a></li>
                                                                                <?php } ?>
                                                                               
                                                                            </ul>
                                                                            <?php } ?>

                                                                        </li>
                                                                    <?php } ?>



                                                                </ul>

                                                            </div>

                                                        </div>





                                                    </div>

                                                </div>



                                                <?php

                                            }

                                        }
                                        ?>
                                    </li>

                                <?php } ?>

                            <?php } ?>


			  <li class="">

                                <a href="<?php echo base_url() ?>home/about_us">About</a>

                            </li>



                            <li class="">

                                <a href="<?php echo base_url() ?>home/contact_us">Contact</a>

                            </li>



                            <li class="">

                                <a href="<?php echo base_url() ?>home/cart"><span class="icon pe-7s-cart"></span> Cart <span class="id_cart_total"><?php echo!empty($cart_summary['total_rows']) ? "(" . $cart_summary['total_rows'] . ")" : '(0)' ?></span></a>



                            </li>

                            <li class="menu-item-has-children item-megamenu"> 

                                <?php
                                if (!$this->ion_auth->logged_in()) {

                                    // redirect them to the login page

                                    echo'<a href="' . base_url() . 'home/login">Login</a>';
                                } else {
                                    //echo '<pre>';print_r($dataHeader);die;

									//echo'<a href="' . base_url() . 'home/orders">My Account</a>';
								?>
							</li>

                            <!--<li class="new-close-menu close-menu">

                                    <a href="javascript:;">Close</a>

                            </li>-->

                            <li id = "menu-item-244" class = "menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-244 menu-item-has-children">

                                    <a title = "Blog" href = "#" class="noeffect"><span class = "title-nav-mn">
                                            <?php if($dataHeader['picture_url'] != ''){ ?>
                                            <img src="<?php echo $dataHeader['picture_url']; ?>" class="user-icon">
                                            <?php } else{?>
                                                <img src="<?php echo base_url() ?>assets/images/user.png" class="user-icon">
                                            <?php } ?>
                                                
                                            <?php echo $dataHeader['first_name'] ?></span></a>

                                    <span class = "item-menu-arow"></span>

                                    <ul role = "menu" class = " sub-menu">

                                        <li id = "menu-item-246" class = "menu-item menu-item-type-custom menu-item-object-custom menu-item-246">

                                            <a title = "Blog left sidebar" href = "<?php echo base_url() ?>home/my_profile"><span class = "title-nav-mn">My Profile</span></a></li>
                                        <li id = "menu-item-246" class = "menu-item menu-item-type-custom menu-item-object-custom menu-item-246">

                                            <a title = "Blog left sidebar" href = "<?php echo base_url() ?>home/orders"><span class = "title-nav-mn">My Orders</span></a></li>

                                        <li id = "menu-item-246" class = "menu-item menu-item-type-custom menu-item-object-custom menu-item-246">

                                            <a title = "wihlist" href = "<?php echo base_url() ?>home/wishlist"><span class = "title-nav-mn">My Wishlist</span></a></li>

                                        <li id = "menu-item-929" class = "menu-item menu-item-type-post_type menu-item-object-post menu-item-929"><a title = "Single post" href = "<?php echo base_url() . 'auth/logout_home' ?>"><span class = "title-nav-mn">Logout</span></a></li>

                                    </ul>

                                </li>

                                

                            <?php }
                            ?>







                        </ul>

                   



                    

                        <ul class="boutique-nav main-menu clone-main-menu">

                            
                        </ul>

                    </div>
					 <div class="clearfix"></div>

                </div>

            </div>
			  

        </div>

    </div>

</header>