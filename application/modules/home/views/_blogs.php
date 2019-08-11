<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            
        <div class="page-title">
            <h1>Blogs</h1>  
            <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
        </div> 
         <div class="kopa-breadcrumb clearfix">
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a itemprop="url" href="index-2.html">
                    <span itemprop="title">Home</span>
                </a>
            </span>
            <span>&nbsp;&rsaquo;&nbsp;</span>
            <span class="current-page" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <span itemprop="title">Blogs</span>
            </span>
            <span class="bottom-line"></span>
        </div>
    </div>  
    <!-- top page above -->
    <div class="top-page-bottom clearfix">
        <div class="container">
            <div class="top-link">
                <a href="#" class="print"><i class="fa fa-print"></i>Print this page</a>
                <a href="#"><i class="fa fa-star"></i>Add to favourites</a>
                <div class="share-vehice">
                    <a href="#" class="share">
                        <i class="fa fa-share-alt"></i>Share Vehice                        
                    </a>
                    <div class="kopa-social-links">
                        <ul>
                            <li><a href="#" rel="nofollow" class="fa fa-facebook"></a></li>
                            <li><a href="#" rel="nofollow" class="fa fa-twitter"></a></li>
                            <li><a href="#" rel="nofollow" class="fa fa-google-plus"></a></li>
                            <li><a href="#" rel="nofollow" class="fa fa-pinterest"></a></li>
                        </ul>
                    </div> 
                </div>      
            </div>
            <a href="#" class="pre-page">Back to Previous Page</a>
        </div>
    </div>    
    <!-- top page bottom -->
</div>
<!-- kopa top page -->

<div id="main-content" class="pt-50">
    <div class="container">
        <div class="row">
            <div id="main-col" class="col-md-9"> 
                <div class="widget kopa-news-review-widget entry-box">
                    <ul class="clearfix">
   <?php
              //echo print_r($blog);
   if(isset($blog))
              foreach($blog as $b)
              {
                  
            
            ?>
                        <li class="sticky-post">
                            <article class="entry-item">
                                <div class="entry-thumb">
                                    <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>">
                                        <img src="<?php echo base_url() ?>media/backend/img/blog_image/<?=$b['blog_image']?>" alt="" />
                                    </a>
                                </div>
                                <div class="entry-content">
                                    <div class="meta-box clearfix">
                                         <?php
                                    $date =$b['posted_on'];
                                    $d=date('d', strtotime($date));
                                   $m=date('M', strtotime($date));
                                    ?>
                                        <span class="entry-date">
                                            <span class="entry-day"><?=$d;?></span>
                                            <span class="entry-month"><?=$m;?></span>
                                        </span>
                                        <div class="meta-box-right">
                                            <h2 class="entry-title">
                                                <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>"><?=$b['post_title']?></a>
                                            </h2>
                                            <footer>
                                                <span>Posted in:</span>
                                                <a href="#"><?=$b['suburb']?></a>, 
                                                <a href="#">car</a>
                                                <span class="comments"> 
                                                    <span>With:</span>                                
                                                    <a href="#">4 comments</a>
                                                </span>                                            
                                            </footer>
                                        </div>    
                                    </div>
                                    <p class="entry-excerpt"><?=$b['post_short_description']?></p>
                                    <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                </div>
                            </article>
                        </li>
   <?php
              }
              ?>
<!--                        <li>
                            <article class="entry-item">
                                <div class="entry-thumb">
                                    <div class="owl-carousel owl-single-item-2">
                                        <div class="item">
                                            <img src="<?php echo base_url()?>assets/placeholders/post-image/New-Reviews_03.jpg" alt="" />
                                        </div>
                                        <div class="item">
                                            <img src="<?php echo base_url()?>assets/placeholders/post-image/New-Reviews_06.jpg" alt="" />
                                        </div>
                                        <div class="item">
                                            <img src="<?php echo base_url()?>assets/placeholders/post-image/New-Reviews_09.jpg" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <div class="meta-box clearfix">
                                        <span class="entry-date">
                                            <span class="entry-day">18</span>
                                            <span class="entry-month">DEC</span>
                                        </span>
                                        <div class="meta-box-right">
                                            <h2 class="entry-title">
                                                <a href="<?php echo base_url();?>home/single_blog">gallery post format title</a>
                                            </h2>
                                            <footer>
                                                <span>Posted in:</span>
                                                <a href="#">kopatheme</a>, 
                                                <a href="#">car</a>
                                                <span class="comments"> 
                                                    <span>With:</span>                                
                                                    <a href="#">4 comments</a>
                                                </span>                                            
                                            </footer>
                                        </div>    
                                    </div>
                                    <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes. As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes.</p>
                                    <a href="<?php echo base_url();?>home/single_blog" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                </div>
                            </article>
                        </li>

                        <li>
                            <article class="entry-item">
                                <div class="entry-thumb">
                                    <blockquote class="quotes-2">
                                        AutoTrader team is very proffessional and has found for me the perfect car for my needs. I'll be sure to give them a call whenever I'll be needing a new set of wheels! Highly recommended! <br/>
                                        <div class="b-line">LUIS NGUYEN, Customer</div>
                                    </blockquote>                                     
                                </div>
                                <div class="entry-content">
                                    <div class="meta-box clearfix">                                            
                                        <div class="meta-box-right">                
                                            <footer>
                                                <span>Posted in:</span>
                                                <a href="#">kopatheme</a>, 
                                                <a href="#">car</a>
                                                <span class="comments"> 
                                                    <span>With:</span>                                
                                                    <a href="#">4 comments</a>
                                                </span>                                            
                                            </footer>
                                        </div>    
                                    </div>
                                    <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes. As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes.</p>
                                    <a href="<?php echo base_url();?>home/single_blog" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                </div>
                            </article>
                        </li>

                        <li>
                            <article class="entry-item">
                                <div class="entry-thumb">
                                    <div class="video-wrapper">
                                        <iframe width="900" height="380" src="https://www.youtube.com/embed/A-xELYboGMc" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <div class="meta-box clearfix">
                                        <span class="entry-date">
                                            <span class="entry-day">18</span>
                                            <span class="entry-month">DEC</span>
                                        </span>
                                        <div class="meta-box-right">
                                            <h2 class="entry-title">
                                                <a href="#">video post format title</a>
                                            </h2>
                                            <footer>
                                                <span>Posted in:</span>
                                                <a href="#">kopatheme</a>, 
                                                <a href="#">car</a>
                                                <span class="comments"> 
                                                    <span>With:</span>                                
                                                    <a href="#">4 comments</a>
                                                </span>                                            
                                            </footer>
                                        </div>    
                                    </div>
                                    <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes. As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes.</p>
                                    <a href="<?php echo base_url();?>home/single_blog" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                </div>
                            </article>
                        </li>

                        <li>                                
                            <article class="entry-item">
                                <div class="entry-thumb audio">
                                    <div class="audio-wrapper">
                                        <audio controls="" tabindex="0">
                                            <source type="audio/wav" src="<?php echo base_url()?>assets/placeholders/audio/adg3com_chuckedknuckles.wav">
                                            <source type="audio/mpeg" src="<?php echo base_url()?>assets/placeholders/audio/adg3com_chuckedknuckles.mp3">
                                        </audio>
                                    </div>      
                                </div>
                                <div class="entry-content">
                                    <div class="meta-box clearfix">
                                        <span class="entry-date">
                                            <span class="entry-day">18</span>
                                            <span class="entry-month">DEC</span>
                                        </span>
                                        <div class="meta-box-right">
                                            <h2 class="entry-title">
                                                <a href="#">audio post format title</a>
                                            </h2>
                                            <footer>
                                                <span>Posted in:</span>
                                                <a href="#">kopatheme</a>, 
                                                <a href="#">car</a>
                                                <span class="comments"> 
                                                    <span>With:</span>                                
                                                    <a href="#">4 comments</a>
                                                </span>                                            
                                            </footer>
                                        </div>    
                                    </div>
                                    <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes. As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be described as ‘minimal’. In truth, customers will be hard-pressed to tell the one from the other but, dig a little deeper, and you’ll notice the changes.</p>
                                    <a href="<?php echo base_url();?>home/single_blog" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                </div>
                            </article>
                        </li>-->

                    </ul>

                    <div class="kopa-pagination clearfix">
                        
                        <ul class="clearfix">
                            <?php foreach ($links as $link) { ?>


<!--                            <li><a href="#" class="first page-numbers fa fa-angle-double-left"></a></li>-->
                           
<li class=" page-numbers"><?=$link;?></li>                           <!--
-->                           
                            <?php
} ?>
<!--                            <li><a href="#" class="last page-numbers fa fa-angle-double-right" ></a></li>-->
                        </ul><!--page-numbers-->
                    </div>
                    <!-- kopa pagination -->  

                </div>                                
                <!-- kopa news review widget -->
            </div>
            <!-- main column -->

            <div id="sidebar" class="col-md-3"> 

                <div class="widget kopa-product-categories-widget">

                    <div class="widget-title title-s2">
                        <h3>Categories</h3>
                    </div>

                    <ul class="widget-content sf-menu sf-vertical">
                            <?php if (isset($prodcut_cat_detail)) { ?>
                                <?php foreach ($prodcut_cat_detail as $key => $dataAtt) { ?>
                                    <li >
                                        <a href="#" title=""><?php echo $dataAtt['name']; ?></a>
                                        <?php if (isset($dataAtt['sub_attibutes'])) { ?>
<!--                                            <ul>
                                                <?php foreach ($dataAtt['sub_attibutes'] as $dataSubAtt) { ?>
                                                    <li ><a href="<?php echo base_url() ?>home/shop/<?php echo $dataAtt['id'] ?>/<?php echo $dataSubAtt['p_sub_category_id'] ?>"><?php echo $dataSubAtt['attrubute_value']; ?></a></li>
                                                <?php } ?>
                                            </ul>-->
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            <?php } ?>

                        </ul>


                </div>
                <!-- .kopa-product-categories-widget -->

              
                <!-- kopa product list widget -->

                <div class="widget kopa-testimonials-widget testi-1"> 
                    <div class="widget-top">
                        <div class="widget-title title-s3">                        
                            <h3>Testimonials</h3>
                            <span class="red-bg"></span>
                        </div>                    
                        <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
                    </div> 
                        <div class="widget-content">
                            <div class="wrapper">
                                <div class="owl-carousel owl-testi-1">

                                    <?php if (isset($testi_monial))  ?>
                                    <?php foreach ($testi_monial as $tData) { ?>
                                        <div class="item">                                
                                            <p class="customer-comment"><span class="team-name"></span><?php echo $tData['testimonial'] ?></p>
                                            <span class="customer-avatar">
                                                <img src ="<?php echo base_url() ?>media/backend/img/testimonial_img/<?php echo $tData['image'] ?>" alt="" />

                                            </span>
                                            <span class="meta-info">
                                                <span class="custome-name"><?php echo $tData['name'] ?></span>,
                                                <span class="customer-job">Customer</span>
                                            </span>  
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>           
                </div>
                <!-- kopa testimonials widget --> 

<!--                <div class="widget kopa-service-widget">
                    <div class="widget-title title-s2">
                        <h3>popular service</h3>
                    </div>
                    <div class="widget-content">
                        <a href="#" class="item-thumb"><img src="<?php echo base_url()?>assets/placeholders/car/New-Reviews_18.jpg" alt="" /></a>                            
                        <h4 class="item-title"><a href="#">Lamborghini AventadorJ</a></h4>
                        <p class="ittem-intro">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best be</p>
                    </div>
                </div>-->
                <!-- kopa service widget -->

<!--                <div class="widget kopa-recent-tweets-widget tweet-2"> 

                    <div class="widget-title title-s2   ">
                        <h3>Twitter</h3>
                    </div>

                    <div class="widget-content">
                        <div class="tweet-item">
                            <p class="tweet-content">We had a fantastic time at <a href="#" class="hash-tag">#EnvatoLive</a> in Chicago today! See the photos here: <a href="#">http://on.fb.me/1mZXa7D</a></p>
                            <span>2 hours ago</span>
                        </div>
                        <div class="tweet-item">
                            <p class="tweet-content">We had a fantastic time at <span class="hash-tag">#EnvatoLive</span> in Chicago today! See the photos here: <a href="#">http://on.fb.me/1mZXa7D</a></p>
                            <span>2 hours ago</span>
                        </div>
                        <div class="tweet-item">
                            <p class="tweet-content">We had a fantastic time at <span class="hash-tag">#EnvatoLive</span> in Chicago today! See the photos here: <a href="#">http://on.fb.me/1mZXa7D</a></p>
                            <span>2 hours ago</span>
                        </div>
                    </div>

                </div>-->
                <!-- kopa recent tweet widget -->

            </div>
        </div>

    </div>       

</div>
<!-- main content -->
