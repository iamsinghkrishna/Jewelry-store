<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php // echo $page_title;    ?></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Change Password</h2>
                    <!--<button id="btn_toggl_vw" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Slider</button>-->
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />

                    <div id="id_add_attribute_form" >
                        <form action="<?php echo base_url(); ?>admin/changePassword" id="" name="" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                            
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Password
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" name="password" required id="password"  class="form-control col-md-7 col-xs-12" placeholder="New Password" >
                                         <?php echo form_error('password', '<div style="color:red" class="error">', '</div>'); ?>
                                    </div>
                                   

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Repeat New Password
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" name="conf_password" required id="title"  class="form-control col-md-7 col-xs-12" placeholder="Repeat New Password" >
                                         <?php echo form_error('conf_password', '<div style="color:red" class="error">', '</div>'); ?>

                                    </div>
                                   
                                </div>
                           

                            <div class="clearfix"></div>


                            <div id="file_error"></div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" name="userSubmit" class="btn btn-success">Submit</button>
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>admin/slider" > Cancel</a>
                                    <!--<button id="btn_cancel_vw" type="button" class="btn btn-success">Cancel</button>-->
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>

