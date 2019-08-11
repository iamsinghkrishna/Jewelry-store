<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $page_title; ?></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Products</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    echo form_open_multipart('admin/subAttributesAdd', array('id' => 'form_add_subAttributes', 'name' => 'form_add_subAttributes', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>
                    
                    <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12"> Category*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'product_category',
                                'name' => 'product_category',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                    ), $product_category
                            );
                            ?>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <?php //echo form_label(lang('product_name'), 'product_name', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Attribute Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" id="_div_attr_view">
<!--                             <select id="attribute_name" name="attribute_name" class="form-control">
                                <option value="">Select Attribute Name</option>
                                <?php
                                    if(count($prodcut_cat_detail)){ 
                                        foreach($prodcut_cat_detail as $key=> $cat_details){
                                    ?>
                                <option value="<?php echo $cat_details['id']  ?>"><?php echo $cat_details['attrubute_value'] ?></option>   
                                     <?php }  }
                                ?>
                            </select>-->
                        </div>
                    </div>

                    <div class="form-group">
                        <?php //echo form_label(lang('product_name'), 'product_name', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Attribute Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="subattribute_name" id="subattribute_name" placeholder="Sub Attribute Name" class="form-control" required="required" />
                           
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                            <!--<button class="btn btn-success ">Submit</button>-->
                            <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-success " />
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <a href="<?php echo base_url(); ?>admin/subAttributesList" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>

                    

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
    $(document).ready(function () {
        $("#product_category").change(function () {
//            return false;
            var product_category_id = $("select#product_category option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/get_attributesForSubattributes',
                data: {'product_category_id': product_category_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('#_div_attr_view').html('');
                    //alert(parsed.content);
                    if(parsed.content != ''){
                        $('#_div_attr_view').html(parsed.content);
                    }else{
                        var strs = '';
                         var strs = 'No attribute available';
                        $('#_div_attr_view').html(strs);
                    }
//                    $('select[name="product_category"]').prop("disabled", false);
//                    $('select[name="product_category"]').html(data.content).trigger('liszt:updated').val(product_category);
//                    $("#product_category").val($("#product_category option:first").val());
                }
            });
        });
        
    });
</script>