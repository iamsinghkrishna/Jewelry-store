<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="no-js ie9 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"  dir="ltr" lang="en-US"> <!--<![endif]-->


    <head>
        <meta charset="utf-8">
        <!-- Set the viewport width to device width for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="author" content="qawba">
        <meta name="Description" content="Jewelry - Coming Soon Template HTML5" />
        <title>Vaskia | Fine Italian Jewelry</title>
        <link href="<?php echo base_url()?>landing_page/img/favicon.png" type="image/png" rel="icon">

        <!-- ============ Google fonts ============ -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>

        <!-- ============ Add custom CSS here ============ -->
        <link href="<?php echo base_url()?>landing_page/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>landing_page/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>landing_page/css/style.css" rel="stylesheet" type="text/css">

        <!-- ============ switch CSS here ============ -->
        <link href="<?php echo base_url()?>landing_page/css/switch.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>landing_page/css/color/color-yellow.css" rel="stylesheet" type="text/css" class="switchable1">
        <link href="<?php echo base_url()?>landing_page/css/color-countdown/color-dark.css"	rel="stylesheet" type="text/css" class="switchable2">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

        <script src="<?php echo base_url()?>landing_page/dist/sweetalert2.all.min.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110523647-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-110523647-1');
</script>
    </head>
    <body>

        <!-- *** Preload the Whole Page *** -->
        <div id="preloader">
            <div id="loading-animation">&nbsp;</div>
        </div>

        <!-- *** START HEADER *** -->
        <header id="header">

            <!-- *** START SOCIAL *** -->
            <div id="social">
                <div class="container_fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <ul class="list">



                                <!-- INSTAGRAM -->
                                <li class="col-md-3">
                                    <a target="_blank" href="https://www.instagram.com/vaskiajewelry/"><i class="fa fa-instagram"></i></a>
                                </li>

                                <!-- FACEBOOK -->
                                <li class="col-md-3">
                                    <a target="_blank" href="https://www.facebook.com/vaskiajewelry/"><i class="fa fa-facebook"></i></a>
                                </li>

                                <!-- TWITTER -->
                                <li class="col-md-3">
                                    <a target="_blank" href="https://twitter.com/vaskiajewelry/"><i class="fa fa-twitter"></i></a>
                                </li>

                                <!-- DRIBBBLE -->
                                <!-- <li class="col-md-2">
                                    <a href="#"><i class="fa fa-dribbble"></i></a>
                                </li> -->

                                <!-- GOOGLE PLUS -->
                                <li class="col-md-3">
                                    <a target="_blank" href="https://plus.google.com/106924966387688287776"><i class="fa fa-google-plus"></i></a>
                                </li>



                                <!-- PINTEREST -->
                                <!-- <li class="col-md-2">
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </li> -->

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <!-- *** END SOCIAL *** -->

            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <!-- LOGO -->
                        <div class="logo">
                            <a href="index.html">
                                <!-- <img src="img/logo.png" alt="Logo"> -->
                                <!-- <h3>Jewelry</h3> -->
                                <!-- <img src="img/logo.png"> -->
                                <img src="<?php echo base_url()?>landing_page/img/Logo_Vaskia.png">
                            </a>
                        </div>

                        <!-- Follow us -->
                        <a href="#" class="btn-social">Follow us</a>

                    </div>
                </div>
            </div>

            <!-- START INTRO -->
            <div id="intro">
                <h1>
                    We are working to bring you the finest
                    <span class="highlight-new">Italian Jewelry</span> online
                    <br>
                    <span class="highlight">Stay tuned!</span></h1>

                <span class="text">
                    Meanwhile, subscribe to our newsletter and get 15% discount coupon in your inbox.
                    <i class="fa fa-long-arrow-left"></i></span>

                <div class="form-group newsletter">
                    <div class="input-group">
                        <input class="form-control" placeholder="Your e-mail address" id="email" type="email" name="email">
                        <span class="input-group-btn">
                            <button type="button" onclick="submitForm()" class="btn btn-qawba">GET 15% OFF</button>
                        </span>
                    </div>
                </div>

                            </div>
            <!-- END INTRO -->

            <!-- START COUNTDOWN -->
            <div id="countdown">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">

                            <!-- START COUNTDOWN -->
                            <div id="countdown_dashboard" class='countdown' data-date="2017-12-7">

                            </div>

                            <!-- <div id="countdown_dashboard" class="countdown">
                                <div class="countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob days">
                                    <div class="dash days_dash">

                                        <span class="countdown-heading days-top dash_title">Days</span>
                                        <span class="countdown-value days-bottom digit">02</span>

                                    </div>
                                </div>

                                <div class="countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob hours">
                                    <div class="dash days_dash">

                                    <span class="countdown-heading hours-top dash_title">Hours</span>
                                    <span class="countdown-value hours-bottom digit">05</span>

                                    </div>
                                </div>

                                <div class="countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob minutes">
                                    <div class="dash days_dash">

                                    <span class="countdown-heading minutes-top dash_title">Minutes</span>
                                    <span class="countdown-value minutes-bottom digit">56</span>
                                    </div>
                                </div>

                                <div class="countdown-container col-md-3 col-sm-3 col-xs-3 dash-glob seconds">
                                    <div class="dash days_dash">

                                    <span class="countdown-heading seconds-top dash_title">Seconds</span>
                                    <span class="countdown-value seconds-bottom digit">59</span>

                                    </div>
                                </div>
                            </div> -->
                            <!-- END COUNTDOWN -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- END COUNTDOWN SECTION -->

            <!-- START COPYRIGHT SECTION -->
            <div id="copyright-header">
                <div class="container_fluid">

                    <p>Copyright © 2017.</p>

                    <!-- NAV COPYRIGHT -->
                    <nav>
                        <ul>
                            <li>
                                <a href="privacy-policy.html"><i class="fa fa-info"></i></a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
            <!-- END COPYRIGHT SECTION -->

        </header>
        <!-- *** END HEADER *** -->



        <script src="<?php echo base_url()?>landing_page/js/jquery.min.js"></script>
        <script src="<?php echo base_url()?>landing_page/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>landing_page/js/modernizr-2.6.2.min.js"></script>

        <!-- *** Countdown *** -->
        <script type="text/javascript" src="<?php echo base_url()?>landing_page/js/jquery.lwtCountdown-1.0.js"></script>

        <!-- *** File used to start some plugins *** -->
        <!-- <script type="text/javascript" src="js/time.js"></script> -->

        <!-- *** Dynamically-resized, slideshow-capable background image to any page or element *** -->
        <script type="text/javascript" src="<?php echo base_url()?>landing_page/js/jquery.backstretch.js"></script>

        <script src="<?php echo base_url()?>landing_page/assets/example.js"></script>

        <script>
                                'use strict';

                                /* =================================== */
                                /* ::::::: Load the Whole Page ::::::: */
                                /* =================================== */
                                // will first fade out the loading animation
                                jQuery("#loading-animation").fadeOut();
                                // will fade out the whole DIV that covers the website.
                                jQuery("#preloader").delay(600).fadeOut("slow");


                                $(window).load(function () {

                                    /* ====================== */
                                    /* ::::::: Social ::::::: */
                                    /* ====================== */
                                    $("#social:even").addClass("alt");
                                    $('.btn-social').click(function () {
                                        $('#social').slideToggle('medium');
                                    });

                                });

                                /* ========================== */
                                /* ::::::: Backstrech ::::::: */
                                /* ========================== */
                                // You may also attach Backstretch to a block-level element
                                $.backstretch(
                                        [
                                            "<?php echo base_url()?>landing_page/img/bg/10.jpg",
                                            "<?php echo base_url()?>landing_page/img/bg/8.jpg",
                                            "<?php echo base_url()?>landing_page/img/bg/11.jpg"
                                        ],
                                        {
                                            duration: 4500,
                                            fade: 1500
                                        }
                                );
        </script>
        <script>
            function submitForm() {
                var email = $("#email").val();
                $.ajax({
                    url: "<?php echo base_url()?>subscribe/subscribe",
                    type: "POST",
                    data: {'email': email},
                    dataType:'JSON',
                }).done(function (data) {
                    if(data.status === 1){
                       swal('Thank you!', data.msg, 'success').catch(swal.noop)
                    }else{
                        swal('Try again...', data.msg, 'error').catch(swal.noop)
                    }

                });
                return false;
            }


        </script>

    </body>
</html>