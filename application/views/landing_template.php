<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title><?php echo (config_item('seo_title')) ? config_item('seo_title')
        : " Best Italian Jewelry You Will Find Online " ?> | Vaskia - Fine Italian Jewelry</title>
        <meta name="description" content="<?php echo (config_item('meta_desc'))
        ? config_item('meta_desc') : " Vaskia Jewelry is paradise for Italian Jewelry lovers. Earrings, necklace, pendants, rings, bracelets, children's jewelry and many more. Check our collection now!" ?>">
        <meta name="google-site-verification" content="dZbHEWs7TZ0Nd3d4Gmc_YDpkqlgjVJ102ZLFpo1tjlU" />
        <link rel="icon" type="image/jpg" href="<?php echo base_url(); ?>assets/images/vaskia_Faviocn.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/animate.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/owl.carousel.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/chosen.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/lightbox.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pe-icon-7-stroke.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.css') ?>">
        <!--<link rel="stylesheet" type="text/css" href="<?php // echo base_url('assets/css/magnific-popup.css')     ?>">-->
        <link href="<?php echo base_url('assets/css/rating.css'); ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/gallery.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/flaticon/flaticon.css') ?>">		        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/range-slider.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/SelectBox.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/checkbox-radio.css') ?>">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link href="https://fonts.googleapis.com/css?family=Mate+SC" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400italic,400,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,100,100italic,300italic,400,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.4.min.js') ?>"></script>
        <style type="text/css">

            body{margin:0px;padding:0px;font-family:Arial;}
            a img,:link img,:visited img { border: none; }
            table { border-collapse: collapse; border-spacing: 0; }
            :focus { outline: none; }
            *{margin:0;padding:0;}
            blockquote, dd, dt{margin:0 0 8px 0;line-height:1.5em;}
            fieldset {padding:0px;padding-left:7px;padding-right:7px;padding-bottom:7px;}
            fieldset legend{margin-left:15px;padding-left:3px;padding-right:3px;color:#333;}
            dl dd{margin:0px;}
            dl dt{}

            .clearfix:after{clear:both;content:".";display:block;font-size:0;height:0;line-height:0;visibility:hidden;}
            .clearfix{display:block;zoom:1}


            ul#thumblist{display:block;}
            ul#thumblist li{float:left;margin-right:2px;list-style:none;}
            ul#thumblist li a{display:block;border:1px solid #CCC;}
            ul#thumblist li a.zoomThumbActive{
                border:1px solid red;
            }

            .jqzoom{

                text-decoration:none;
                float:left;
            }
        </style>
        <script type="text/javascript">
            var base_url = '<?php echo base_url() ?>';
        </script>
        <script type="text/javascript">
            window.smartlook || (function (d) {
                var o = smartlook = function () {
                    o.api.push(arguments)
                }, h = d.getElementsByTagName('head')[0];
                var c = d.createElement('script');
                o.api = new Array();
                c.async = true;
                c.type = 'text/javascript';
                c.charset = 'utf-8';
                c.src = 'https://rec.smartlook.com/recorder.js';
                h.appendChild(c);
            })(document);
            smartlook('init', '0e90dccbf5bdaed4b20325d9e7901ecade670817');
        </script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110523647-1"></script>

        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-110523647-1');
        </script>
        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s)
            {
                if (f.fbq)
                    return;
                n = f.fbq = function () {
                    n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq)
                    f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '356740951463685');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=356740951463685&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->
    <script type="application/ld+json">
{ "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "vaskia",
  "url" : "https://vaskia.com/",
  "sameAs" : ["https://www.facebook.com/vaskiajewelry/","https://twitter.com/VaskiaJewelry","https://www.instagram.com/vaskiajewelry/",]
}
</script>



<script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "WebSite",
	  "name": "Vaskia",
	  "url": "https://vaskia.com/"
        }
</script>
</head>
<body class="home new_style-2">
    <div id="box-mobile-menu" class="box-mobile-menu full-height full-width">
        <span class="close-menu" id="newclosemenu" ><span class="icon pe-7s-close"></span></span>
        <div class="box-inner">

        </div>
    </div>
    <div id="header-ontop" class="is-sticky"></div>
    {header}
    <!-- Home slide -->
    {content}

    {footer}
    <a href="#" class="scroll_top" title="Scroll to Top" style="display: block;"><i class="fa fa-arrow-up"></i></a>

    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/owl.carousel.min.js') ?>"></script>
    <!--<script type="text/javascript" src="<?php // echo base_url('assets/js/chosen.jquery.min.js')  ?>"></script>-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/Modernizr.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/js/lightbox.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/masonry.pkgd.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/imagesloaded.pkgd.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/isotope.pkgd.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.parallax-1.1.3.js') ?>"></script>
    <script type="text/javascript" src="<?php // echo base_url('assets/js/jquery.zoomtoo.js')   ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/zoom.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.toaster.js"></script>


    <script type="text/javascript" src="<?php echo base_url('assets/js/masonry.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/functions.js') ?>"></script>
<!--        <script type="text/javascript">
        $(document).ready(function () {
            //If your <ul> has the id "glasscase"
            $('#glasscase').glassCase({'thumbsPosition': 'bottom', 'widthDisplay': 560});
        });
    </script>-->


<!--        <script type="text/javascript">
            $(document).ready(function () {
                $("#demo").zoomToo({
                    magnify: 1
                });
            });
        </script>-->

<!--        <script type="text/javascript">
            $(document).ready(function () {
                $("#demo").zoomToo({
// duration in ms
                    showDuration: 500,
                    moveDuration: 1200,
// initial zoom level
                    magnify: 1,
// width / height of the lens
                    lensWidth: 200,
                    lensHeight: 200
                });
            });

        </script> -->
    <script type="text/javascript" src="<?php // echo base_url('assets/js/functions.js')  ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/gallery.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/foundation.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/setup.js') ?>"></script>
    <script src="<?php echo base_url() ?>assets/js/rating.js"></script>
    <script src="<?php echo base_url() ?>assets/js/SelectBox.js"></script>
    <script src="<?php echo base_url() ?>assets/js/checkbox-radio.js"></script>



    <script type="text/javascript">
            $(document).ready(function () {
                //If your <ul> has the id "glasscase"
                $('#glasscase').glassCase({'thumbsPosition': 'bottom', 'widthDisplay': 560});
                $(".xzoom").xzoom({tint: '#333', Xoffset: 60});
                $('select').SelectBox();
                $("input[type=radio], input[type=checkbox]").picker();
            });
    </script>
    <!--Start of Tawk.to Script-->
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/59d784cb4854b82732ff404a/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();

        //$(window).scrollTop(0);
        // $(window).on('load', function () {
        //   //alert("Window Loaded");
        //   $(window).scrollTop(0);
        // });
        $(window).scrollTop(0);
    </script>

    <!--End of Tawk.to Script-->
    <!--End of Tawk.to Script-->


</body>
</html>