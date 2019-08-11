<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            
            <?php echo form_open("auth/login"); ?>
            <h1>Vaskia Login</h1>
            <div id="infoMessage" class=" text-warning"><?php echo $message; ?></div>
            <div>
                <?php echo form_input($identity); ?>
                <!--<input type="text" class="form-control" placeholder="Username" required="" />-->
            </div>
            <div>
                <?php echo form_input($password); ?>
                <!--<input type="password" class="form-control" placeholder="Password" required="" />-->
            </div>
            <div>
                <?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-default submit')); ?>

                <a class="reset_pass" href="#">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
                <p class="change_link">New to site?
                    <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                    <h1><i class="fa fa-paw"></i> <?php echo $this->config->item('website_name'); ?></h1>
                    <p>©2017 All Rights Reserved. <?php echo $this->config->item('website_name'); ?>! is a Online Fine Italian Jewelry store. Privacy and Terms</p>
                </div>
            </div>
            <?php echo form_close(); ?>
        </section>
    </div>

    <div id="register" class="animate form registration_form">
        <section class="login_content">
            <form>
                <h1>Create Account</h1>
                <div>
                    <input type="text" class="form-control" placeholder="Username" required="" />
                </div>
                <div>
                    <input type="email" class="form-control" placeholder="Email" required="" />
                </div>
                <div>
                    <input type="password" class="form-control" placeholder="Password" required="" />
                </div>
                <div>
                    <a class="btn btn-default submit" href="#">Submit</a>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">Already a member ?
                        <a href="#signin" class="to_register"> Log in </a>
                    </p>

                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <h1><i class="fa fa-paw"></i> <?php echo $this->config->item('website_name'); ?></h1>
                        <p>©2017 All Rights Reserved. <?php echo $this->config->item('website_name'); ?>! is a Online fine italian jewelry store. Privacy and Terms</p>
                    </div>
                </div>
            </form>
        </section>
    </div> 
</div>