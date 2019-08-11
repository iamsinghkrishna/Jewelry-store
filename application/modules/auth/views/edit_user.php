<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('edit_user_heading'); ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if($message){ ?><div class="alert alert-danger"><?php echo $message;?></div><?php }?>

                <?php echo form_open_multipart(uri_string(), array('id' => 'reg_form','name' => 'reg_form')); ?>

                <p>
                    <?php echo lang('edit_user_fname_label', 'first_name'); ?> <br />
                    <?php echo form_input($first_name); ?>
                </p>

                <p>
                    <?php echo lang('edit_user_lname_label', 'last_name'); ?> <br />
                    <?php echo form_input($last_name); ?>
                </p>

                
                    <?php // echo lang('edit_user_company_label', 'company'); ?> 
                    <?php // echo form_input($company); ?>
                

                <p>
                    <?php echo lang('edit_user_phone_label', 'phone'); ?> <br />
                    <?php echo form_input($phone); ?>
                </p>

                <p>
                    <?php echo lang('edit_user_password_label', 'password'); ?> <br />
                    <?php echo form_input($password); ?>
                </p>

                <p>
                    <?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?><br />
                    <?php echo form_input($password_confirm); ?>
                </p>
                <?php if($profile_image_old != ''){ ?>
                <p>
                    <img style="height:200px;" src="<?php echo $profile_image_old; ?>" />
                </p>
                <?php } ?>
                 <?php echo lang('profile_image', 'profile_image'); ?> <br />
                  <?php echo form_input($profile_image); ?>

                <input type="hidden" name="profile_image_old" id="profile_image_old" value="<?php echo $profile_image_old; ?>" />
                
                <?php if ($this->ion_auth->is_admin()): ?>
                
                    <h3><?php echo lang('edit_user_groups_heading'); ?></h3>
                    <?php foreach ($groups as $group): ?>
                        <label class="checkbox">
                            <?php
                            $gID = $group['id'];
                            $checked = null;
                            $item = null;
                            foreach ($currentGroups as $grp) {
                                if ($gID == $grp->id) {
                                    $checked = ' checked="checked"';
                                    break;
                                }
                            }
                            ?>
                            <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                            <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </label>
                    <?php endforeach ?>

                <?php endif ?>
                    

                <?php echo form_hidden('id', $user->id); ?>
                <?php echo form_hidden($csrf); ?>

                <p>
                   <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                    <?php echo form_submit('btn_submit', lang('edit_user_submit_btn'),array('class'=>'btn btn-default','name' => 'btn_submit','id' => 'btn_submit')); ?>
                    <a href="<?php echo base_url()?>auth" class="btn btn-default">Cancel</a>
                </p>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>




