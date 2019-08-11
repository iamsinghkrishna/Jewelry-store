<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $page_title; ?></h3>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <?php
        $msg = $this->session->userdata('msg');
        ?>
        <?php if ($msg != '') { ?>
            <div class="msg_box alert alert-success">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg;
                $this->session->unset_userdata('msg');
                ?>
            </div>
        <?php } ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Products</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    echo form_open('admin/featured_category/add',
                        array('id' => 'form_add_product', 'class' => 'form-horizontal ',
                        'data-parsley-validate'));
                    ?>

                    <p style="text-align:center" id="cat_msg"></p>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php
                        echo form_label('Section 1', 'product_category',
                            array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'product_category1',
                                'onchange' => 'getAttr(this.value,1)',
                                'name' => 'product_category[]',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                ), $product_category,
                                array($curr_data[0]['category_id'])
                            );
                            ?>


                        </div>
                    </div>
                    <div class="div_attribut">
                        <div class="form-group">
                            <?php
                            echo form_label(lang('attributes'), 'attributes',
                                array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                            ?>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div id="_div_attr_view1">

                                    <select onchange="getproductDetailsBySubCat(this.value,'1')" class="form-control" name="p_sub_category_id[]">
                                        <?php
                                        foreach ($prodcut_cat_detailup1 as $pcd) {
                                            if ($curr_data[0]['subcategory_id'] == $pcd['p_sub_category_id'])
                                                    $selected = "selected";
                                            else $selected = "";
                                            echo "<option ".$selected." value='".$pcd['p_sub_category_id']."'>".$pcd['attrubute_value']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="prodsection1" class="form-group">
                            <?php
                            echo form_label('Product Name', 'attributes',
                                array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                            ?>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div id="">
                                    <select required name='product_ids_0[]' id='_div_prod_view1' class='form-control' multiple>
                                        <?php  if(!empty($curr_cat_products1)){
                                            foreach($curr_cat_products1 as $fp){
                                                if(in_array($fp['id'],$prarr1)) $selected = 'selected';else $selected='';
                                                echo "<option ".$selected." value='".$fp['id']."'>".$fp['product_name']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>


                    <div class="form-group">
                        <?php
                        echo form_label('Section 2', 'product_category',
                            array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'product_category',
                                'name' => 'product_category[]',
                                'onchange' => 'getAttr(this.value,2)',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                ), $product_category,
                                array($curr_data[1]['category_id'])
                            );
                            ?>
                        </div>
                    </div>
                    <div class="div_attribut">
                        <div class="form-group">
                            <?php
                            echo form_label(lang('attributes'), 'attributes',
                                array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                            ?>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div id="_div_attr_view2">
                                    <select onchange="getproductDetailsBySubCat(this.value,'2')" class="form-control" name="p_sub_category_id[]">
                                        <?php
                                        foreach ($prodcut_cat_detailup2 as $pcd) {
                                            if ($curr_data[1]['subcategory_id'] == $pcd['p_sub_category_id'])
                                                    $selected = "selected";
                                            else $selected = "";
                                            echo "<option ".$selected." value='".$pcd['p_sub_category_id']."'>".$pcd['attrubute_value']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div id="prodsection2" class="form-group">
                            <?php
                            echo form_label('Product Name', 'attributes',
                                array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                            ?>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div id="">
                                    <select required name='product_ids_1[]' id='_div_prod_view2' class='form-control' multiple>
                                        <?php  if(!empty($curr_cat_products2)){
                                            foreach($curr_cat_products2 as $fp){
                                                if(in_array($fp['id'],$prarr2)) $selected = 'selected';else $selected='';
                                                echo "<option ".$selected." value='".$fp['id']."'>".$fp['product_name']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php
                        echo form_label('Section 3', 'product_category',
                            array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'product_category',
                                'name' => 'product_category[]',
                                'onchange' => 'getAttr(this.value,3)',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                ), $product_category,
                                array($curr_data[2]['category_id'])
                            );
                            ?>

                        </div>
                    </div>
                    <div class="div_attribut">
                        <div class="form-group">
                            <?php
                            echo form_label(lang('attributes'), 'attributes',
                                array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));
                            ?>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div id="_div_attr_view3">
                                    <?php if (!empty($prodcut_cat_detailup3))  ?>
                                    <select onchange="getproductDetailsBySubCat(this.value,'3')" class="form-control" name="p_sub_category_id[]">
                                        <?php
                                        foreach ($prodcut_cat_detailup3 as $pcd) {
                                            if ($curr_data[2]['subcategory_id'] == $pcd['p_sub_category_id'])
                                                    $selected = "selected";
                                            else $selected = "";
                                            echo "<option ".$selected." value='".$pcd['p_sub_category_id']."'>".$pcd['attrubute_value']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <div id="prodsection3" class="form-group">
                                        <?php echo form_label('Product Name',
                                            'attributes',
                                            array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div id="">
                                    <select required name='product_ids_2[]' id='_div_prod_view3' class='form-control' multiple>
                                        <?php  if(!empty($curr_cat_products3)){
                                            foreach($curr_cat_products3 as $fp){
                                                if(in_array($fp['id'],$prarr3)) $selected = 'selected';else $selected='';
                                                echo "<option ".$selected." value='".$fp['id']."'>".$fp['product_name']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-success ">Submit</button>
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <!--<a href="<?php echo base_url(); ?>admin/product" class="btn btn-primary">Cancel</a>-->
                        </div>
                    </div>



                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
//    $("#prodsection1").hide();

    function getAttr(val, id) {
//            return false;
        var product_category_id = val;
        //alert(product_category_id);
//        if (product_category_id !== '') {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/getSubCategory',
            data: {'product_category_id': product_category_id,'id':id},
            success: function (data) {

                var parsed = $.parseJSON(data);
                $('#_div_attr_view' + id).html('')
                $('#_div_attr_view' + id).html(parsed.content);
                if (parsed.content == '') {
                    var name_msg = "You must have to add attributes for selected categories from product category management";
                    //alert(name_msg);
                    $('#cat_msg').html("<span style='color:red'>" + name_msg + "</span>");
//                   $('#myModal').modal('show');

                } else {
                    $('#cat_msg').html("");
                }
            }
        });
//        }
    }

    function getproductDetailsBySubCat(subcatid,id) {
        var cat = $("#product_category"+id).val();
        var subcat = subcatid;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/getProductBySubCategory',
            data: {'product_category_id': cat, 'product_sub_category_id': subcat},
            success: function (data) {

                var parsed = $.parseJSON(data);
                if (parsed.status === 200) {
                    $("#prodsection"+id).show();
                    $("#_div_prod_view"+id).html(parsed.data);
                }
            }
        });
    }

    $("#id_add_more_image").click(function () {
        $('#div_multiple_img').append('<div class="form-group"><input class="form-control" type="file" name="product_images[]"></div>');
        $('#div_multiple_img_remove').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');
    });

</script>

<div class="modal fade" id="myModal" role="dialog" style="z-index:999999999 !important">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                <h4 class="modal-title"><?php echo lang('Message'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="my_message_feature"></p>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <button type="button"  data-dismiss="modal" >Close</button>
            </div>
        </div>

    </div>
</div>