
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('deactivate_heading'); ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php echo form_open("auth/deactivate/" . $user->id); ?>

                <p>
                    <?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
                    <input type="radio" name="confirm" value="yes" checked="checked" />
                    <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
                    <input type="radio" name="confirm" value="no" />
                </p>

                <?php echo form_hidden($csrf); ?>
                <?php echo form_hidden(array('id' => $user->id)); ?>


                <p><?php echo form_submit('submit', lang('deactivate_submit_btn'), array('class' => 'btn btn-default')); ?>
                    <a href="<?php echo base_url() ?>auth" class="btn btn-default">Cancel</a>

                    <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>