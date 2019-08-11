<?php // echo '<pre>', print_r($attribute_details);die;                                                                ?>
<?php if (isset($attribute_details))  ?>
<?php foreach ($attribute_details as $attr_data) { ?>
    <div class="modal fade id_pa_edit_<?php echo $attr_data['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Attributes</h4>
                </div>
                <?php echo form_open('admin/attirbutes/edit/' . $attr_data['id'], array('id' => 'id_form_attribute', 'class' => 'form-horizontal form-label-left', 'data-parsley-validate')); ?>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Value<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'name' => 'attribute_value',
                                'id' => 'attribute_value',
                                'placeholder' => 'Value',
                                'required' => 'required',
                                'value' => html_entity_decode(set_value('attrubute_value', $attr_data['attrubute_value'])),
                                'class' => 'form-control'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Category Attribute <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'parent_id',
                                'name' => 'parent_id',
                                'class' => 'form-control',
                                    ), $attt_category, set_value('parent_id', $attr_data['parent_id'])
                            );
                            ?>
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub-attribute">Sub Attributes <span class="required" ></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub-attribute"> <span class="required" ></span></label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <b>Attribute Type:</b>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <p>
                                <?php
                                $inCh = '';
                                $dpCh = '';
                                $attr_data['attribute_type'] == '0' ? $inCh = 'checked' : $dpCh = 'checked';
                                ?>
                                <input  type="radio"  value="0" id="optionsRadios1" name="attribute_type" required="" <?php echo $inCh ?>>&nbsp;&nbsp;&nbsp;&nbsp;Input
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input  type="radio"  value="1" id="optionsRadios1" name="attribute_type" required="" <?php echo $dpCh ?>>&nbsp;&nbsp;&nbsp;&nbsp;Dropdown
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if (isset($attr_data['sub_attribute_details']))  ?>
    <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>

                            <label for="sub_attribute_name" class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <?php
                                echo form_input(array(
                                    'type' => 'text',
                                    'name' => 'sub_attribute_name[]',
                                    'placeholder' => 'Name',
                                    'value' => html_entity_decode(set_value('sub_name', $attr_sub_data['sub_name'])),
                                    'class' => 'form-control col-md-3 col-xs-12'
                                ));
                                ?>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="control-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                        echo form_input(array(
                                            'type' => 'text',
                                            'id' => 'id_tags_' . $attr_sub_data['id'],
                                            'name' => 'tags[]',
                                            'placeholder' => 'Name',
                                            'value' => set_value('sub_value', $attr_sub_data['sub_value']),
                                            'class' => 'tags form-control'
                                        ));
                                        ?>
                                        <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

    <?php } ?>
                        <div class="clearfix"></div>

                        <input hidden="" id="edit_tag_count_<?php echo $attr_data['id'] ?>" value="1">
                        <div id="div_add_more_edit_<?php echo $attr_data['id'] ?>"></div>

                        <div class="col-sm-12 col-md-pull-3">
                            <button id="id_add_tags_edit_<?php echo $attr_data['id'] ?>" type="button" class="pull-right btn btn-round btn-default btn-sm"> <i class="fa fa-plus-circle"></i> Add More </button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>-->

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
    <?php echo form_close(); ?>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#attr_datatable").dataTable();

            $("#id_add_tags_edit_<?php echo $attr_data['id'] ?>").click(function () {
                var count = parseInt($("#edit_tag_count_<?php echo $attr_data['id'] ?>").val());
                var count = count + 1;
                $("#edit_tag_count_<?php echo $attr_data['id'] ?>").val(count);
                $('#div_add_more_edit_<?php echo $attr_data['id'] ?>').append('<label for="sub_attribute_name" class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-3 col-sm-3 col-xs-12"> <input id="sub_attribute_name" class="form-control col-md-3 col-xs-12" type="text" name="sub_attribute_name[]" placeholder="Name">    </div>                            <div class="col-md-3 col-sm-3 col-xs-12">                                <div class="control-group">                                    <div class="col-md-12 col-sm-12 col-xs-12">                                        <input id="edit_tag_count_<?php echo $attr_data['id'] ?>' + count + '" name="tags[]" type="text" class="tags form-control" value="" />                                        <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>                                    </div>                                </div>                            </div><div class="clearfix"></div>');
                $('#edit_tag_count_<?php echo $attr_data['id'] ?>' + count).tagsInput({
                    width: 'auto'
                });
            });

        });

    </script>

<?php }
?>


<script>
    $(document).ready(function () {
<?php if (isset($attr_data['sub_attribute_details']))  ?>
<?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>
            $('#id_tags_<?php echo $attr_sub_data['id'] ?>').tagsInput({
                width: 'auto'
            });
<?php } ?>
    });
</script>