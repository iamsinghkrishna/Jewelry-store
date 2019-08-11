<?php if (isset($years_detail))  ?>
<?php foreach ($years_detail as $k => $yrData) { ?>
    <div class="modal fade id_md_edit_year_<?php echo $yrData['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Year</h4>
                </div>
                <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/year/edit/<?php echo $yrData['id'] ?>"   class="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="make_name">Make Name <span class="required">*</span></label> 
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input hidden name="make_id" value="<?php echo $yrData['id'] ?>" >
                                <input placeholder="Make Name" type="text" id="make_name" name="make_name" value="<?php echo $yrData['name'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>
                        <div class="form-group">
                            <?php $data = '';
                            if (!empty($yrData['make_year_details']))
                                
                                ?>
                            <?php foreach ($yrData['make_year_details'] as $yrSubData) { ?>
                                <?php $data .= $yrSubData['name'] . ','; ?>
                                <?php } ?>
                                <?php echo form_label(lang('make_year'), 'make_year', array('for' => 'make_year', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                echo form_input(array(
                                    'type' => 'text',
                                    'id' => 'e_tags_' . $yrData['id'],
                                    'name' => 'year[]',
                                    'placeholder' => 'Years',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'value' => $data
                                ));
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#e_tags_<?php echo $yrData['id'] ?>').tagsInput({
                width: 'auto'
            });
        });
    </script>
<?php } ?>