<?php // echo '<pre>', print_r($prodcut_cat_detail);die;                                                         ?>
<?php // echo '<pre>', print_r($prodcut_cat_detail);die;                                                         ?>
<style>
   
</style>
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
                    <form action="<?php echo site_url(); ?>admin/product/addcsv" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
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
                                                <input type="submit" id="btn_submit" name="btn_submit" value="Import And Upload All Products" class="btn btn-success " />
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
                    <?php if (($excel_row_data) && !empty($excel_row_data)) { ?>
                        <div>
                            <div class="ln_solid"></div> 
                            <form action="<?php echo site_url(); ?>admin/manage_product/addcsvdata" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
                                <!--                                <div class="form-group">
                                <?php echo form_label(lang('product_category'), 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
//                                        echo form_dropdown(array(
//                                            'id' => 'product_category',
//                                            'name' => 'product_category',
//                                            'class' => 'form-control',
//                                            'required' => 'required',
//                                            'placeholder' => 'Select Category'
//                                                ), $product_category
//                                        );
                                ?>
                                                                    </div>
                                                                </div>-->


                                <div class="clearfix"></div>



                                <!--<div class="ln_solid"></div>-->
                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <?php echo form_label(lang('csv_data'), 'csv_data', array('for' => 'csv_data', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                <button type="submit" class=" pull-right btn btn-success ">Import (<?php echo count($excel_row_data)?>) Products</button>
                                <div class="col-sm-12">


                                    
                                        <div id="responsive_table" class="table-responsive">
                                        <table class="table" id=""><!-- product_datatable_csv -->
                                            <thead>
                                                <tr>
                                                    <?php
//                                                    $i = 1;
                                                    foreach ($excel_row as $rowtitle) {
                                                        ?>
                                                        <?php // if (isset($attr_data['sub_attribute_details']))  ?>
                                                        <?php foreach ($rowtitle as $t) { ?>
                                                            <th >
                                                                <?php echo $t ?>
                                                            </th>
                                                            <?php
//                                                            $i++;
                                                        }
                                                        ?>
                                                    <?php } ?>
    <!--<th>Description</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php if (!empty($excel_row_data)) { ?>
                                                    <?php foreach ($excel_row_data as $rowData) { ?>

                                                        <tr>
                                                            <td >
                                                                <input hidden="" value="<?php echo count($excel_row_data) ?>" name="csv_data_count">
                                                                <input  hidden value="<?php echo $product_categoty_id ?>" name="product_categoty_id">
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_sku',
                                                                    'name' => 'product_sku[]',
                                                                    'placeholder' => 'SKU',
                                                                    'class' => 'form-control',
                                                                    'readonly' => 'readonly',
                                                                    'required' => 'required',
                                                                    'value' => set_value('A', $rowData['A'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_name',
                                                                    'readonly' => 'readonly',
                                                                    'name' => 'product_name[]',
                                                                    'placeholder' => 'Product Name',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('B', isset($rowData['B'])?$rowData['B']:'no title')
                                                                ));
                                                                ?>
                                                                
                                                            </td>
                                                            <td >
                                                                
                                                                <textarea readonly name="product_description[]"><?php echo $rowData['C']; ?></textarea>
                                                            </td>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_price',
                                                                    'name' => 'product_price[]',
                                                                    'readonly' => 'readonly',
                                                                    'readonly' => 'readonly',
                                                                    'placeholder' => 'Price',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('D', $rowData['D'])
                                                                ));
                                                                ?>
                                                            </td>

                                                          
                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_quantity',
                                                                    'name' => 'product_quantity[]',
                                                                    'readonly' => 'readonly',
                                                                    'readonly' => 'readonly',
                                                                    'placeholder' => 'Quantity',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('E', $rowData['E'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_shipping_region',
                                                                    'name' => 'product_shipping_region[]',
                                                                    'readonly' => 'readonly',
                                                                    'placeholder' => 'Region',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('F', $rowData['F'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_category',
                                                                    'name' => 'product_category[]',
                                                                    'readonly' => 'readonly',
                                                                    'placeholder' => 'Category',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('G', $rowData['G'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'id_select_sub_part',
                                                                    'name' => 'id_select_sub_part[]',
                                                                    'readonly' => 'readonly',
                                                                    'placeholder' => 'Attribute',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('H', $rowData['H'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            
                                                            
                                                            
                                                          
                                                            
<!--                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'size',
                                                                    'name' => 'size[]',
                                                                    'placeholder' => 'size',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('I', $rowData['I'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            
                                                             <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'length',
                                                                    'name' => 'length[]',
                                                                    'placeholder' => 'Length',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('J', $rowData['J'])
                                                                ));
                                                                ?>
                                                            </td>

                                                            
                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'carat',
                                                                    'name' => 'carat[]',
                                                                    'placeholder' => 'carat',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('K', $rowData['K'])
                                                                ));
                                                                ?>
                                                            </td>-->




                                                                        
                                                            <td>
                                                                <?php if (isset($rowData['I']) && $rowData['I'] != '') { ?>
                                                                    <?php echo $rowData['I'] ?>
                                                                <?php } else { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>
                                                                <?php } ?>
                                                                    
                                                              
                                                                <input hidden="" value="<?php echo isset($rowData['I']) ? $rowData['I'] : ''; ?>" name="image1[]">
                                                               
                                                            <td>
                                                                <?php if (isset($rowData['J']) && $rowData['J'] != '') { ?>
                                                                    <?php echo $rowData['J'] ?>
                                                                <?php } else { ?>
                                                                    <!--<image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>-->
                                                                <?php } ?>
                                                                    
                                                               
                                                                <input hidden value="<?php echo isset($rowData['J']) ? $rowData['J'] : '' ?>" name="image2[]">
                                                               
                                                            </td>
                                                            <td >
                                                                <?php if (isset($rowData['K']) && $rowData['K'] != '') { ?>
                                                                    <?php echo $rowData['K'] ?>
                                                                <?php } else { ?>
                                                                    <!--<image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>-->
                                                                <?php } ?>
                                                                 <input hidden value="<?php echo isset($rowData['K']) ? $rowData['K'] : '' ?>" name="image3[]">
                                                               
                                                            </td>
                                                            
                                                            
                                                            <td >
                                                                <?php if (isset($rowData['L']) && $rowData['L'] != '') { ?>
                                                                    <?php echo $rowData['L'] ?>
                                                                <?php } else { ?>
                                                                    <!--<image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>-->
                                                                <?php } ?>
                                                                 <input hidden value="<?php echo isset($rowData['L']) ? $rowData['L'] : '' ?>" name="image4[]">
                                                               
                                                            </td>
                                                            <td >
                                                                <?php if (isset($rowData['M']) && $rowData['M'] != '') { ?>
                                                                   <?php echo $rowData['M'] ?>
                                                                <?php } else { ?>
                                                                    <!--<image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>-->
                                                                <?php } ?>
                                                                 <input hidden value="<?php echo isset($rowData['M']) ? $rowData['M'] : '' ?>" name="image5[]">
                                                               
                                                            </td>
                                                            <td >
                                                                <?php if (isset($rowData['N']) && $rowData['N'] != ''){ ?>
                                                                    <?php echo $rowData['N'] ?>
                                                                <?php } else{ ?>
                                                                    <!--<image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>-->
                                                                <?php } ?>
                                                                 <input hidden value="<?php echo isset($rowData['N']) ? $rowData['N'] : '' ?>" name="image6[]">
                                                               
                                                            </td>
                                                            <td >
                                                                <?php if (isset($rowData['O']) && $rowData['O'] != '') { ?>
                                                                    <?php echo $rowData['O'] ?>
                                                                <?php } else { ?>
                                                                    <!--<image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>backend/uploads/product/bulkImages/no-image-box.png" style="width:50%"/>-->
                                                                <?php } ?>
                                                                 <input hidden value="<?php echo isset($rowData['O']) ? $rowData['O'] : '' ?>" name="product_sub_attribute_new[]" id="product_sub_attribute_new">
                                                               
                                                            </td>
                                                            
                                                            
                                                            
                                                            
<!--                                                            


                                                            <?php
                                                            $flag = '0';
                                                            $options = '';
                                                            $j = 0;
                                                            ?>
                                                           
                                                            <?php foreach ($prodcut_cat_detail as $attr_data) { ?>
                                                                <?php $i = 'P'; ?>
                                                                <?php if (isset($attr_data['sub_attribute_details']))  ?>
                                                                <?php foreach ($attr_data['sub_attribute_details'] as $key=> $attr_sub_data) { ?>


                                                                    <?php if($attr_data['p_sub_category_id'] == $rowData['H']) {?>
                                                                    <?php 
                                                                   
                                                                    if ($attr_data['attribute_type'] == 0) { ?>
                                                                        <td width="">
                                                                            <?php
                                                                            echo form_input(array(
                                                                                'type' => 'text',
                                                                                'id' => 'id_tags_' . $attr_sub_data['id'],
                                                                                'name' => 'attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '[]',
                                                                                'placeholder' => $attr_sub_data['sub_name'],
                                                                                //'required' => 'required',
                                                                                'class' => 'tags form-control',
                                                                                'value' => set_value('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'], isset($rowData[$i]) ? $rowData[$i] : '')
                                                                            ));
//                                                                            echo isset($rowData[$i])?$rowData[$i]:'';
                                                                            ?>
                                                                        </td>
                                                                    <?php } else if ($flag == '0') {
                                                                        ?>

                                                                        <td width="">
                                                                            <?php
                                                                            $options = array();
//                                                                            echo '<pre>', print_r($attr_data['sub_attribute_details']);
                                                                            foreach ($attr_data['sub_attribute_details'] as $key => $val)
                                                                                $options[$val['id']] = $val['sub_name'];
                                                                            ?>

                                                                            <?php
                                                                            // 'required' => 'required'
                                                                            echo form_dropdown(array('id' => '', 'name' => 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '[]', 'class' => 'form-control'), $options, set_value('id', array_search($rowData['J'], $options)));
                                                                            ?>
                                                                        </td>

                                                                        <?php
                                                                        $flag = '1';
                                                                    }
                                                                    ?>

                                                                    <?php
                                                                    $i++;
                                                                    $j=$j+1;
                                                                }
                                                                ?>
                                                                <?php } } ?>
                                                            -->
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                   
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-12">
                                    <button type="submit" class=" pull-right btn btn-success ">Import Products</button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
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