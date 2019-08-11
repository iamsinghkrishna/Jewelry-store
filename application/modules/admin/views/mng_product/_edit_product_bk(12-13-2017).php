<?php //echo '<pre>', print_r($product_details);echo $product_details['instagram_image'];
//die()
?>
<?php $ischeck = ''; ?>
<?php $val     = ''; ?>
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
                    <h2>Product</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    echo form_open_multipart('admin/manage_product/edit/'.$product_details['id'],
                        array('id' => 'form_add_product_edit', 'name' => 'form_add_product_edit',
                        'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>

                    <div class="form-group">
                            <?php //echo form_label(lang('product_name'), 'product_name', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'));  ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name*</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_name',
                                'placeholder' => 'Product Name',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('product_name',
                                    $product_details['product_name'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <!--                    <div class="form-group">
                    <?php echo form_label(lang('is_feature'), 'is_feature',
                        array('for' => 'is_feature', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="checkbox">
                                                    <label class="">
<?php // /echo $product_details['product_is_feature']; ?>
<?php $product_details['product_is_feature']
    == '1' ? $ischeck = "checked" : $ischeck = '' ?>
<?php $product_details['product_is_feature'] == '1' ? $val     = "1" : $val     = '0' ?>
                                                        <div class="icheckbox_flat-green checked" style="position: relative;">
                                                            <input name="product_is_feature" type="checkbox" value="<?php echo $val ?>" id="idCheckEditStatus" <?php echo $ischeck; ?>></div> Is Feature
                                                    </label>
                                                </div>
                                            </div>
                                        </div>-->

                    <!--                    <div class="form-group">
<?php echo form_label(lang('product_tag'), 'Tag',
    array('for' => 'tags', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input id="tags_1" type="text" class="tags form-control" name="tags" value="<?php echo $tags; ?>" />
                                                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                                </div>
                                            </div>
                                        </div>-->


                    <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_category">Is Instagram Product?</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <select class="form-control" id="is_instagram_product" name="is_instagram_product" onchange="getInstagramImage(this.value);">
                                <option value=""> Select Instagram Image</option>
<?php
if (!empty($insta_feeds)) {
    for ($i = 0; $i <= 20; $i++) {
        $arr_current_image = explode('//', $insta_feeds[$i]);
        ?>
                                        <option style="overflow: hidden;white-sapce: no-wrap;text-overflow: ellipsis;width: 430px !important;" value="<?php echo $arr_current_image[1]; ?>" <?php if ($product_details['instagram_image']
            == $arr_current_image[1]) { ?>selected="selected" <?php } ?>><?php echo $insta_feeds[$i]; ?></option>
    <?php }
}
?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" <?php if ($product_details['instagram_image']
    == '') { ?>style="display:none;" <?php } ?> id="instagram_image_main_div">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_category">Instagram Image</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div id="instagram_image_div">
                                <img src="<?php echo 'https://'.$product_details['instagram_image']; ?>"  style="width:300px;height:200px;"/>
                            </div>
                        </div>
                    </div>


                    <div class="clearfix"></div>

                    <div class="form-group">
                                <?php echo form_label(lang('product_category'),
                                    'product_category',
                                    array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="categoryListWrap">
<?php
if (count($product_category) > 0) {
    $category_id     = $product_details['category_id'];
    $arr_category_id = explode(',', $category_id);
    foreach ($product_category as $key => $category) {
        ?>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="product_category[]" id="product_category" value="<?php echo $key; ?>" <?php if (in_array("$key",
                                            $arr_category_id)) { ?>checked<?php } ?> /> <?php echo $category ?>
                                        </label><br>
                                        <?php }
                                        ?>
<?php } ?>
                            </div>
                        </div>
                    </div>


                    <div class="div_attribut">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category</label>
                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <div class="categoryListWrap">
<?php
if (count($arr_sub_attribute) > 0) {
    $sub_category_id     = $product_details['sub_category_id'];
    $arr_sub_category_id = explode(',', $sub_category_id);
    $i                   = 0;
    foreach ($arr_sub_attribute as $key => $sub_attribute) {
        ?>
                                            <label class="checkbox-inline">
                                                <input onchange="getThirdLevelSubCategory();" type="checkbox" name="sub_category[]" id="sub_category" <?php if (in_array($sub_attribute['id'],
                $arr_sub_category_id)) { ?>checked<?php } ?> value="<?php echo $sub_attribute['id']; ?>" /> <?php echo $sub_attribute['attrubute_value']; ?>
                                            </label><br>
        <?php $i++;
    }
} ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="clearfix"></div>

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

                    <div class="clearfix"></div>
                    <div class="">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Variants</label>

                            <div class="col-md-6 col-sm-3 col-xs-3">
                                <select class="form-control" name="variant" id="variant" onchange="get_response_for_variant_selection(this.value)">
                                    <option value="">Add Variant</option>
                                    <option value="1" <?php if ($product_details['variant_color']
    != NULL || $product_details['variant_size'] != NULL) { ?>selected="selected" <?php } ?>> Product Has Variant</option>

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
                                <input type="text" id="variant_color" value="<?php echo $product_details['variant_color']; ?>" class="form-control" name="variant_color">
                            </div>

                        </div>
                        <div class="form-group">
                            <?php echo form_label('Variant Size',
                                'variant_size',
                                array('for' => 'Variant Size', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text"  id="variant_size" value="<?php echo $product_details['variant_size']; ?>" class="form-control" name="variant_size">
                            </div>

                        </div>
                    </div>




                    <div class="clearfix"></div>



                    <div class="form-group">
                            <?php echo form_label(lang('product_quantity'),
                                'product_quantity',
                                array('for' => 'product_quantity', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'number',
                                'id' => 'product_quantity',
                                'name' => 'product_quantity',
                                'placeholder' => 'Quantity',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('quantity',
                                    $product_details['quantity'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                            <?php echo form_label(lang('product_price'),
                                'product_price',
                                array('for' => 'product_price', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
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
    'value' => set_value('price', $product_details['price'])
));
?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                            <?php echo form_label(lang('product_sku'),
                                'product_sku',
                                array('for' => 'product_sku', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
<?php
echo form_input(array(
    'type' => 'text',
    'id' => 'product_sku',
    'name' => 'product_sku',
    'placeholder' => 'SKU',
    'class' => 'form-control',
    'required' => 'required',
    'value' => set_value('product_sku', $product_details['product_sku'])
));
?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
<?php echo form_label(lang('product_shipping_region'),
    'product_shipping_region',
    array('for' => 'product_shipping_region', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
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
    'value' => set_value('shipping_region', $product_details['shipping_region'])
));
?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
<?php $imgCnt = count($product_details['product_images_details']); ?>
<?php if ($imgCnt > 0) { ?>
    <?php for ($i = 0; $i < $imgCnt; $i++) { ?>
                            <div class="form-group">
        <?php echo form_label(lang(''), '',
            array('for' => 'product_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!--<input name="" value="<?php echo $product_details['product_images_details'][$i]['id']; ?>">-->
                                    <div id="imgDiv_<?php echo $product_details['product_images_details'][$i]['id']; ?>">
                                        <a class="btn btn-xs btn-default" id="remove_image" onclick="deleteProductImg(<?php echo $product_details['product_images_details'][$i]['id']; ?>)"><i class="fa fa-remove text-danger "></i></a>
                                        <image  class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url().$product_details['product_images_details'][$i]['url']; ?>" onerror="this.onerror=null;this.src='imagefound.gif';"/>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function deleteProductImg(imageId)
                                {
                                    if (confirm('Are you sure you want to delete this image?')) {
                                        $('#imgDiv_' + imageId).remove();
                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo base_url(); ?>admin/delete/images',
                                            data: {'imageId': imageId},
                                            success: function (data) {
                                            }
                                        });
                                    }
                                }

                                function deleteProductHoverImg(product_id) {
                                    if (product_id > 0) {
                                        if (confirm('Are you sure you want to delete this image?')) {
                                            $.ajax({
                                                type: "POST",
                                                url: '<?php echo base_url(); ?>admin/deleteHoverImage',
                                                data: {'product_id': product_id},
                                                success: function (data) {
                                                    if (data == 1) {
                                                        $('#product_hover_image_div').css('display', 'none');
                                                    } else {
                                                        location.relaod;
                                                    }
                                                }
                                            });
                                        }
                                    }
                                }

                            </script>
    <?php } ?>
                    <?php } ?>

                    <div class="clearfix"></div>

                    <div class="form-group">
<?php echo form_label(lang('product_images'), 'product_images',
    array('for' => 'product_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">

<?php
echo form_input(array(
    'type' => 'file',
    'id' => 'product_images',
    'name' => 'product_images[]',
    'onchange' => "chkFile(this.value,'product_images');",
    'placeholder' => 'Upload Images',
    'class' => 'form-control',
//                                'required' => 'required',
    'accept' => 'image/*',
//                                'value' => set_value('shipping_region', $product_details['product_images_details'][$i]['url'])
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
                            <?php if (isset($product_details['product_images_details'])
                                && $product_details['product_images_details'][0]['hover_img_url']
                                != '') { ?>
                                <?php // echo $product_details['product_images_details'][0]['hover_img_url'];?>
                                <?php // foreach ($product_details['product_images_details'] as $img){?>
                        <div  id="product_hover_image_div" style="margin-left: 26%;">
                            <a class="btn btn-xs btn-default" id="remove_image" onclick="deleteProductHoverImg(<?php echo $product_details['id']; ?>)"><i class="fa fa-remove text-danger "></i></a>
                            <img  class="img-responsive img-thumbnail p_img_50 " style="margin-bottom: 10px;" src="<?php echo base_url().$product_details['product_images_details'][0]['hover_img_url'] ?>" onerror="this.onerror=null;this.src='imagefound.gif';" >
                        </div>
<?php } ?>

                    <div class="form-group">
                        <?php echo form_label(lang('hover_images'),
                            'hover_images',
                            array('for' => 'hover_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'file',
                                'id' => 'hover_images',
                                'name' => 'hover_images',
                                'onchange' => "chkFile(this.value,'hover_images');",
                                'placeholder' => 'Upload Images',
                                'class' => 'form-control',
//                                'required' => 'required',
                                'accept' => 'image/*'
                            ));
                            ?>
                        </div>
                        <input type="hidden" name="hurl" value="<?php echo $product_details['product_images_details'][0]['hover_img_url']; ?>">
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
<?php echo form_label(lang('product_desc'),
    'product_desc',
    array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
<?php
echo form_textarea(array(
    'id' => 'product_desc',
    'name' => 'product_desc',
    'placeholder' => 'Description',
    'class' => 'form-control',
    'required' => 'required',
    'value' => set_value('description', $product_details['description'])
));
?>
                        </div>
                    </div>

                    <div class="clearfix"></div>



                    <div class="form-group">
<?php echo form_label(lang('product_status'),
    'product_status',
    array('for' => 'product_status', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
<?php
echo form_dropdown(array('id' => 'isactive', 'name' => 'isactive'), $isactive,
    set_value('isactive', $product_details['isactive']),
    array('class' => 'form-control'));
?>
                        </div>

                    </div>
                    <div class="form-group">
<?php echo form_label('Back Order?', 'backorder',
    array('for' => 'Back Order?', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="back_order_flag">
                                <option <?php if ($product_details['back_order_flag']
    == 'yes') echo 'selected'; ?> value="yes">Yes</option>
                                <option <?php if ($product_details['back_order_flag']
    == 'no') echo 'selected'; ?> value="no">No</option>
                            </select>
                        </div>

                    </div>

                    <div class="clearfix"></div>
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
                    <input type="hidden" name="sub_attribute_id_new" id="sub_attribute_id_new" value="<?php echo $sub_attribute_id; ?>" />
                    <input type="hidden" name="product_sub_attribute_id" id="product_sub_attribute_id" value="<?php echo $product_details['sub_attribute_id_new']; ?>" />
                    <input type="hidden" id="total_variants" name="total_variants" value="<?php echo count($arr_product_variants); ?>" />
<?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>



<script type="text/javascript">

    $(document).ready(function () {

        blank_variant_entry = $('#variant_entry').html();

//		$('#size').prop("disabled" , true);
//		$('#length').prop("disabled" , true);
//		$('#carat').prop("disabled" , true);

//        var total_variants = $('#total_variants').val();
//        if (total_variants < 1) {
//            $('#variant_holder').hide();
//        } else {
//            $('#variant_entry').css('display', 'none');
//        }

        // SelectBoxIt Dropdown replacement
        if ($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function (i, el)
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
        if (selector == 1) {
            $('#variant_holder').show(500);
            $('#alert_quantity_single').prop("disabled", true);
            $('#quantity_single').prop("disabled", true);
            $('#selling_price_single').prop("disabled", true);
            $('#cost_price_single').prop("disabled", true);
        } else {
            $('#variant_holder').hide(500);
            $('#variant_color').val("");
            $('#variant_size').val("");

        }
    }

    function append_variant_entry()
    {
        var total_variants = $('#total_variants').val();
        var total_variants = parseInt($('#total_variants').val());
        var total_variants_new = total_variants + parseInt("1");
        $('#total_variants').val(total_variants_new);
        $('#variant_entry_append').append(blank_variant_entry);
    }

    function deleteParentElement(n)
    {
        var total_variants = $('#total_variants').val();
        var total_variants = parseInt($('#total_variants').val());
        var total_variants_new = total_variants - parseInt("1");
        $('#total_variants').val(total_variants_new);
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }

</script>


<script>
    $(document).ready(function () {
        var attribute_names = $('#sub_attribute_id_new').val();
        if (attribute_names != '') {
            getThirdLevelSubCategoryEdit();
        }


//            return false;
        var product_category_id = $("select#product_category option:selected").val();
//        alert(product_category_id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/get_attributes/edit',
            data: {'product_category_id': product_category_id, 'product_id':<?php echo $product_details['id'] ?>},
            success: function (data) {
                var parsed = $.parseJSON(data);
                $('#_div_attr_view').html('')
                $('#_div_attr_view').html(parsed.content)
            }
        });

//        $("#product_category").change(function () {
////            return false;
//            var product_category_id = $("select#product_category option:selected").val();
//            $.ajax({
//                type: "POST",
//                url: '<?php echo base_url(); ?>admin/get_attributes/add',
//                data: {'product_category_id': product_category_id},
//                success: function (data) {
//                    var parsed = $.parseJSON(data);
//
//                    $('#_div_attr_view').html('')
//                    $('#_div_attr_view').html(parsed.content)
////                    $('select[name="product_category"]').prop("disabled", false);
////                    $('select[name="product_category"]').html(data.content).trigger('liszt:updated').val(product_category);
////                    $("#product_category").val($("#product_category option:first").val());
//                }
//            });
//        });
        $("#idCheckEditStatus").change(function () {
            var checkStatus = $("#idCheckEditStatus").val();
            if ($('input#idCheckEditStatus').is(':checked')) {
                $("#idCheckEditStatus").val('1');
            } else {
                $("#idCheckEditStatus").val('0');
            }
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
//            $('#div_multiple_img').append('<div class="form-group"><input class="form-control" type="file" name="product_images[]"></div>');
//            $('#div_multiple_img_remove').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');

            var id_add_more_image_total = parseInt($('#id_add_more_image_total').val());
            var id_add_more_image_total_new = id_add_more_image_total + parseInt("1");
            $('#id_add_more_image_total').val(id_add_more_image_total_new);
            //alert(id_add_more_image_total_new);
            var image_id = 'product_image' + id_add_more_image_total_new;
            $('#div_multiple_img').append('<div class="form-group"><input id="product_image' + id_add_more_image_total_new + '" class="form-control" onchange= "chkFile(this.value,this.id)", type="file" name="product_images[]"></div>');

        });
    });


    function getInstagramImage(image) {
        if (image != '') {
            var str = '';
            str += '<img style="width:300px;height:200px;" src="https://' + image + '" />';
            $('#instagram_image_div').html(str);
            $('#instagram_image_main_div').css('display', 'block');
        }
    }
</script>