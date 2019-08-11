<!DOCTYPE html>
<html lang="en">
    <!-- START HEAD -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $this->config->item('website_name'); ?> </title>
        <link rel="icon" type="image/jpg" href="<?php echo base_url(); ?>assets/images/vaskia_Faviocn.png" />
        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url() ?>backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url() ?>backend/vendors/nprogress/nprogress.css" rel="stylesheet">

        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo base_url() ?>backend/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- Select2 -->
        <!--<link href="<?php echo base_url() ?>backend/vendors/select2/dist/css/select2.min.css" rel="stylesheet">-->

        <!-- PNotify -->
        <!--<link href="<?php echo base_url() ?>backend/vendors/pnotify/dist/pnotify.css" rel="stylesheet">-->
        <!--<link href="<?php echo base_url() ?>backend/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">-->
        <!--<link href="<?php echo base_url() ?>backend/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">-->
        

        <!-- Datatables -->
        <link href="<?php echo base_url() ?>backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo base_url() ?>backend/build/css/custom.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="<?php echo base_url() ?>backend/vendors/jquery/dist/jquery.min.js"></script>

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url('assets/images/White_logo.png')?>"> </span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!--                         menu profile quick info 
                                                <div class="profile clearfix">
                                                    <div class="profile_pic">
                                                        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                                                    </div>
                                                    <div class="profile_info">
                                                        <span>Welcome,</span>
                                                        <h2>John Doe</h2>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                 /menu profile quick info -->

                        <!--<br />-->

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            {sidebar}
                        </div>
                        <!-- /sidebar menu -->



                        <!--                         /menu footer buttons 
                            <div class="sidebar-footer hidden-small">
                                <a data-toggle="tooltip" data-placement="top" title="Settings">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="Lock">
                                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                </a>
                            </div>
                             /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    {header}
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    {content}
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    {footer}
                </footer>
                <!-- /footer content -->
            </div>
        </div>


        <!-- Bootstrap -->
        <script src="<?php echo base_url() ?>backend/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>backend/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?php echo base_url() ?>backend/vendors/nprogress/nprogress.js"></script>

        <!-- bootstrap-daterangepicker -->
        <script src="<?php echo base_url() ?>backend/vendors/moment/min/moment.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- PNotify -->
        <!--<script src="<?php echo base_url() ?>backend/vendors/pnotify/dist/pnotify.js"></script>-->
        <!--<script src="<?php echo base_url() ?>backend/vendors/pnotify/dist/pnotify.buttons.js"></script>-->
        <!--<script src="<?php echo base_url() ?>backend/vendors/pnotify/dist/pnotify.nonblock.js"></script>-->

        <!-- jQuery Tags Input -->
        <script src="<?php echo base_url() ?>backend/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>



        <!-- Datatables -->
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/jszip/dist/jszip.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?php echo base_url() ?>backend/vendors/pdfmake/build/vfs_fonts.js"></script>
        
        <!-- Custom Theme Scripts -->
        <script src="<?php echo base_url() ?>backend/build/js/custom.min.js"></script>
        <script src="<?php echo base_url() ?>backend/build/js/validation.js"></script>
        <!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>-->
        <script src="<?php echo base_url() ?>backend/build/js/validator.min.js"></script>
    </body>

    <!-- END BODY -->
</html>
