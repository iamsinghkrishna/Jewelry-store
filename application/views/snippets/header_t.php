<?php // echo '<pre>', print_r($cart_items);  die;?>
<div class="se-pre-con">
    <div class="loader-div">
        <div class="center-loader-div"></div>
    </div>
</div>
<div class="clearfix">

    <div class="header-top clearfix">

        <div class="wrapper clearfix">



            <div class="logo-image">

                <span>

                    <a href="<?php echo base_url() ?>" title="Auto Trader">

                        <img src="<?php echo base_url() ?>assets/placeholders/logo.png" width="259" height="58" alt="Verado">

                        <span class="sr-only">Verado</span>

                    </a>

                </span>

            </div>

            <!-- #logo-image -->



            <div class="login-wrapper">

                <ul>

                    <li><span>Welcome!</span></li>

                    <li><a href="#">Sign in</a></li>

                    <li><span class="sepa">i</span></li>

                    <li><a href="#">Register</a></li>

                </ul>

            </div>                

            <!-- .login-wrapper -->



            <nav class="page-nav">

                <span class="quick-link">Quick links <i class="fa fa-angle-down"></i></span>

                <ul>

                    <li><a href="#">My Account</a></li>

                    <li><a href="#">Wishlist</a></li>

                    <li><a href="#">My Cart</a></li>

                    <li><a href="#">Checkout</a></li>

                    <li><a href="#">Log In</a></li>

                </ul>

            </nav>

            <!-- .page-top -->



        </div>

    </div>

    <!-- .header-top -->



    <div class="header-middle clearfix">

        <div class="wrapper clearfix">

            <div class="on-shoping-box row">

                <div class="col-md-9">

                    <div class="item fa fa-truck">

                        <p class="h6">Free Ship</p>

                        <p>on order over $75.00</p>

                    </div>

                    <div class="item fa fa-rotate-right">

                        <p class="h6">Free Return</p>

                        <p>free 90 days return policy</p>

                    </div>

                    <div class="item fa fa-money">

                        <p class="h6">Member discount</p>

                        <p>free register</p>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="item shopping-cart fa fa-shopping-cart ">

                        <a href="<?php echo base_url(); ?>home/cart" class="h6">Shopping Cart</a>

                        <p><span id="id_cart_total"><?php echo isset($cart_items) ? count($cart_items) : '0'; ?></span> - <span><?php echo isset($cart_items['price_total']) ? $cart_items['price_total'] : '$0.00' ?></span></p>

                    </div>

                    <!--.shopping-cart-->

                </div>

            </div>

            <!--.on-shoping-box-->

        </div>

    </div>

    <!-- .header-middle -->



</div>



<div class="header-bottom">

    <div class="wrapper clearfix">

        <div class="waypoint">

            <nav id="main-nav" class="clearfix">



                <ul id="main-menu">

                    <li>

                        <a href="#"><span>Home</span></a>

                        <div class="sub-main-menu-o sf-mega">

                            <ul class="sub-menu">

                                <li><a href="<?php echo base_url() ?>">Home</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'home_search' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/home_search">Home Search</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'home_shop' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/home_shop">Home Shop</a></li>

                            </ul>

                        </div>

                    </li>

                    <li><a href="#"><span>Buy a Car</span></a></li>

                    <li class="current-menu-item">

                        <a href="<?php echo base_url() ?>home/sell_car"><span>Sell a Car</span></a>

                    </li>

                    <li>

                        <a href="<?php echo base_url() ?>home/news_review"><span>News and reviews</span></a>



                        <div class="sub-main-menu sf-mega">

                            <div class="row">



                                <div class="col-md-3">

                                    <ul class="sub-menu nav nav-tabs">

                                        <li class="active"><a href="#tab9-1">New car reviews</a></li>

                                        <li><a href="#tab9-2" data-toggle="tab">New car deal</a></li>

                                        <li><a href="#tab9-3" data-toggle="tab">Owner reviews</a></li>

                                        <li><a href="#tab9-4" data-toggle="tab">Latest New</a></li>

                                    </ul>

                                </div>



                                <div class="col-md-9 news-wrapper tab-content">

                                    <div class="tab-pane active" id="tab9-1">

                                        <div class="row">

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-1.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-2.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-3.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                        </div>                                                

                                    </div>

                                    <div class="tab-pane" id="tab9-2">

                                        <div class="row">

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-3.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-2.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-1.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                        </div>                                                

                                    </div>

                                    <div class="tab-pane" id="tab9-3">

                                        <div class="row">

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-1.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-2.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-3.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                        </div>                                                

                                    </div>

                                    <div class="tab-pane" id="tab9-4">

                                        <div class="row">

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-3.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-2.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                            <div class="col-md-4">

                                                <article class="item">

                                                    <a href="<?php echo base_url() ?>home/news_review"><img src="<?php echo base_url() ?>assets/placeholders/post-image/image-283-120-1.jpg" width="283" height="120" alt=""></a>

                                                    <h3><a href="<?php echo base_url() ?>home/news_review" title="">Porche 977 gt3 cup 'sun edition'</a></h3>

                                                </article>

                                            </div>

                                        </div>                                                

                                    </div>

                                </div>



                            </div>

                        </div>

                        <!--.sub-main-menu-->

                    </li>

                    <li><a href="#"><span>Car Insurance</span></a></li>

                    <li><a href="#"><span>Car Finance</span></a></li>

                    <li>

                        <a href="#"><span>Page</span></a>

                        <div class="sub-main-menu-o sf-mega">

                            <ul class="sub-menu">

                                <li class="<?php echo $this->uri->segment(2) == 'about_us' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/about_us"><span>About Us</span></a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'blogs' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/blogs"><span>Blogs</span></a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'search_car' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/search_car">Search Car</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'shop' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/shop"><span>Shop</span></a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'shop_product' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/shop_product">Shop Product</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'element' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/element">Element</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'contact_us' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/contact_us"><span>Contact Us</span></a></li>

                            </ul>

                        </div>



                    </li>

                    <li><a href="#"><span>My Watchlist</span></a></li>

                </ul>



                <i class='fa fa-align-justify'></i>



                <div class="mobile-menu-wrapper">

                    <ul id="mobile-menu">

                        <li>

                            <a href="#">Home</a>

                            <ul>

                                <li><a href="#">Home</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'home_search' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/home_search">Home Search</a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'home_shop' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/home_shop">Home Shop</a></li>

                            </ul>

                        </li>

                        <li><a href="#">Buy a Car</a></li>

                        <li class="current-menu-item"><a href="<?php echo base_url() ?>home/sell_car">Sell a Car</a></li>

                        <li>

                            <a href="<?php echo base_url() ?>home/news_review">News and reviews</a>

                            <ul>

                                <li><a href="<?php echo base_url() ?>home/news_review">New car reviews</a></li>

                                <li><a href="<?php echo base_url() ?>home/news_review">New car deal</a></li>

                                <li><a href="<?php echo base_url() ?>home/news_review">Owner reviews</a></li>

                                <li><a href="<?php echo base_url() ?>home/single_post">Latest New</a></li>

                            </ul>

                        </li>

                        <li><a href="#">Car Insurance</a></li>

                        <li><a href="#">Car Finance</a></li>

                        <li>

                            <a href="#">Page</a>

                            <ul>

                                <li><a href="<?php echo base_url() ?>home/about_us"><span>About Us</span></a></li>

                                <li class="<?php echo $this->uri->segment(2) == 'blogs' ? 'current-menu-item' : '' ?>"><a href="<?php echo base_url() ?>home/blogs"><span>Blogs</span></a></li>

                                <li><a href="<?php echo base_url() ?>home/search_car">Search Car</a></li>

                                <li><a href="<?php echo base_url() ?>home/shop"><span>Shop</span></a></li>

                                <li><a href="<?php echo base_url() ?>home/shop_product">Shop Product</a></li>

                                <li><a href="<?php echo base_url() ?>home/element">Element</a></li>

                                <li><a href="<?php echo base_url() ?>home/contact_us"><span>Contact Us</span></a></li>

                            </ul>

                        </li>

                        <li><a href="#"><span>My Watchlist</span></a></li>

                    </ul>

                    <!-- mobile-menu -->

                </div>

                <!-- mobile-menu-wrapper -->



            </nav>



            <div class="search-top">

                <form>

                    <div class="input-group">

                        <input type="text" class="form-control" placeholder="Search" value="" name="search">

                        <span class="input-group-btn">

                            <button class="btn btn-default" type="button"><i class="fa fa-search" onclick="alert('a');"></i></button>

                        </span>

                    </div><!-- /input-group -->

                </form>

            </div>

            <!-- .search-wrapper -->

        </div>

        <!-- .waypoint -->

    </div>

</div>

<!-- .header-bottom -->