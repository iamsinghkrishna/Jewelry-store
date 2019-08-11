<!DOCTYPE HTML>
<html>
    <head>
        <title>404 error page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type="image/jpg" href="<?php echo load_class('Config')->config['base_url']; ?>assets/images/vaskia_Faviocn.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <link href="<?php echo load_class('Config')->config['base_url']; ?>assets/404/css/style.css" rel="stylesheet" type="text/css" media="all" />
    </head>
    <body style="background: #fff;">
        <!-----start-wrap--------->
        <div class="wrap">
            <!-----start-content--------->
            <div class="content">
                <!-----start-logo--------->
                <div class="logo">
                    <h1><a href="#"><img src="<?php echo load_class('Config')->config['base_url']; ?>assets/404/images/logo.png"/></a></h1>
                    <span><img src="<?php echo load_class('Config')->config['base_url']; ?>assets/404/images/signal.png"/>The Page you requested was not found!</span>
                </div>
                <!-----end-logo--------->
                <!-----start-search-bar-section--------->
                <div class="buttom">
                    <div class="seach_bar">
                        <p>you can go to <span><a href="<?php echo load_class('Config')->config['base_url']; ?>">home page</a></span> </p>
                        <!-----start-sear-box--------->
                        <!--<div class="search_box">
                        <form>
                           <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}"><input type="submit" value="">
                    </form>
                         </div>
                        -->
                    </div>
                </div>
                <!-----end-sear-bar--------->
            </div>
            <!----copy-right-------------->
    <!--<p class="copy_right">&#169; 2017 Developed by<a href="http://vaskia.rebelutedigital.com/dev/" target="_blank">&nbsp; Vaskia - Fine Italian Jewelry123
            -->
        </a> </p>
</div>
        <img style="position: fixed;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: -1;" class="404-class" src="<?php echo load_class('Config')->config['base_url']; ?>assets/404/images/bg.jpg"/>
<!---------end-wrap---------->
</body>
</html>