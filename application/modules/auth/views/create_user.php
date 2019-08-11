<style>
    .col-sm-6.margin-top-10 {
    margin-top: 20px;
}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('create_user_heading'); ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="infoMessage"><?php echo $message; ?></div>

                <?php echo form_open_multipart("auth/create_user", array('id' => 'reg_form','name' => 'reg_form')); ?>

                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_fname_label', 'first_name'); ?> <br />
                        <?php echo form_input($first_name); ?>

                    </div>
                    <div class="regErorr1"></div>
                </div>
                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
                        <?php echo form_input($last_name); ?>

                    </div>
                    <div class="regErorr2"></div>
                </div>

                <div class="clearfix"></div>


                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_company_label', 'company'); ?> <br />
                        <?php echo form_input($company); ?>

                    </div>
                    <div class="regErorr3"></div>
                </div>
                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_email_label', 'email'); ?> <br />
                        <?php echo form_input($email); ?>

                    </div>
                    <div class="regErorr4"></div>
                </div>

                <div class="clearfix"></div>


                <?php if ($identity_column !== 'email') { ?>

                    <div class="col-sm-6 margin-top-10">
                        <div class="input-field">
                            <?php echo lang('create_user_identity_label', 'identity'); ?> <br />
                            <?php echo form_input($identity); ?>

                        </div>
                        <div class="regErorr5"></div>
                    </div>


                <?php } ?>



                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_phone_label', 'phone'); ?> <br />
                        <?php echo form_input($phone); ?>

                    </div>
                    <div class="regErorr6"></div>
                </div>
                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_password_label', 'password'); ?> <br />
                        <?php echo form_input($password); ?>

                    </div>
                    <div class="regErorr7"></div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <br />
                        <?php echo form_input($password_confirm); ?>

                    </div>
                    <div class="regErorr8"></div>
                </div>

<!--                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('joining_date', 'birth_date'); ?> <br />
                        <?php echo form_input($birth_date); ?>

                    </div>
                    <div class="regErorr9"></div>
                </div>-->
                <div class="clearfix"></div>
                <div class="col-sm-6 margin-top-10">
                    <div class="input-field">
                        <?php echo lang('profile_image', 'profile_image'); ?> <br />
                        <?php echo form_input($profile_image); ?>

                    </div>
                    <div class="regErorr9"></div>
                </div>
  <br/>  <br/>
                <div class="clearfix"></div>
              
                <div class="col-sm-6 margin-top-10" style="margin-top:20px !important;">
                    <div class="input-field">
                        <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                        <?php echo form_submit('btn_submit', lang('create_user_submit_btn'), array('class' => 'btn btn-default','name' => 'btn_submit','id' => 'btn_submit')); ?>
                    </div>
                </div>


                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
