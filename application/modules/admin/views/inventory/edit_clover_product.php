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
                    <?php
                    echo form_open_multipart('admin/inventory/edit-clover-product/'.$product_id, array('id' => 'form_add_product', 'name' => 'form_add_product', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>

                    <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_name',
                                'placeholder' => 'Product Name',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => $result['name']
                            ));
                            ?>
                        </div>
                    </div>
<div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Code*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_code',
                                'placeholder' => 'Product Code',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => $result['code']
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Price*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_price',
                                'placeholder' => 'Product Price',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => $result['price'] /100
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price Type*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="price_type" class="form-control">
                                <option value="FIXED" <?php if($result['priceType'] == 'FIXED') echo "selected";?>>FIXED</option>
                                <option <?php if($result['priceType'] == 'VARIABLE') echo "selected";?> value="VARIABLE">VARIABLE</option>
                                <option <?php if($result['priceType'] == 'PER ITEM') echo "selected";?> value="PER ITEM">PER ITEM</option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Cost*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_cost',
                                'placeholder' => 'Product Cost',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => $result['cost'] /100
                            ));
                            ?>
                        </div>
                    </div>

                   
                   
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Category*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="<?php if(count($categories['elements']) > 6) { echo 'height:150px;overflow:auto'; }?>">
                            
                                <?php
                                $ccc = array();

                                foreach($result['categories']['elements'] as $cc){
                                    array_push($ccc,$cc['id']);
                                }
                                 foreach($categories['elements'] as $cat){

                                    if(in_array($cat['id'],$ccc)){
                                        $selected = "checked";
                                    }else{
                                        $selected = "";
                                    }
                                    echo "<input ".$selected." type='checkbox' name='category[]' value='".$cat['id']."@".$cat['name']."' />  ".$cat['name'] ."</br>";
                                }
                                ?>                            
                        </div>
                    </div>

                     <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Stock*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'quantity',
                                'placeholder' => 'Product Stock',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => $result['itemStock']['quantity']
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product SKU*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'sku',
                                'placeholder' => 'Product Name',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => $result['sku']
                            ));
                            ?>
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

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>
