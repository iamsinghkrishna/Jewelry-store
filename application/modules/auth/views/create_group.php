<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('create_group_heading'); ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id="infoMessage"><?php echo $message; ?></div>
                <?php 
                    echo form_open("auth/create_group",array('id' => 'group','name' => 'group'));
                ?>

                <p>
                    <?php echo lang('create_group_name_label', 'group_name'); ?> <br />
                    <?php echo form_input($group_name); ?>
                </p>

                <p>
                    <?php echo lang('create_group_desc_label', 'description'); ?> <br />
                    <?php echo form_input($description); ?>
                </p>

                <p>
                   <p>
                    <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                  <?php echo form_submit('btn_submit', lang('create_group_submit_btn'), array('class' => 'btn btn-default','name' => 'btn_submit','id' => 'btn_submit')); ?>
                     <a href="<?php echo base_url() ?>auth" class="btn btn-default">Cancel</a>
                </p>
                   
                </p>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>