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
                    <h2>Product Variants</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url(); ?>admin/productVariantsUpload" method="post" enctype="multipart/form-data" name="uploadCSV" id="uploadCSV"> 

                        <div class="clearfix"></div>

                        <br>
                        <div class="form-group">
                            <?php echo form_label(lang('product_csv'), 'product_csv', array('for' => 'product_csv', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <table>
                                    
                                    <tr>

                                        <td>
                                            <input type="file" class="form-control" name="userfile" id="userfile"  align="center" onchange="chkFileCSV(this.value,'userfile')" />
                                            <p class="text-danger"><?php echo $this->session->flashdata('msg'); ?></p>
                                        </td>
                                        <td>
                                            <div class="col-lg-offset-3 col-lg-9" style="margin-top:-15px !important;">
                                              <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                                              <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-info" value="Upload CSV File"/>
                          
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
                            <form action="<?php echo site_url(); ?>admin/addProductVariants" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
                                <input hidden="" value="<?php echo count($excel_row_data) ?>" name="csv_data_count">

                                <?php echo form_label(lang('csv_data'), 'csv_data', array('for' => 'csv_data', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                <button type="submit" class=" pull-right btn btn-success ">Import (<?php echo count($excel_row_data)?>) Product Variants</button>
                                <div class="col-sm-12">
                                 <div id="responsive_table" class="table-responsive">
                                        <table class="table" id="">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    foreach ($excel_row as $rowtitle) {
                                                        ?>
                                                        <?php foreach ($rowtitle as $t) { ?>
                                                            <th >
                                                                <?php echo $t ?>
                                                            </th>
                                                            <?php
                                                        }
                                                        ?>
                                                    <?php } ?>
   
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php if (!empty($excel_row_data)) { ?>
                                                    <?php foreach ($excel_row_data as $rowData) { ?>

                                                        <tr>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_name',
                                                                    'name' => 'product_name[]',
                                                                    'placeholder' => 'Product Name',
                                                                    'class' => 'form-control',
                                                                    //'readonly' => 'readonly',
                                                                    'required' => 'required',
                                                                    'value' => set_value('A', $rowData['A'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'size',
                                                                   // 'readonly' => 'readonly',
                                                                    'name' => 'size[]',
                                                                    'placeholder' => 'Size',
                                                                    'class' => 'form-control',
                                                                   // 'required' => 'required',
                                                                    'value' => set_value('B', $rowData['B'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'length',
                                                                    'name' => 'length[]',
                                                                    //'readonly' => 'readonly',
                                                                    'placeholder' => 'Length',
                                                                    'class' => 'form-control',
                                                                    //'required' => 'required',
                                                                    'value' => set_value('C', $rowData['C'])
                                                                ));
                                                                ?>
                                                            </td>

                                                          
                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'carat',
                                                                    'name' => 'carat[]',
                                                                    'placeholder' => 'Carat',
                                                                    'class' => 'form-control',
                                                                    //'required' => 'required',
                                                                    'value' => set_value('D', $rowData['D'])
                                                                ));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                   
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-12">
                                    <button type="submit" class=" pull-right btn btn-success ">Import Product Variants</button>
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

        $("#product_datatable_csv").dataTable();
        
        setInterval(function(){ 
            $( "#responsive_table" ).addClass( "table-responsive" );
        
        }, 1000);
    });
</script>