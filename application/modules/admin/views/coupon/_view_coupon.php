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
                    <h2>Coupon</h2>
                    <a href="<?php echo base_url(); ?>admin/add_coupon" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Coupon</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    	<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
<p>
				<?php if ($discount_type == 'summary') { ?>
					<a href="<?php echo base_url(); ?>admin_library/item_discounts">Manage Item Discounts</a> | 
				<?php } else { ?>
<!--                                        <a href="<?php echo base_url(); ?>admin_library/summary_discounts">Manage Summary Discounts</a> | -->
				<?php } ?>
<!--					<a href="<?php echo base_url(); ?>admin_library/discount_groups">Manage Item Discount Groups</a> | 
					<a href="<?php echo base_url(); ?>admin_library/insert_discount">Insert New Discount</a>
				</p>-->
			<?php echo form_open(current_url());?>						
				<h1><?php //echo ($discount_type == 'item') ? 'Item' : 'Summary';?> </h1>
				
                    <div class="table-responsive">
                        <table id="product_datatable1" class="table table-hover" cellspacing="0" width="100%">
                           
					 <thead>
						<tr>
                                                        <th>
								Coupon Code
							</th>
							
							<th>
								Description
							</th>
							<th >
								Usage Limit
							</th>
							<th >
								Valid Date
							</th>
							<th >
								Expire Date
							</th>
<!--							<th>
								Status
							</th>-->
							<th>
								Delete
							</th>
                                                        <th >
								Action
							</th>
                                                        <th >
								Action
							</th>
<!--                                                        <th >
								Action
							</th>-->
						</tr>
                                                                </thead>
                                                              <tbody>
				<?php if (! empty($discount_data)) { ?>	
					
					<?php //echo '<pre>';print_r($discount_data);die;
						foreach ($discount_data as $row) {
							$discount_id = $row[$this->flexi_cart_admin->db_column('discounts', 'id')];
					?>
						<tr>
                                                        <td>
								<?php echo $row['disc_code']; ?>
							</td>
							
							<td>
								<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'description')]; ?>
							</td>
							<td >
								<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')]; ?>
							</td>
							<td >
								<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'valid_date')])); ?>
							</td>
							<td >
								<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'expire_date')])); ?>
							</td>
<!--							<td >
								<?php //$status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
								<input type="hidden" name="update[<?php echo $discount_id; ?>][status]" value="0"/>
								<input type="checkbox" name="update[<?php echo $discount_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$discount_id.'][status]','1', $status); ?>/>
							</td>-->
							<td >
								<input type="hidden" name="update[<?php echo $discount_id; ?>][delete]" value="0"/>
								<input type="checkbox" name="update[<?php echo $discount_id; ?>][delete]" value="1"/>
							</td>
                                                        <td>
								<input type="hidden" name="update[<?php echo $discount_id; ?>][id]" value="<?php echo $discount_id; ?>"/>
                                                                <a class="btn btn-info" href="<?php echo base_url(); ?>admin_library/update_discount/<?php echo $discount_id; ?>">Edit</a>
							</td>
<!--                                                        <td>
								<input type="submit" name="update_discounts" value="Update" class="link_button large btn btn-primary"/>
							</td>-->
                                                        <td >
								<input type="submit" name="update_discounts" value="Delete" class="link_button large btn btn-danger"/>
							</td>
                                                        
						</tr>
					<?php } ?>
                                           </tbody>    
					

				<?php } else { ?>
					<tbody>
<!--						<tr>
							<td colspan="7">
								There are no discounts setup to view.<br/>
                                                                <a href="<?php echo base_url(); ?>admin_library/insert_discount">Insert New Discount</a>
							</td>
						</tr>-->
					</tbody>
				<?php } ?>
				
                            <?php echo form_close();?>
                            
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>     
</div>



<script type="text/javascript">
    $(document).ready(function () {
        $('#product_datatable1').DataTable({
            "pageLength": 50,
            "order": [[ 0, "ASC" ]]
           
        });
    });
</script>