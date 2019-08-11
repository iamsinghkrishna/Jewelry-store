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
                    <form action="<?php echo site_url(); ?>admin/update_bulk_inventory" method="post" enctype="multipart/form-data" name="form1" id="form1">
<!--                        <div class="form-group">
                            <?php echo form_label(lang('product_category'), 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_csv_category',
                                    'name' => 'product_csv_category',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select Category'
                                        ), $product_csv_category
                                );
                                ?>
                            </div>
                        </div>-->
                        <div class="clearfix"></div>

                        <br>
                        <div class="form-group">
                            <?php echo form_label(lang('product_csv'), 'product_csv', array('for' => 'product_csv', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <table>
                                    <tr>


                                    </tr>
                                    <tr>

                                        <td>
                                            <input type="file" class="form-control" name="userfile" id="userfile"  align="center"  />
                                            <p class="text-danger"><?php echo $this->session->flashdata('msg'); ?></p>
                                        </td>
                                        <td>
                                            <div class="col-lg-offset-3 col-lg-9">
                                                <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                                                <input type="submit" id="btn_submit" name="btn_submit" value="Update Inventory" class="btn btn-success " />
                                                <!--<button type="submit" name="submit" class="btn btn-info">Upload CSV File</button>-->
                                            </div>
                                        </td>
                                    </tr>

                                </table>

                            </div>
                            <div class="clearfix"></div>

                        </div>
                    </form>
                    <div id="_div_attr_view">

                    </div>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#product_csv_category").change(function () {
            //            return false;
            var product_category_id = $("select#product_csv_category option:selected").val();
            var product_category_name = $("select#product_csv_category option:selected").text();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/get_attributes/add_cvs',
                data: {'product_category_id': product_category_id, 'product_category_name': product_category_name},
                success: function (data) {
                    var parsed = $.parseJSON(data);
//                    alert(parsed.content);
//                    $('#_div_attr_view').html('')
//                    $('#_div_attr_view').html(parsed.content)
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
<script>
    $(document).ready(function () {

        $("#product_datatable_csv").dataTable();

        setInterval(function(){
            $( "#responsive_table" ).addClass( "table-responsive" );

        }, 1000);
    });
</script>