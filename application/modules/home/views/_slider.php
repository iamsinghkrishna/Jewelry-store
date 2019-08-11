<div class="slide-wrapper-inner loading">
            <div id="kopa-owl-top-slide" class="slide owl-carousel">
<?php
        
//print_r();
foreach($slider as $slide)
{
?>
                <div class="item">
                    <a href="#">
                        <img class="lazyOwl" src="<?php echo base_url() ?>media/backend/img/slider_img/<?=$slide['banner_image']?>" width="1366" height="500" alt="">
                        <div class="mask"></div>
                    </a>
                    <div class="intro top-slide-intro">
                        <h2 class="title"><a href="#"><?=$slide['title']?></a></h2>
                        <p><?=$slide['description']?></p>
                        <div class="view-more">  
                            <span class="bg-1"></span>              
                            <span class="bg-2"></span>
                            <span class="bg-3"></span>
                            <a href="<?=$slide['link']?>" class="link" target="_blank">read more</a>                  
                        </div>   
                    </div>                          
                </div>
            <?php
}
?>
<!--                <div class="item">
                    <a href="#">
                        <img class="lazyOwl" src="<?php echo base_url() ?>assets/placeholders/slider/slide-8.jpg" width="1366" height="500" alt="">
                        <div class="mask"></div>
                    </a>
                    <div class="intro top-slide-intro">
                        <h2 class="title"><a href="#">Lorem ipsum dolor</a></h2>
                        <p>Aenean dui lectus, accumsan nec nulla sit amet, consectetur iaculis neque. Ut nec odio sem. Donec aliquam posuere imperdiet. Morbi luctus dolor id fringilla sagitis.</p>
                        <div class="view-more">  
                            <span class="bg-1"></span>              
                            <span class="bg-2"></span>
                            <span class="bg-3"></span>
                            <a href="#" class="link">read more</a>                  
                        </div>   
                    </div>                        
                </div>

                <div class="item">
                    <a href="#">
                        <img class="lazyOwl" src="<?php echo base_url() ?>assets/placeholders/slider/slide-4.jpg" width="1366" height="500" alt="">
                        <div class="mask"></div>
                    </a>
                    <div class="intro top-slide-intro">
                        <h2 class="title"><a href="#">Lorem ipsum dolor</a></h2>
                        <p>Aenean dui lectus, accumsan nec nulla sit amet, consectetur iaculis neque. Ut nec odio sem. Donec aliquam posuere imperdiet. Morbi luctus dolor id fringilla sagitis.</p>
                        <div class="view-more">  
                            <span class="bg-1"></span>              
                            <span class="bg-2"></span>
                            <span class="bg-3"></span>
                            <a href="#" class="link">read more</a>                  
                        </div>   
                    </div>   
                </div>

                <div class="item">
                    <a href="#">
                        <img class="lazyOwl" src="<?php echo base_url() ?>assets/placeholders/slider/slide-9.jpg" width="1366" height="500" alt="">
                        <div class="mask"></div>
                    </a>
                    <div class="intro top-slide-intro">
                        <h2 class="title"><a href="#">Lorem ipsum dolor</a></h2>
                        <p>Aenean dui lectus, accumsan nec nulla sit amet, consectetur iaculis neque. Ut nec odio sem. Donec aliquam posuere imperdiet. Morbi luctus dolor id fringilla sagitis.</p>
                        <div class="view-more">  
                            <span class="bg-1"></span>              
                            <span class="bg-2"></span>
                            <span class="bg-3"></span>
                            <a href="#" class="link">read more</a>                  
                        </div>   
                    </div> 
                </div>

                <div class="item">
                    <a href="#">
                        <img class="lazyOwl" src="<?php echo base_url() ?>assets/placeholders/slider/slide-10.jpg" width="1366" height="500" alt="">
                        <div class="mask"></div>
                    </a>
                    <div class="intro top-slide-intro">
                        <h2 class="title"><a href="#">Lorem ipsum dolor</a></h2>
                        <p>Aenean dui lectus, accumsan nec nulla sit amet, consectetur iaculis neque. Ut nec odio sem. Donec aliquam posuere imperdiet. Morbi luctus dolor id fringilla sagitis.</p>
                        <div class="view-more">  
                            <span class="bg-1"></span>              
                            <span class="bg-2"></span>
                            <span class="bg-3"></span>
                            <a href="#" class="link">read more</a>                  
                        </div>   
                    </div>    
                </div>-->

            </div>
            <!-- #kopa-owl-top-slide -->

            <ul class="control-top-slide">
                <?php
                foreach($slider as $slide_1)
                {
                ?>
                <li>
                    <a href="#"><img src="<?php echo base_url() ?>media/backend/img/slider_img/<?=$slide_1['small_image']?>" height="114" width="114" alt=""></a>
                </li>
                <?php
                }
                ?>
<!--                <li>
                    <a href="#"><img src="<?php echo base_url() ?>assets/placeholders/slider/slide-small-6.jpg" height="114" width="114" alt=""></a>
                </li>
                <li class="active">
                    <a href="#"><img src="<?php echo base_url() ?>assets/placeholders/slider/slide-small-7.jpg" height="114" width="114" alt=""></a>
                </li>
                <li>
                    <a href="#"><img src="<?php echo base_url() ?>assets/placeholders/slider/slide-small-8.jpg" height="114" width="114" alt=""></a>
                </li>
                <li>
                    <a href="#"><img src="<?php echo base_url() ?>assets/placeholders/slider/slide-small-9.jpg" height="114" width="114" alt=""></a>
                </li>-->
            </ul>

            <!-- .control-top-slide -->

        </div>
        <!-- .slide-wrapper-inner -->