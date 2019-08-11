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
                    <h2>Add Store</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php
                    echo form_open_multipart('admin/inventory/edit-store/', array('name' => 'form_add_coupon', 'id' => 'form_add_coupon', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>




                    <div class="form-group">
                        <?php echo form_label(('Store Name'), 'store_name', array('for' => 'store_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'store_name',
                                'name' => 'store_name',
                                'placeholder' => 'Store Name',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(('Phone'), 'phone', array('for' => 'phone', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'phone',
                                'name' => 'phone',
                                'placeholder' => 'Phone Number',
                                'class' => 'form-control',
                                'required' => 'required',
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo form_label(('Address'), 'Address', array('for' => 'phone', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            $data = array(
                                'name' => 'address',
                                'id' => 'address',
                                'value' => set_value('address'),
                                'rows' => '5',
                                'cols' => '20',
                                'class' => 'form-control',
                                'required' => 'required',
                            );

                            echo form_textarea($data);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label(('Status'), 'Status', array('for' => 'phone', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            $options = array(
                                '1' => 'Active',
                                '0' => 'Inactive',
                            );


                            echo form_dropdown('status', $options, set_value('status'), 'class="form-control" id="my_id"');
                            ?>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
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