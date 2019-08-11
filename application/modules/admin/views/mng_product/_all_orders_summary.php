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
                    <h2>All Orders</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php if (isset($all_orders) && !empty($all_orders)) { ?>

                        <?php // if (isset($cart_items) && !empty($cart_items)) {    ?>
                        <div class="table-responsive">    


                            <?php
//                        echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
                            ?>
                            <table class="table table-hover cartTable" id="product_datatable">
                                <thead>
                                    <tr>
                                        <th >Order ID</th>
                                        <th>Product Name</th>
                                        <th >Quantity</th>
                                        <!--<th class="text-center" width="100">Unit Price</th>-->
                                        <th >Summary Total</th>
                                        <th >Total Discount</th>
                                         <th >Total Amount</th>
                                        <th >Order Date</th>
                                        <th >Order Status</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach ($all_orders as $sid => $odata) {
                                        if($odata['ord_order_number'] != ''){
                                        ?>
                                        <tr>
                 
                                            <td>
                                                <a href="<?php echo base_url() ?>admin_library/all_order_details/<?php echo $odata['ord_order_number']; ?>">
                                                    #<?php echo $odata['ord_order_number'] ?>
                                                </a>
                                            </td>
                                             <td><?php echo ($odata['product_name']) ?></td>
                                             <td><?php echo ($odata['ord_total_rows']) ?></td>
                                            <td>$<?php echo ($odata['ord_item_summary_total']) ?></td>
                                            <td>$<?php echo ($odata['ord_summary_savings_total']) ?></td>
                                             <td>$<?php echo ($odata['ord_total']) ?></td>
                                            <td>
                                                <p><?php echo date('d F y', strtotime($odata['ord_date'])); ?>
                                                    <?php echo date('H:i A', strtotime($odata['ord_date'])); ?></p>
                                            </td>
                                            <td>
                                                
                                                <?php
                                                    $prebook = (unserialize($odata['ord_det_item_option']));
                                                    //print_r($prebook);
                                                    if(count($prebook) > 0 && $prebook['Prebook'] == 'true'){
                                                        $advance = ' ( Advance order )';
                                                    }else{
                                                       $advance = ''; 
                                                    }
                                                ?>
                                                <p id="updatedStatsu<?php echo $odata['ord_order_number'];?>"><?php if($odata['ord_status'] == '1')
                                                    echo '<button type="button" class="btn btn-warning btn-xs">Awaiting Payment '.$advance.'</button>';
                                                elseif($odata['ord_status'] == '2')
                                                    echo '<button type="button" class="btn btn-success btn-xs">New Order '.$advance.'</button>'; 
                                                elseif($odata['ord_status'] == '3')
                                                    echo '<button type="button" class="btn btn-warning btn-xs">In Process '.$advance.'</button>';
                                                elseif($odata['ord_status'] == '7')
                                                    echo '<button type="button" class="btn btn-info btn-xs">Shipped '.$advance.'</button>';
                                                elseif($odata['ord_status'] == '4')
                                                    echo '<button type="button" class="btn btn-dark btn-xs">Completed '.$advance.'</button>';
                                                elseif($odata['ord_status'] == '5')
                                                    echo '<button type="button" class="btn btn-danger btn-xs">Cancelled '.$advance.'</button>';
                                                else 
                                                    echo '<button type="button" class="btn btn-success btn-xs">Advance Order</button>'; ?>
                                                </p>
                                                <p><select onchange="changeOrderStatus(this.value,'<?php echo $odata['ord_order_number']?>')" class="form-control">
                                                        <option value="">Change Status</option>
                                                        <?php // if($odata['ord_status'] == 5 || $odata['ord_status'] == 4){
//                                                            $disable = "disabled";
//                                                        }else {
//                                                            $disable="";
//                                                        } ?>
                                                        <option <?php echo $disable;?> value="3">Process</option>
                                                        <option <?php echo $disable;?> value="7">Shipped</option> 
                                                        <option <?php echo $disable;?> value="5">Cancel</option>
                                                        <option <?php echo $disable;?> value="4">Complete</option>
                                                    </select>
                                                </p>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                </tbody>
                            </table>

                            <?php // echo form_close();    ?>

                        </div>
                    <?php } else { ?>
                        <div class="text-center">
                            <p><i class="fa fa-5x fa-shopping-cart text-danger"></i></p>
                            <p>No order placed.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#product_datatable').DataTable({
             "order": [],
            dom: 'Bfrtip',
           // buttons: ['csv', 'excel', 'pdf', 'print'],
             buttons: [
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
                     columns: [0,1,2,3,4,5,6]
                 }
            },
            {
                extend: 'excel',
                footer: false,
                 exportOptions: {
                     columns: [0,1,2,3,4,5,6]
                 }

            },
            {
                extend: 'pdf',
                footer: false,
                 exportOptions: {
                     columns: [0,1,2,3,4,5,6]
                 }
            },
            {
                extend: 'print',
                footer: false,
                exportOptions:{
                     columns: [0,1,2,3,4,5,6]
                }
            }, 
    ]  
        });
        
        
        
    });
    function changeOrderStatus(status,orderid){
           $.ajax(
                {
                    method: "POST",
                    dataType: 'JSON',
                    data: {'order_id': orderid, 'ord_status': status},
                    url: "<?php echo base_url(); ?>admin/changeOrderStatus",
                    success: function (response)
                    {
                        if (response.status === '1') {
                            $('#updatedStatsu'+orderid).html(response.order_status);
                            location.reload();
                        } else {
                            alert("Something went wrong. Please try again later");
                        }
                    }
                }
        );
    }
</script>