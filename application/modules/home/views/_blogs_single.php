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
                <span itemprop="title">Single Blogs</span>
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
            <a href="<?=base_url()?>home/blogs" class="pre-page">Back to Previous Page</a>
        </div>
    </div>    
    <!-- top page bottom -->
</div>
<!-- kopa top page -->

<div id="main-content" class="pt-50">
    <div class="container">
        <div class="row">
            <div id="main-col" class="col-md-9"> 
<?php 
foreach($single_post as $b)
{
?>
                <div class="entry-box entry-single">

                    <div class="entry-thumb">
                        <img src ="<?php echo base_url() ?>media/backend/img/blog_image/<?=$b['blog_image']?>" alt="" />
                    </div>

                    <div class="entry-content">

                        <div class="meta-box clearfix">
                            
                           <span class="entry-date pull-left">
                                    <?php
                                    $date =$b['posted_on'];
                                    $d=date('d', strtotime($date));
                                   $m=date('M', strtotime($date));
                                    ?>
                                    <span class="entry-day"><?=$d;?></span>
                                    <span class="entry-month"><?=$m;?></span>
                                </span>
                            <div class="meta-box-right">
                                <h2 class="entry-title"><?=$b['post_title']?></h2>
                                <footer>
                                    <span>Posted in:</span>
                                    <a href="#"><?=$b['suburb']?></a>, 
<!--                                    <a href="#">car</a>-->
                                    <span class="comments"> 
                                        <span>With:</span>                                
                                        <a href="#">4 comments</a>
                                    </span>                                            
                                </footer>
                            </div>    
                        </div>  

                        <p align="justify"><?=$b['post_content']?></p>   

                        
                    </div>

                    <div class="clear"></div>

<!--                    <div class="page-links-wrapper">
                        <span class="page-links">
                            <span>pages:</span>
                            <span class="active">1</span>
                            <a href="#"><span>2</span></a>
                            <a href="#"><span>3</span></a>
                        </span>
                    </div>-->

                    <div class="tag-box">
                        <a href="#"><?=$b['post_tags']?></a>
<!--                        <a href="#">cars</a>
                        <a href="#">vehicle</a>
                        <a href="#">autor</a>-->
                    </div>

                </div>  
                <?php 
}
                ?>
                             

                <div id="related-posts" class="entry-box" style="margin-bottom: 13px">
                    <h3>related posts</h3>   
                    <div class="row">
                          <?php
                //echo print_r($blog);
                foreach ($related_blog as $b) {
                    ?>
                        <div class="col-md-6">
                            <article class="entry-item">
                              
                                 <div class="entry-item">
                            <div class="entry-thumb">
                                <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>">
                                        <img src="<?php echo base_url() ?>media/backend/img/blog_image/<?=$b['blog_image']?>" alt="" />
                                    </a> 
                            </div>
                            <div class="entry-content"> 
                                <div class="meta-box clearfix">
                                    <span class="entry-date pull-left">
                                        <?php
                                        $date = $b['posted_on'];
                                        $d = date('d', strtotime($date));
                                        $m = date('M', strtotime($date));
                                        ?>
                                        <span class="entry-day"><?= $d; ?></span>
                                        <span class="entry-month"><?= $m; ?></span>
                                    </span>
                                    <div class="meta-box-right">
                                        <h6 class="entry-title">
                                                <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>"><?=$b['post_title']?></a>
                                        </h6>
                                        <footer>
                                            <span>Posted in:</span>
                                            <a href="#"><?= $b['suburb'] ?></a>, 
                                            <!--                                        <a href="#">car</a>-->
                                            <!--                                        <span class="comments"> 
                                                                                        <span>With:</span>
                                                                                        <a href="#">4</a>
                                                                                        <i class="fa fa-comments-o"></i>
                                                                                    </span>                                            -->
                                        </footer>
                                    </div>
                                </div>
                                <p class="entry-excerpt"><?= $b['post_content'] ?></p>
                                <a href="#" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                            </div>  
                        </div> 
                            </article>
                        </div>
                        <?php
                        }
                        ?>
<!--                        <div class="col-md-6">
                            <article class="entry-item">
                                <div class="entry-thumb">
                                    <a href="#"><img src="<?php echo base_url()?>assets/placeholders/post-image/SingleBlogok_405-230-1.jpg" alt=""></a>
                                </div>
                                <div class="entry-content"> 
                                    <div class="meta-box clearfix">
                                        <span class="entry-date pull-left">
                                            <span class="entry-day">18</span>
                                            <span class="entry-month">DEC</span>
                                        </span>
                                        <div class="meta-box-right">
                                            <h6 class="entry-title">
                                                <a href="#">MORBI NON SEM A LACUS PORTA SUSPENDISSE VITAE SAPIEN</a>
                                            </h6>
                                            <footer>
                                                <span>Posted in:</span>
                                                <a href="#">kopatheme</a>, 
                                                <a href="#">car</a>
                                                <span class="comments"> 
                                                    <span>With:</span>                                   
                                                    <a href="#">4</a>
                                                    <i class="fa fa-comments-o"></i>
                                                </span>                                            
                                            </footer>
                                        </div>
                                    </div>
                                    <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best</p>
                                    <a href="#" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                </div>
                            </article>
                        </div>-->
                    </div> 
                </div>
                <!-- related posts -->

<!--                <div id="respond">
                    <h4>Leave your comments</h4>   
                    <p class="c-note">Your email address will not be published. Required fields are marked <span>*</span></p>            
                    <form class="comments-form clearfix" action="http://upsidethemes.net/demo/verado/html/processForm.php" method="post" novalidate="novalidate">                           
                        <div class="row comment-top">
                            <div class="col-md-4">  
                                <p class="input-block">
                                    <label class="required" for="comment_name">Name <span>*</span></label>
                                    <input type="text" class="valid" name="name" id="comment_name" onblur="if (this.value == '')
                                                    this.value = 'Name *';" onfocus="if (this.value == 'Name *')
                                                                this.value = '';" value="Name *">
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="input-block">
                                    <label class="required" for="comment_email">Email <span>*</span></label>
                                    <input type="text" class="valid" name="email" id="comment_email" onblur="if (this.value == '')
                                                    this.value = 'Email *';" onfocus="if (this.value == 'Email *')
                                                                this.value = '';" value="Email *">
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="input-block">                                                
                                    <label class="required" for="comment_url">Website</label>
                                    <input type="text" id="comment_url" onblur="if (this.value == '')
                                                    this.value = 'Website';" onfocus="if (this.value == 'Website')
                                                                this.value = '';" value="Website" class="valid" name="url">         
                                </p>
                            </div>

                        </div>

                        <div class="comment-bottom">
                            <p class="textarea-block">                        
                                <label class="required" for="comment_message">Your comment <span>*</span></label>
                                <textarea rows="6" cols="88" id="comment_message" name="message" onblur="if (this.value == '')
                                                this.value = 'Your comments *';" onfocus="if (this.value == 'Your comments *')
                                                            this.value = '';">Your comments *</textarea>
                            </p>
                        </div>                         

                        <div class="form-submit">
                            <button>Post comment <i class="fa fa-paper-plane"></i></button>
                        </div>

                    </form>

                </div>-->
                <!-- respond -->    

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
                                                    <li ><?php echo $dataSubAtt['attrubute_value']; ?></li>
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

               
                <!-- kopa service widget -->

               
                <!-- kopa recent tweet widget --> 

            </div>
            <!-- sidebar -->                
        </div>
        <!-- row -->            
    </div>   
    <!-- container -->  
</div>
<!-- main content -->

