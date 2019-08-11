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
        <?php  //echo '<pre>', print_r($attr_data); die;?>
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
            'name' => 'p_sub_category_id[]',
            'class' => 'form-control',
            'required' => 'required',
            'onchange' => 'getproductDetailsBySubCat(this.value,'.$id.')',
                ), $options, set_value('p_sub_category_id', $selectedId)
        );
        ?>

        <br>
    <?php } ?>
<?php } ?>
