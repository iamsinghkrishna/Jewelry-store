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
                    echo form_open_multipart('admin/manage_product/add', array('id' => 'form_add_product', 'name' => 'form_add_product', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>

                    <div class="form-group">
                        <?php //echo form_label(lang('product_name'), 'product_name', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_name',
                                'placeholder' => 'Product Name',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <?php echo form_label(lang('is_feature'), 'is_feature', array('for' => 'is_feature', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="checkbox">
                                <label class="">
                                    <div class="icheckbox_flat-green checked" style="position: relative;">
                                        <input name="product_is_feature" type="checkbox" value="0" id="idCheckStatus"></div> Is Feature
                                </label>
                            </div>
                        </div>
                    </div>-->

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_category'), 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                   
                            <div class="categoryListWrap">
                            <?php if(count($product_category) > 0){ 
                                foreach($product_category as $key=> $category){ ?>
                                 <label class="checkbox-inline">
                                        <input type="checkbox" name="product_category[]" id="product_category" value="<?php echo $key; ?>" /> <?php echo $category ?>  
                                 </label><br>
                               <?php }
                            ?>
                            <?php } ?>
                             </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="clearfix"></div>

                    <div class="div_attribut">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category</label>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                               <div class="categoryListWrap">
                                    <?php if(count($arr_sub_attribute) > 0){ 
                                        $i=0;
                                    foreach($arr_sub_attribute as $key => $sub_attribute){ ?>
                                
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="sub_category" name="sub_category[]" id="sub_category" value="<?php echo $sub_attribute['id'];  ?>" /> <?php echo $sub_attribute['attrubute_value'];  ?>
                                </label><br/>
                                    
                                        <?php $i++; } } ?>
                                </div>
                                    
                                
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="sub_attribute_div">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Attribute</label>
                           
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div style="height: 100px; overflow-y: scroll;">
                                <div id="_div_sub_attr_view">

                                </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div id='showInitialDiv' style='display:none'>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label('Inicial Product Letter', 'initial_letter', array('for' => 'initial_letter', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'initial_letter',
                                'name' => 'initial_letter',
                                'placeholder' => 'Initial Product Letter',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>


                     <div class="form-group">
                        <?php echo form_label('Inicial Product Color', 'initial_color', array('for' => 'initial_color', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'initial_color',
                                'name' => 'initial_color',
                                'placeholder' => 'Inicial Product Color',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label('Inicial Product MM', 'initial_mm', array('for' => 'initial_color', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'initial_mm',
                                'name' => 'initial_mm',
                                'placeholder' => 'Initial Product MM',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    </div>

                    
                     <div class="clearfix"></div>
                    <div class="">
                        <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Variants</label>
                           
                            <div class="col-md-6 col-sm-3 col-xs-3">
                               <select class="form-control" name="variant" id="variant" onchange="get_response_for_variant_selection(this.value)">
                                        <option value="">Add Variant</option>
                                        <option value="1"> Product Has Variant</option>
                                                								
                                </select>
                            </div>
                        </div>
                        
                    </div>

                    <div class="clearfix"></div>

                    
                    
                    
                     
                        <div id="variant_holder" <?php  if ($product_details['variant_color']
    != NULL || $product_details['variant_size'] != NULL) echo "style='display:block!important'";else echo "style='display:none'";?>>
                        <div class="form-group">
                        <?php echo form_label('Variant Color',
                            'variant_color',
                            array('for' => 'Variant Color', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="variant_color" class="form-control" name="variant_color">
                            </div>

                        </div>
                        <div class="form-group">
                            <?php echo form_label('Variant Size',
                                'variant_size',
                                array('for' => 'Variant Size', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text"  id="variant_size"  class="form-control" name="variant_size">
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                    


                    <div class="form-group">
                        <?php echo form_label(lang('product_quantity'), 'product_quantity', array('for' => 'product_quantity', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'number',
                                'id' => 'product_quantity',
                                'name' => 'product_quantity',
                                'placeholder' => 'Quantity',
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_price'), 'product_price', array('for' => 'product_price', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_price',
                                'name' => 'product_price',
                                'placeholder' => 'Price',
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_sku'), 'product_sku', array('for' => 'product_sku', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_sku',
                                'name' => 'product_sku',
                                'placeholder' => 'SKU',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_shipping_region'), 'product_shipping_region', array('for' => 'product_shipping_region', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_shipping_region',
                                'name' => 'product_shipping_region',
                                'placeholder' => 'Shipping Region',
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_images'), 'product_images', array('for' => 'product_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'file',
                                'id' => 'product_images',
                                'name' => 'product_images[]',
                                'onchange'=> "chkFile(this.value,'product_images');",
                                'placeholder' => 'Upload Images',
                                'class' => 'form-control',
                                'required' => 'required',
                                'accept' => 'image/*'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12">

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="div_multiple_img"></div>
                            <a style="cursor:pointer;" id="id_add_more_image" class=""><i class="fa fa-plus-circle"></i> Add  more</a>
                        </div>
                        <div class="col-md-1">
                            <div id="div_multiple_img_remove"></div>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('hover_images'), 'hover_images', array('for' => 'hover_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'file',
                                'id' => 'hover_images',
                                'name' => 'hover_images',
                                 'onchange'=> "chkFile(this.value,'hover_images');",
                                'placeholder' => 'Upload Images',
                                'class' => 'form-control',
                                'required' => 'required',
                                'accept' => 'image/*'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_desc'), 'product_desc', array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_textarea(array(
                                'id' => 'product_desc',
                                'name' => 'product_desc',
                                'placeholder' => 'Description',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                            <?php echo form_label('Back Order?', 'backorder', array('for' => 'Back Order?', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="back_order_flag">
                                <option  value="yes">Yes</option>
                                <option  value="no">No</option>
                            </select>
                        </div>

                    </div>
                    
                    
                    
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?php echo form_label('Clover Id', 'product_sku', array('for' => 'clover_id', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'clover_id',
                                'name' => 'clover_id',
                                'placeholder' => 'Clover ID',
                                'class' => 'form-control',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    
                    
                    <div class="form-group">
                        <?php echo form_label('Add to Clover?', 'product_desc', array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" value="1" class="cloverShow" name="add_to_clover">
                        </div>
                    </div>
                    <div class="cloverDiv">
                        <div class="form-group">
                        <?php echo form_label('product Cost', 'product_desc', array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'Product_cost',
                                'name' => 'product_cost',
                                'placeholder' => 'Product Cost',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                     <div class="form-group">
                        <?php echo form_label('Product Code', 'product_desc', array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'Product_code',
                                'name' => 'product_code',
                                'placeholder' => 'Product Code',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo form_label('Price Type', 'product_desc', array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="price_type">
                            <option value="FIXED">Fixed</option>
                            <option value="VARIABLE">Variable</option>
                            <option value="PER UNIT">Per Unit</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>

<!--                    <div class="form-group">
                        <?php echo form_label(lang('product_shipping_fees'), 'product_shipping_fees', array('for' => 'product_shipping_fees', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'product_shipping_fees',
                                'name' => 'product_shipping_fees',
                                'placeholder' => 'Shipping Fees',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_warr'), 'product_warr', array('for' => 'product_shipping_fees', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'product_warr',
                                'name' => 'product_warr',
                                'placeholder' => 'Product Warranty',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                            <!--<button class="btn btn-success ">Submit</button>-->
                            <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-success " />
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <a href="<?php echo base_url(); ?>admin/product" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>

                    <input type="hidden" name="id_add_more_image_total" id="id_add_more_image_total" value="0" />
                    <input type="hidden" id="total_variants" name="total_variants" value="0" />

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>






<script type="text/javascript">

	$(document).ready(function() {

		blank_variant_entry = $('#variant_entry').html();

//		$('#size').prop("disabled" , true);
//		$('#length').prop("disabled" , true);
//		$('#carat').prop("disabled" , true);
		
		$('#variant_holder').hide();

		// SelectBoxIt Dropdown replacement
		if($.isFunction($.fn.selectBoxIt))
		{
			$("select.selectboxit").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						showFirstOption: attrDefault($this, 'first-option', true),
						'native': attrDefault($this, 'native', false),
						defaultText: attrDefault($this, 'text', ''),
					};

				$this.addClass('visible');
				$this.selectBoxIt(opts);
			});
		}

	});

</script>

<script type="text/javascript">

	function get_response_for_variant_selection(selector)
	{
		if(selector == 1) {
			$('#variant_holder').show(500);
			$('#alert_quantity_single').prop("disabled" , true);
			$('#quantity_single').prop("disabled" , true);
			$('#selling_price_single').prop("disabled" , true);
			$('#cost_price_single').prop("disabled" , true);
		}else{
                  $('#variant_holder').hide(500);
                  $('#variant_color').val("");
            $('#variant_size').val("");
                }
	}

	function append_variant_entry()
	{
            var total_variants = $('#total_variants').val();
            var total_variants =  parseInt($('#total_variants').val());
            var total_variants_new = total_variants + parseInt("1");
            $('#total_variants').val(total_variants_new);   
            $('#variant_entry_append').append(blank_variant_entry);
	}

	function deleteParentElement(n)
	{
            var total_variants = $('#total_variants').val();
            var total_variants =  parseInt($('#total_variants').val());
            var total_variants_new = total_variants - parseInt("1");
            $('#total_variants').val(total_variants_new); 
            n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
	}

</script>




<script>
    $(document).ready(function () {
//        $("#product_category").change(function () {
//            var product_category_id = $("select#product_category option:selected").val();
//            $.ajax({
//                type: "POST",
//                url: '<?php echo base_url(); ?>admin/get_attributes/add',
//                data: {'product_category_id': product_category_id},
//                success: function (data) {
//                    var parsed = $.parseJSON(data);
//                    $('#_div_attr_view').html('');
//                    if(parsed.content != ''){
//                        $('#_div_attr_view').html(parsed.content);
//                    }else{
//                        var strs = '';
//                         var strs = 'No attribute available';
//                        $('#_div_attr_view').html(strs);
//                    }
//              }
//            });
//        });
        //On make change change year
        $("#idCheckStatus").change(function () {
            var checkStatus = $("#idCheckStatus").val();
            if ($('input#idCheckStatus').is(':checked')) {
                $("#idCheckStatus").val('1');
            } else
                $("#idCheckStatus").val('0');
        });
        $("#product_make").change(function () {
//            return false;
            $('select[name="product_model"]').prop("disabled", true);
            $("#product_model").prop("selectedIndex", 0)
            var product_make_id = $("select#product_make option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/make',
                data: {'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="product_year"]').prop("disabled", false);
                    $('select[name="product_year"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });
        //On make change change year
        $("#product_year").change(function () {
//            return false;
            var product_make_id = $("select#product_make option:selected").val();
            var product_year_id = $("select#product_year option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/year',
                data: {'product_year_id': product_year_id, 'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="product_model"]').prop("disabled", false);
                    $('select[name="product_model"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });
        $("#id_add_more_image").click(function () {
           var id_add_more_image_total =  parseInt($('#id_add_more_image_total').val());
           var id_add_more_image_total_new = id_add_more_image_total + parseInt("1");
           $('#id_add_more_image_total').val(id_add_more_image_total_new);
           //alert(id_add_more_image_total_new);
           var image_id = 'product_image'+id_add_more_image_total_new;
            $('#div_multiple_img').append('<div class="form-group"><input id="product_image'+id_add_more_image_total_new+'" class="form-control" onchange= "chkFile(this.value,this.id)", type="file" name="product_images[]"></div>');
           //$('#div_multiple_img_remove').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');
        });
        
        
              $(".cloverDiv").hide();
                $(".cloverShow").click(function() {
                if($(this).is(":checked")) {
                    $(".cloverDiv").show();
                } else {
                    $(".cloverDiv").hide();
                }
            });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("input[name='sub_category[]']").click(function () {
            var inputValue = $(this).attr("value");
            if (inputValue === '39') {
                $("#showInitialDiv").toggle();
            }

        });
        $(function () {
            $('input[name="sub_category[]"]:checked').each(function () {
                if ($(this).val() === '39') {
                    $("#showInitialDiv").show();
                }
            });
        });

    });
</script>