<div class="modal fade id_md_add_make" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Make</h4>
            </div>
            <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/make/add"   class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name"><?php echo lang('make_name'); ?> <span class="required">*</span>
                            <input placeholder="Make Name" type="text" id="make_name" name="make_name[]" required="required" class="form-control col-md-7 col-xs-12">
                        </label>

                        <label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name"><?php echo lang('description'); ?><span class="required">*</span>
                            <div class="control-group">
                                <textarea id="message" required="required" class="form-control" name="make_description[]" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                          data-parsley-validation-threshold="10"></textarea>
                            </div>
                        </label>
                    </div>
                    <div class="form-group">

                        <input hidden="" id="make_count" value="1" name="make_count">
                        <div id="dv_add_more_make"></div>                        
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button id="id_add_more_mk" type="button" class="pull-right btn btn-round btn-default btn-xs"> <i class="fa fa-plus-circle"></i> Add More </button>
                    </div>

                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>