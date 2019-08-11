
<aside class="right-side">

    <section class="content">
       
        <div class="row">
            <div class="col-xs-12">
                 <?php
        $msg = $this->session->flashdata('msg');
        $msg_error = $this->session->flashdata('msg_error');
        ?>
        <?php if ($msg != '') { ?>
            <div class="msg_box alert alert-success">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg;
                ?>
            </div>
        <?php } ?>
        <?php if ($msg_error != '') { ?>
            <div class="msg_box alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg_error;
                ?>
            </div>
        <?php } ?>
                <div class="x_title">
                    <h2> Weekly Report</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="">
                    <div class="box-body table-responsive">
                        <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">	
                            
                            <form name="frmtestimonials" id="frmtestimonials" action="<?php echo base_url(); ?>admin/inventory/weekly_inventory" method="get">					
                            <div class="row">
                                <div class="col-md-3"><input type="text" value="<?php if(isset($_GET['dateFilter'])) echo $this->input->get('dateFilter')?>" id="reservation" class="form-control" name="dateFilter"></div>
                                <div class="col-md-3"><input type="submit" name="" class="btn btn-success" value="Submit">
<a href="<?php echo base_url('admin/inventory/weekly_inventory')?>" class="btn btn-success" >Reset</a>
                                </div>
                                <p><?php echo (isset($_GET['dateFilter'])) ? "Records from <strong>".$start_date ."</strong> to <strong>".$end_date ."</strong>" : "Showing last week's records (starting from Sunday)";?></p>
                            </div>			
                                <table class="table table-bordered table-striped dataTable" id="table-buttons" aria-describedby="example1_info" id="table-responsive" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th> </th>
                                    <th class="sorting_asc">Product Name</th>
                                    <th class="sorting_asc">Sold Quantity</th>
                                    <th class="sorting_asc">Order No</th>
                                    <th class="sorting_asc" >Date </th>
                                    <th class="sorting_asc" >Source</th>       
                                    <th class="sorting_asc" >Current Stock</th>       
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sr=1;
                                        if(!empty($inventory_data)){
                                        foreach ($inventory_data as $inventory_data) {
                                            ?>
                                            <tr>
                                                <td ><?php echo $sr++;?></td>
                                        <td><?php echo $inventory_data['ord_det_item_name']; ?></td>
                                        <td><?php echo ceil($inventory_data['ord_det_quantity']); ?></td>
                                        <td><?php echo $inventory_data['ord_order_number']; ?></td>
                                        <td><?php echo $inventory_data['ord_date']; ?></td>
                                        <td>Website</td>
                                        <td><?php echo $inventory_data['quantity']; ?></td>


                                        <?php
                                    }
                                }else{
                                    echo "<tr><td style='text-align:center' colspan='7'>No records found for this date</td></tr>";
                                }
                                    ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

        </div>
        
        </body>
        </html>