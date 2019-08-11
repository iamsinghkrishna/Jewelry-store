<?php // echo '<pre>', print_r($prodcut_cat_detail);die;             ?>
<?php if (!empty($prodcut_cat_detail) && isset($prodcut_cat_detail))  ?>
<?php foreach ($prodcut_cat_detail as $key => $pData) { ?>
    <div class="modal fade id_pc_edit_make_<?php echo $pData['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Product Category</h4>
                </div>
                <?php echo form_open('admin/product_category/edit/' . $pData['id'], array('id' => 'id_form_product_category', 'class' => 'form-horizontal form-label-left', 'data-parsley-validate')); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_name">Category Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'name' => 'category_name',
                                'placeholder' => 'Category Name',
                                'required' => 'required',
                                'class' => 'form-control',
                                'value' => html_entity_decode(set_value('name', ($pData['name']))),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_description">Category Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea maxlength="200" minlength="10" type="text" id="category_name" name="category_description_<?php echo $pData['id']?>" required="required" class="form-control col-md-7 col-xs-12"><?php echo $pData['description']?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sub categories mapped<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if (isset($pData['sub_attibutes']) && !empty($pData['sub_attibutes']))  ?>
                            <?php foreach ($pData['sub_attibutes'] as $subAttrData) { ?>
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'parent_id',
                                    'name' => 'parent_id[' . $subAttrData['p_sub_category_id'] . ']',
                                    'class' => 'form-control',
//                                    'required' => 'required',
                                        ), $attt_category, set_value('id', $subAttrData['p_sub_category_id'])
                                );
                                ?>
                                <div class="margin-top-10"></div>
                            <?php } ?>

                        </div>
                        <div class="col-sm-3">
                            <a  target="__blank" href="<?php echo base_url() ?>admin/attirbutes"><i class="fa fa-plus-circle"></i> Add More Category</a>
                        </div> 

                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="id_dv_add_more_attr_ed_<?php echo $pData['id'] ?>">

                            </div>

                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div id="id_remove_btn_ed_<?php echo $pData['id'] ?>">

                            </div>

                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                            <a class="btn btn-default btn-xs" id="id_am_attr_edit_<?php echo $pData['id'] ?>"><i class="fa fa-plus-circle"></i> Add More Attribute</a>
                        </div>
                    </div>



                    <div class="ln_solid"></div>
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

            $("#id_am_attr_edit_<?php echo $pData['id'] ?>").click(function () {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>admin/ajax_product_category',
                    success: function (data) {
                        var parsed = $.parseJSON(data);
                        $('#id_dv_add_more_attr_ed_<?php echo $pData['id'] ?>').append(parsed.content);
                        $('#id_remove_btn_ed_<?php echo $pData['id'] ?>').append('');
                    }
                });
            });
        });
    </script>
<?php }
?>
