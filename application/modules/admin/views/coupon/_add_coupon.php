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
                    <h2>Coupon</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                   
                    <?php
                    echo form_open_multipart('admin_library/insert_discount/', array('name' => 'form_add_coupon','id' => 'form_add_coupon', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>
                    <div class="form-group">
                        <?php echo form_label(lang('coupon_type'), 'coupon_type', array('for' => 'coupon_type', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'coupon_type',
                                'name' => 'coupon_type',
                                'class' => 'form-control',
//                                'required' => 'required',
                                'placeholder' => 'Select coupon type'
                                    ), $coupon_type
                            );
                            ?>
                        </div>
                    </div>




                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('coupon_method'), 'coupon_method', array('for' => 'coupon_method', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'coupon_method',
                                'name' => 'coupon_method',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Coupon Method'
                                    ), $coupon_method
                            );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('tax_method'), 'tax_method', array('for' => 'tax_method', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'tax_method',
                                'name' => 'tax_method',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Coupon Method'
                                    ), $coupon_method_tax
                            );
                            ?>
                        </div>
                    </div>

                    <!--   <div class="form-group">
                    <?php echo form_label(lang('location'), 'location', array('for' => 'location', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    form_dropdown(array(
                        'id' => 'location',
                        'name' => 'location',
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Select Coupon Method'
                            ), $coupon_location
                    );
                    ?>
                                            </div>
                                        </div>-->

<!--                    <div class="form-group">
                        <?php echo form_label(lang('group'), 'group', array('for' => 'group', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
//                            echo form_dropdown(array(
//                                'id' => 'group',
//                                'name' => 'zone',
//                                'class' => 'form-control',
//                                'required' => 'required',
//                                'placeholder' => 'Select zone '
//                                    ), $coupon_group
//                            );
                            ?>
                        </div>
                    </div>-->
<!--                    <div class="form-group">
                        <?php echo form_label(lang('product_name'), 'product_name', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
//                            echo form_dropdown(array(
//                                'id' => 'product_name',
//                                'name' => 'product_name',
//                                'class' => 'form-control',
////                                'required' => 'required',
//                                'placeholder' => 'Select Product Name '
//                                    ), $product_category
//                            );
                            ?>
                        </div>
                    </div>-->
<!--
                    <div class="form-group">
                        <?php echo form_label(lang('product'), 'coupon_code', array('for' => 'coupon_code', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
//                            echo form_multiselect(array(
//                                'id' => 'product',
//                                'name' => 'product',
//                                'class' => 'form-control',
//                                'required' => 'required',
//                                'placeholder' => 'Select Category'
//                                    )
//                            );
                            ?>
                            <select  id="product" class="form-control" name="product[]" multiple>
                                    <option value="1">January</option>
                                    ...
                                    <option value="12">December</option>
                            </select>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <?php echo form_label(lang('coupon_code'), 'coupon_code', array('for' => 'coupon_code', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'coupon_code',
                                'id' => 'coupon_code',
                                'name' => 'coupon_code',
                                'placeholder' => 'Coupon Code',
                                'onblur' => "chkCouponCode('coupon_code','coupon_code');",
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('coupon_desc'), 'coupon_desc', array('for' => 'coupon_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_textarea(array(
                                'id' => 'coupon_desc',
                                'name' => 'coupon_desc',
                                'placeholder' => 'Description',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('quantity'), 'quantity', array('for' => 'quantity', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'quantity',
                                'name' => 'quantity',
                                'placeholder' => 'Quantity',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('coupon_quantity'), 'coupon_quantity', array('for' => 'coupon_quantitycoupon_quantity', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'coupon_quantity',
                                'name' => 'coupon_quantity',
                                'placeholder' => 'coupon Quantity',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('coupon_value_a'), 'coupon_value_a', array('for' => 'coupon_quantity', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'coupon_value_a',
                                'name' => 'coupon_quantity_a',
                                'placeholder' => 'Value Required to Activate',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('coupon_value'), 'coupon_value', array('for' => 'coupon_value', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'coupon_value',
                                'name' => 'coupon_value',
                                'placeholder' => 'coupon value',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <?php echo form_label(lang('custom_status'), 'custom_status', array('for' => 'coupon_value', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'custom_status',
                                'name' => 'custom_status',
                                'placeholder' => 'Status',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <?php echo form_label(lang('uses_limit'), 'uses_limit', array('for' => 'uses_limit', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'uses_limit',
                                'name' => 'uses_limit',
                                'placeholder' => 'Uses Limit',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('start_d'), 'start_d', array('for' => 'start_d', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input  readonly min='<?php echo date("Y-m-d"); ?>' type="text" name="from_date"  class="form-control" value="<?php echo $effectiveDate =date("Y-m-d") ;?>"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(lang('end_d'), 'end_d', array('for' => 'end_d', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly  type="text" name="to_date" class="form-control" value="<?php echo $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)));?>"> 
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <?php echo form_label(lang('a_status'), 'a_status', array('for' => 'a_status', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" name="isactive" id="isactive" value="0"> 
                        </div>
                    </div>-->
                    <!--                    <div class="form-group">
                                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                                            <div class="col-md-2 col-sm-3 col-xs-3"><?php // echo form_label(lang('product_make'), 'product_make', array('for' => 'product_make', 'class' => 'control-label '));  ?></div>
                                            <div class="col-md-2 col-sm-3 col-xs-3"><?php // echo form_label(lang('product_year'), 'product_year', array('for' => 'product_year', 'class' => 'control-label '));  ?></div>
                                            <div class="col-md-2 col-sm-3 col-xs-3"><?php //echo form_label(lang('product_model'), 'product_model', array('for' => 'product_model', 'class' => 'control-label '));  ?></div>
                                        </div>-->
                    <!--                    <div class="form-group">
                    
                    <?php echo form_label(lang('product_sub_category'), 'product_sub_category', array('for' => 'product_sub_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                            <div class="col-md-2 col-sm-3 col-xs-3">
                    <?php
                    echo form_dropdown(array(
                        'id' => 'product_make',
                        'name' => 'product_make',
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Select Category'
                            )
                    );
                    ?>
                                            </div>
                                            <div class="col-md-2 col-sm-3 col-xs-3">
                    <?php
                    echo form_dropdown(array(
                        'id' => 'product_year',
                        'name' => 'product_year',
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Select Category',
                        'disabled' => 'disabled',
                            )
                    );
                    ?>
                                            </div>
                                            <div class="col-md-2 col-sm-3 col-xs-3">
                    <?php
                    echo form_dropdown(array(
                        'id' => 'product_model',
                        'name' => 'product_model',
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Select Category',
                        'disabled' => 'disabled',
                            )
                    );
                    ?>
                                            </div>
                                        </div>-->
                    <div class="ln_solid"></div>
                    <div class="clearfix"></div>



                    <div class="clearfix"></div>


                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                            <!--<button class="btn btn-success ">Submit</button>-->
                            <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-success " />
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <a href="<?php echo base_url(); ?>admin_library/summary_discounts" class="btn btn-primary">Cancel</a>
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
                url: '<?php echo base_url(); ?>admin/get_attributes/add',
                data: {'product_category_id': product_category_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);

                    $('#_div_attr_view').html('')
                    $('#_div_attr_view').html(parsed.content)
//                    $('select[name="product_category"]').prop("disabled", false);
//                    $('select[name="product_category"]').html(data.content).trigger('liszt:updated').val(product_category);
//                    $("#product_category").val($("#product_category option:first").val());
                }
            });
        });

        //On make change change year
        $("#idCheckStatus").change(function () {
            var checkStatus = $("#idCheckStatus").val();
            if ($('input#idCheckStatus').is(':checked')) {
                $("#idCheckStatus").val('1');
            } else
                $("#idCheckStatus").val('0');


        });
        $("#coupon_type").change(function () {
            // alert('test');
//            return false;

            $('select[name="coupon_method"]').prop("disabled", true);
//
            $("#product_model").prop("selectedIndex", 0)

            var type_id = $("select#coupon_type option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/couponFilter/type',
                data: {'type_id': type_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="coupon_method"]').prop("disabled", false);
                    $('select[name="coupon_method"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });

        //On make change change year
        $("#product_name").change(function () {

            var id = $('#product_name').val();
            $('select[name="product"]').prop("disabled", true);
//            alert(id);
//            return false;
//            var product_make_id = $("select#product_make option:selected").val();
//            var product_year_id = $("select#product_year option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/couponFilter/product',
                data: {'p_id': id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[id="product"]').prop("disabled", false);
                    $('select[id="product"]').html(parsed.content).trigger('liszt:updated').val();
//                    $("#product").multipleSelect({
//                        placeholder: "Here is the placeholder"
//                    });
                }
            });
        });


        $("#id_add_more_image").click(function () {
            $('#div_multiple_img').append('<div class="form-group"><input class="form-control" type="file" name="product_images[]"></div>');
            $('#div_multiple_img_remove').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');
        });
        $("#is_offer_product_a").click(function () {
            if ($("#is_offer_product_a").is(":checked"))
                $("#is_offer_product_a").val("1");
            else
                $("#is_offer_product_a").val("0");
        });

    });

</script>
<script src="<?php echo base_url() ?>backend/multiselect/multiple-select.js"></script>
<script>

</script>