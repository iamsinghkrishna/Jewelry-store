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
                    <h2>Products</h2>
                    <!-- <a href="<?php echo base_url(); ?>admin/product/addcsv" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-file-excel-o" ></i> Import Product</a> -->
                    <!-- <a href="<?php echo base_url(); ?>admin/productVariantsUpload" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-file-excel-o" ></i> Import Product Variants</a> -->
                    <a href="<?php echo base_url(); ?>admin/product/add" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Product</a>
                    <a href="<?php echo base_url(); ?>admin/inventory/clover-products" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-file-excel-o" ></i> Clover Product</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div class="table-responsive">
                        <form name="frm_list_products" id="frm_list_products" action="<?php echo base_url(); ?>admin/product" method="post">
                        <table id="product_datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Select</td>
                                    <td>Product Name</td>
                                    <td>Category</td>
                                   
                                    <td>Quantity</td>
                                    <td>Price</td>
                                    <!--<td>Description</td>-->
                                    <td>SKU</td>
                                    <td>Clover ID</td>
                                    <td>Shipping Region</td>
                                    <td>Back Order?</td>
                                    <td>Status</td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  if (isset($product_details))  ?>
                                <?php foreach ($product_details as $productData) { ?>
                                    <tr>
                                        <td>
                                        <center>
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $productData['id']; ?>" />
                                        </center>
                                        </td>
                                        <td width="">
                                            <p>
                                                <?php if (isset($productData['product_images_details']) && !empty($attribute_details['product_images_details']))  ?>
                                                <?php foreach ($productData['product_images_details'] as $imgData) {
                                                    if($imgData['url'] != ''){
                                                    ?>
                                                    <image onerror="<?php echo base_url() .'backend/images/product_not_found_image.png'; ?>" class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() . $imgData['url']; ?>"/>
                                                        <?php 
                                                        
                                                        }} ?>
                                            </p>
                                            <p><?php echo $productData['product_name']; ?></p>
                                        </td>
                                        <td><?php 
                                           // echo '<pre>';print_R($productData['arr_category']);
                                            if(count($productData['arr_category']) > 0){
                                                foreach($productData['arr_category'] as $category){
                                                    foreach($category as $key=> $data){
                                                        echo $data['name'].'<br/>';
                                                    }
                                                   // echo 'hi'.'<pre>';print_r($category);die;
                                                }
                                            }
                                            
                                            ?></td>
                                       
                                        <td><?php echo isset($productData['quantity']) ? $productData['quantity'] : $productData['quantity']; ?></td>
                                        <td><?php echo isset($productData['price']) ? $productData['price'] : $productData['price']; ?></td>
                                        <!--<td><?php // echo $productData['description'];                 ?></td>-->
                                        <td><?php echo isset($productData['product_sku']) ? $productData['product_sku'] : ''; ?></td>
                                        <td><?php echo isset($productData['clover_id']) ? $productData['clover_id'] : ''; ?></td>
                                        <td><?php echo isset($productData['shipping_region']) ? $productData['shipping_region'] : ''; ?></td>
                                        <td><?php echo $productData['back_order_flag'] == 'yes' ? 'Yes' : 'No' ?></td>
                                        <td>
                                            <div id="active_div<?php echo $productData['id']; ?>"  <?php if ($productData['isactive'] == 0) { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>">
                                            <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $productData['id']; ?>', 1);" href="javascript:void(0);" id="status_<?php echo $productData['id']; ?>"><?php echo 'Active'; ?></a>
                                        </div>

                                        <div id="blocked_div<?php echo $productData['id']; ?>" <?php if ($productData['isactive'] == 1) { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?> >

                                            <a class="label label-danger" title="Click to Change Status" onClick="changeStatus('<?php echo $productData['id']; ?>', 0);" href="javascript:void(0);" id="status_<?php echo $productData['id']; ?>"><?php echo 'Blocked'; ?></a>
                                        </div>
                                            
                                        </td>
                                        
                                        <td><a class="btn btn-xs btn-default btn-round" href="<?php echo base_url(); ?>admin/product/edit/<?php echo $productData['id']; ?>"><i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                <?php } ?>
                                     <?php if (count($product_details) > 0) { ?>
                                       <tfoot>
                                    <tr>
                                        <th colspan="9">
                                            <input style="width:133px !important;" type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value="Delete Selected">
                                            <!--<a id="add_new_user" name="add_new_subject" href="<?php echo base_url(); ?>backend/subject/add" class="btn btn-primary pull-right" >Add New Subject </a>-->
                                        </th>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                            </tbody>
                        </table>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>     
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#product_datatable').DataTable({
            dom: 'Bfrtip',
           // buttons: ['csv', 'excel', 'pdf', 'print'],
             buttons: [
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
                     columns: [1,2,3,4,5,6]
                 }
            },
            {
                extend: 'excel',
                footer: false,
                 exportOptions: {
                     columns: [1,2,3,4,5,6]
                 }

            },
            {
                extend: 'pdf',
                footer: false,
                 exportOptions: {
                     columns: [1,2,3,4,5,6]
                 }
            },
            {
                extend: 'print',
                footer: false,
                exportOptions:{
                     columns: [1,2,3,4,5,6]
                }
            }, 
    ]  
        });
    });
</script>

<script>
//    $(document).ready(function (){
//        $("#product_datatable").dataTable();
//        
//        //ordering: false,
//   //"bSort" : false
//    });
    
    
    function changeStatus(id, isactive)
            {
                /* changing the user status*/
                var obj_params = new Object();
                obj_params.id = id;
                obj_params.isactive = isactive;
                jQuery.post("<?php echo base_url(); ?>admin/changeStatus", obj_params, function(msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                    }
                    else
                    {
                        /* toogling the bloked and active div of user*/
                        if (isactive == 1)
                        {
                            $("#blocked_div" + id).css('display', 'inline-block');
                            $("#active_div" + id).css('display', 'none');
                        }
                        else
                        {
                            $("#active_div" + id).css('display', 'inline-block');
                            $("#blocked_div" + id).css('display', 'none');
                        }
                    }

                }, "json");

            }
</script>