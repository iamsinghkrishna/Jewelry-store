<?php // echo '<pre>', print_r($model_detail);die;     ?>
<?php if (isset($model_detail))  ?>
<?php foreach ($model_detail as $mdlData) { ?>
    <div class="modal fade id_md_edit_make_<?php echo $mdlData['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Model</h4>
                </div>
                <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/model/edit/<?php echo $mdlData['id']; ?>"   class="">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="make_name">Make <span class="required">*</span></label>
                                    <?php
                                    echo form_dropdown(array(
                                        'id' => 'id_make',
                                        'name' => 'make',
                                        'class' => 'form-control',
                                        'required' => 'required'
                                            ), $make_dropdown, set_value('make_id', $mdlData['make_id'])
                                    );
                                    ?>


                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="yaer">year <span class="required">*</span></label>
                                    <?php
                                    echo form_dropdown(array(
                                        'id' => 'id_year',
                                        'name' => 'year',
                                        'class' => 'form-control',
                                        'required' => 'required'
                                            ), $year_dropdown, set_value('year_id', $mdlData['year_id'])
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="model">Model <span class="required">*</span></label>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'id' => 'tags_1',
                                        'name' => 'model',
                                        'placeholder' => 'Model Name',
                                        'class' => 'form-control',
                                        'value' => set_value('name', $mdlData['name']),
                                        'data-error' => '.errorTxtOff3'
                                    ));
                                    ?>
                                    <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="status">Status <span class="required">*</span></label>
                                    <?php
                                    echo form_dropdown(array('id' => 'isactive', 'name' => 'isactive'), $isactive, set_value('isactive', $mdlData['isactive']), array('class' => 'form-control'));
                                    ?>
                                    <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                                </div>
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
    <?php
}?>