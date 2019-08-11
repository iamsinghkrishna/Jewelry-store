<!DOCTYPE html>
<html lang="en">
    <!-- START HEAD -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
       <link rel="icon" type="image/jpg" href="<?php echo base_url();?>assets/images/vaskia_Faviocn.png" />
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $this->config->item('website_name'); ?> </title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url() ?>backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url() ?>backend/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="<?php echo base_url() ?>backend/vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo base_url() ?>backend/build/css/custom.min.css" rel="stylesheet">
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->

    <body class="login">
        <div>
            {content}
        </div>
    </body>

    <!-- END BODY -->
</html>
