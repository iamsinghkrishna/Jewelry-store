<?php
$flag = '0';
$options = '';
?>


<?php if (isset($this->data['prodcut_cat_detail'])) { ?>

    <?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>
        <?php if ($attr_data['parent_id'] > 0) { ?>
            <?php $options .= '<option id="' . $attr_data['p_sub_category_id'] . '">' . $attr_data['attrubute_value'] . '</option>' ?>
        <?php } ?>

    <?php } ?>
    <?php  if ($options != '') { ?>

        <select class="form-control" id="id_select_sub_part" onchange="getSubCategory(this.value,'100000');">
            <option>Select Sub Category </option>
            <?php echo $options; ?>
        </select>
        <br>
    <?php } ?>
<?php } ?>
        
<?php if (isset($this->data['prodcut_cat_detail']))  ?>
<?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>

    <div>
        <?php if ($attr_data['parent_id'] == 0) { ?>
            <div id="div_lbl">
                <label><?php echo $attr_data['attrubute_value'] ?></label>
            </div>
        <?php } ?>

    </div>
    <?php if ($attr_data['parent_id'] > 0) { ?>
        <div style="display: none" class="form-group test" id="show_id_<?php echo $attr_data['p_sub_category_id'] ?>">

            <?php if (isset($attr_data['sub_attribute_details']))  ?>
            <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>

                <?php // echo $attr_sub_data['sub_name'] ?>
                <?php if ($attr_data['attribute_type'] == 0) { ?>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?php echo $attr_sub_data['sub_name']; ?>
                    </div>
                <?php } else { ?>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if ($flag == '0') {
                            echo 'Select ' . $attr_data['attrubute_value'];
                            ;
                        }
                        ?>
                    </div> 
                <?php } ?>
            
                <div class="col-md-6 col-sm-3 col-xs-12">
                    <div class="control-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php if ($attr_data['attribute_type'] == 0) { ?>
                                <?php
                                echo form_input(array(
                                    'type' => 'text',
                                    'id' => 'id_tags_' . $attr_sub_data['id'],
                                    'name' => 'attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'],
                                    'placeholder' => $attr_sub_data['sub_name'],
                                    //'required' => 'required',
                                    'class' => 'tags form-control'
                                ));
                                ?>
                                <?php
                            } else if ($flag == '0') {
                                $options = array();
                                foreach ($attr_data['sub_attribute_details'] as $key => $val)
                                    $options[$val['id']] = $val['sub_name'];
                                ?>
                                <?php
                                // 'required' => 'required'
                                echo form_dropdown(array('id' => '', 'name' => 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'], 'class' => 'form-control'), $options);
                                ?>
                                <?php
                                $flag = '1';
                            }
                            ?>
                            <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

            <?php } $flag = 0; ?>
            <div class="clearfix"></div>

        </div>
    <?php } else{ ?>

        <div class="form-group" id="show_id_<?php echo $attr_data['p_sub_category_id'] ?>">
            <?php if ($attr_data['attribute_type'] == '2') { ?>
                <?php
                echo form_input(array(
                'type' => 'file',
                'id' => 'id_tags_' . $attr_sub_data['id'],
                'name' => 'attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'],
                'placeholder' => $attr_sub_data['sub_name'],
                'required' => 'required',
                'accept' => "image/png",
                'class' => 'tags form-control'
                ));
                ?>
                <span class="text-danger">Only .png format allowed with size 89*89 pixel for better experience</span>
            <?php } ?>
            <?php if (isset($attr_data['sub_attribute_details']))  ?>
            <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>

                <?php // echo $attr_sub_data['sub_name'] ?>

                <?php if ($attr_data['attribute_type'] == 0) { ?>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?php echo $attr_sub_data['sub_name']; ?>
                    </div>
                <?php } else { ?>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if ($flag == '0') {
                            echo 'Select ' . $attr_data['attrubute_value'];
                            ;
                        }
                        ?>
                    </div> 
                <?php } ?>
                <?php if ($attr_data['attribute_type'] == 0 || $flag == '0') { ?>
                <div class="col-md-6 col-sm-3 col-xs-12">
                    <div class="control-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <?php if ($attr_data['attribute_type'] == 0) { ?>
                                <?php
                                echo form_input(array(
                                    'type' => 'text',
                                    'id' => 'id_tags_' . $attr_sub_data['id'],
                                    'name' => 'attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'],
                                    'placeholder' => $attr_sub_data['sub_name'],
                                    'required' => 'required',
                                    'class' => 'tags form-control'
                                ));
                                ?>
                                <?php
                            } else if ($flag == '0') {
                                $options = array();
                                foreach ($attr_data['sub_attribute_details'] as $key => $val)
                                    $options[$val['id']] = $val['sub_name'];
                                ?>
                                <?php
                                echo form_dropdown(array('id' => '', 'name' => 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'], 'class' => 'form-control', 'required' => 'required'), $options);
                                ?>
                                <?php
                                $flag = '1';
                            }
                            ?>
                            
                            <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <div class="clearfix"></div>

            <?php } $flag = 0; ?>
            <div class="clearfix"></div>

        </div>
    <?php } ?>

    </div>
<?php } ?>
<script>
    
   

    $(document).ready(function () {
        
     

        $("#id_select_sub_part").change(function () {

            var selected_id = $(this).find('option:selected').attr('id');
//            alert('#show_id_' + selected_id);
            $('.test').hide();
            $('#div_lbl').remove();
            $(["input:hidden, textarea:hidden, select:hidden"]).attr("disabled", true);
            $('#show_id_' + selected_id).show();
            var id = '#show_id_' + selected_id;

            $(".test input").attr("disabled", "true");
            $(".test input").removeAttr("required");
//            $(id+" input").removeAttr("required");
            $(id + " input").attr("required", "true");
            $(id + " input").removeAttr("disabled");

        });
    });
</script>