<div class="modal fade id_md_add_year" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Year</h4>
            </div>
            <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/year/add"   class="">
                <div class="modal-body">
                    <div class="form-group">

                        <?php echo form_label(lang('make_name'), 'make_name', array('for' => 'make_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'make_id',
                                'name' => 'make_id',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                    ), $product_make
                            );
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="form-group">
                        <?php echo form_label(lang('make_year'), 'make_year', array('for' => 'make_year', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'tags_1',
                                'name' => 'year',
                                'placeholder' => 'Years',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>



                </div>
                <div class="clearfix"></div>
                <br>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>