<?php
// echo '<pre>';
//print_r($this->data['prodcut_cat_detail']);die;
?>
<?php
// print_r($this->data['prodcut_cat_detail']);
//die;
?>
<?php
$flag = '0';
$options = array("" => "Select Sub Category");
$selectedId = '';
$flag = "0";
?>


<?php if (isset($this->data['prodcut_cat_detail'])) { ?>

    <?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>
        <?php // echo $attr_data['parent_id'];?>
        <?php if ($attr_data['parent_id'] > 0) { ?>
            <?php
            $options[$attr_data['p_sub_category_id']] = $attr_data['attrubute_value'];
            $flag = $attr_data['p_sub_category_id'];
            ?>

        <?php } ?>
        <?php // echo '<pre>', print_r($attr_data); ?>
        <?php if (isset($attr_data['sub_attribute_details'])) { ?>
            <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>
                <?php if (isset($attr_sub_data['sub_update_id']) && !empty($attr_sub_data['sub_update_id'])) { ?>
                    <?php if ($attr_data['parent_id'] > 0) { ?>
                        <?php $selectedId = $attr_sub_data['attribute_id'] ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>

    <?php } ?>
    <?php if ($options != '' && $flag != "0") { ?>

        <?php
        echo form_dropdown(array(
            'id' => 'p_sub_category_id',
            'name' => 'p_sub_category_id',
            'class' => 'form-control',
            'onchange' => "getSubCategoryById(this.value,'100000')",
            'required' => 'required',
            'readonly' => 'readonly',
                ), $options, set_value('p_sub_category_id', $selectedId)
        );
        ?>

        <br>
    <?php } ?>
<?php } ?>

<?php if (isset($this->data['prodcut_cat_detail']))  ?>
<?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>
    <div>
        <?php if ($attr_data['parent_id'] == 0) { ?>
            <div>
                <label><?php echo $attr_data['attrubute_value'] ?></label>
            </div>
        <?php } ?>
        <?php if ($attr_data['parent_id'] > 0) { ?>
            <div class="form-group">

                <?php if (isset($attr_data['sub_attribute_details']))  ?>
                <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>
                    <?php if (isset($attr_sub_data['sub_update_id'])) { ?>

                        <?php // echo $attr_sub_data['sub_name']     ?>
                        <?php if ($attr_data['attribute_type'] == 0) { ?>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <?php echo $attr_sub_data['sub_name']; ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <?php
                                if ($flag == '0') {
                                    echo 'Select ' . $attr_data['attrubute_value'];
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
                                                'value' => set_value('sub_value', $attr_sub_data['sub_value']),
                                                'class' => 'tags form-control'
                                            ));
                                            ?>
                                            <input hidden="" value="<?php echo isset($attr_sub_data['sub_update_id']) ? $attr_sub_data['sub_update_id'] : '' ?>" name="<?php echo 'attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '_input' ?>"/>
                                            <?php
                                        } else if ($flag == '0') {
                                            $sub_attribute_dp_id = '';
                                            $options = array();

                                            foreach ($attr_data['sub_attribute_details'] as $key => $val) {
                                                $options[$val['id']] = $val['sub_name'];
                                                if (isset($val['sub_attribute_dp_id']))
                                                    $sub_attribute_dp_id = $val['sub_attribute_dp_id'];
                                            }
                                            ?>
                                            <input hidden="" value="<?php echo isset($attr_sub_data['sub_update_id']) ? $attr_sub_data['sub_update_id'] : '' ?>" name="<?php echo 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '_input' ?>"/>
                                            <?php
                                            echo form_dropdown(array('id' => '', 'name' => 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'], 'class' => 'form-control', 'required' => 'required'), $options, set_value('id', $sub_attribute_dp_id));
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

                    <?php } ?>
                <?php } $flag = 0; ?>
                <div class="clearfix"></div>

            </div>
        <?php }else { ?>
            <div class="form-group">
                <?php if ($attr_data['attribute_type'] == 2) { ?>
                    <?php // echo '<pre>', print_r($attr_data); die;  ?>
                                                <!--<a class="btn btn-xs btn-default" id="remove_image" onclick="deleteProductImg(<?php echo $attr_data['plugin_id']; ?>)"><i class="fa fa-remove text-danger "></i></a>-->
                    <?php if (isset($attr_data['plugin_url']) && !empty($attr_data['plugin_url'])) { ?>    
                        <image class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() . $attr_data['plugin_url']; ?>"/>

                        <?php
                        echo form_input(array(
                            'type' => 'file',
                            'id' => 'id_tags_' . $attr_data['plugin_id'],
                            'name' => 'attr_file_' . $attr_data['attribute_id'] . '_' . $attr_data['plugin_id'],
                            'placeholder' => $attr_data['attrubute_value'],
//                        'required' => 'required',
                            'class' => 'tags form-control',
                            'accept' => "image/png",
                            'value' => set_value('plugin_url', $attr_data['plugin_url']),
                        ));
                        ?>
                        <input hidden value="<?php echo isset($attr_data['update_id']) ? $attr_data['update_id'] : ''; ?>" name="<?php echo 'attr_file_' . $attr_data['p_sub_category_id'] . '_' . $attr_data['p_category_id'] . '_file' ?>"/>
                    <?php } else { ?>
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
                <?php } ?>
                <?php if (isset($attr_data['sub_attribute_details']))  ?>
                <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>


                    <?php // echo $attr_sub_data['sub_name']      ?>
                    <?php if ($attr_data['attribute_type'] == 0) { ?>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <?php echo $attr_sub_data['sub_name']; ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <?php
                            if ($flag == '0') {
                                echo 'Select ' . $attr_data['attrubute_value'];
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
                                            'value' => set_value('sub_value', $attr_sub_data['sub_value']),
                                            'class' => 'tags form-control'
                                        ));
                                        ?>
                                        <input hidden="" value="<?php echo isset($attr_sub_data['sub_update_id']) ? $attr_sub_data['sub_update_id'] : '' ?>" name="<?php echo 'attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '_input' ?>"/>
                                        <?php
                                    } else if ($flag == '0') {
                                        $sub_attribute_dp_id = '';
                                        $options = array();
                                        foreach ($attr_data['sub_attribute_details'] as $key => $val) {
                                            $options[$val['id']] = $val['sub_name'];
                                            if (isset($val['sub_attribute_dp_id']) && $val['sub_attribute_dp_id'] != '0')
                                                $sub_attribute_dp_id = $val['sub_attribute_dp_id'];
                                        }
//                                    echo '<pre>', print_r($attr_data['sub_attribute_details']);die;
                                        ?>

                                        <?php // echo $sub_attribute_dp_id;?>
                                        <input hidden="" value="<?php echo isset($attr_sub_data['sub_update_id']) ? $attr_sub_data['sub_update_id'] : '' ?>" name="<?php echo 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '_input' ?>"/>
                                        <?php
                                        echo form_dropdown(array('id' => '', 'name' => 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'], 'class' => 'form-control', 'required' => 'required'), $options, set_value('id', $sub_attribute_dp_id));
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