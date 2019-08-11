<?php if (isset($make_detail))  ?>
<?php foreach ($make_detail as $mkData) { ?>
    <div class="modal fade id_md_edit_make_<?php echo $mkData['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Make</h4>
                </div>
                <form id="id_form_make_edit" method="post" action="<?php echo base_url(); ?>master/make/edit/<?php echo $mkData['id'] ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name">Make Name <span class="required">*</span></label> 
                                <?php
                                echo form_input(array(
                                    'type' => 'text',
                                    'id' => 'make_name',
                                    'name' => 'make_name',
                                    'placeholder' => 'Make Name',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'value' => set_value('name', $mkData['name'])
                                ));
                                ?>

                            <label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name">Description<span class="required">*</span></label>
                            <div class="control-group">
                                <textarea id="message" required="required" class="form-control" name="make_description" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                          data-parsley-validation-threshold="10"><?php echo $mkData['description'] ?></textarea>
                            </div>
                            <div class="control-group">
                                <label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name">Status <span class="required">*</span></label> 
                                <?php
                                echo form_dropdown(array('id' => 'isactive', 'name' => 'isactive'), $isactive, set_value('isactive', $mkData['isactive']), array('class' => 'form-control'));
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php } ?>
