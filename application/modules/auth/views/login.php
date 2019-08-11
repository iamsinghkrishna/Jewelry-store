<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><i class="fa fa-lock"></i> Infi-Connect</h1>
            <div class="account-wall">

                <div id="infoMessage"><?php echo $message; ?></div>

                <div class="wrapper ">
                    <?php echo form_open("auth/login", array('id' => 'login_form')); ?>  

                    <div class="col-sm-12">
                        <div class="input-field">
                            <?php echo form_input($identity); ?>
                            <div class="lgnErorr1"></div>
                        </div>         
                    </div> 
                    <div class="clearfix"></div>
                    </br>
                    <div class="col-sm-12 margin-top-10">
                        <?php //echo lang('login_password_label', 'password'); ?>    
                        <div class="input-field">
                            <?php echo form_input($password); ?>
                            <div class="lgnErorr2"></div>

                        </div>         
                    </div>  

                    <div class="col-sm-12">
                        <label class="checkbox">
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?> <?php echo lang('login_remember_label', 'remember'); ?>
                        </label>
                    </div>
                    <!--<button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>-->
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   

                </div>
                <div class=""><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></div>
            </div>
        </div>
    </div>
</div>





<?php echo form_close(); ?>
<script>
    $(document).ready(function () {
        $(".alert").fadeOut(3000);
    });

</script>
