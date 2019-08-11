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
    <?php if ($options != '') { ?>

        <select class="form-control" id="attribute_name" name="attribute_name">
            <option value="">Select Sub Category </option>
            <?php echo $options; ?>
        </select>
        <br>
    <?php } ?>
<?php } ?>

