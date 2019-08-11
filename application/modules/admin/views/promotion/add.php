<?php
// echo '<pre>', print_r($product_details);
//die() 
?>
<?php $ischeck = ''; ?>
<?php $val = ''; ?>
<script src="<?php echo base_url() ?>media/backend/ckeditor/ckeditor.js"></script>
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
                    <h2>Add Promotion</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    echo form_open_multipart('admin/promotion/add_banner', array('name' => 'form_add_promotions','id' => 'form_add_promotions', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>

                    <div class="form-group">
                        <?php echo form_label('Promotion Type', 'Promotion Type', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                            <select onchange="showCont(this.value)" class="form-control" name="type" id="type">
                                <option value="">Select</option>
                                <option value="0">Image Banner</option>
                                <option value="1">Html</option>
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?php echo form_label('Discount Type', 'Discount Type', array('for' => 'is_feature', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="discount_in" id="discount_in">
                                <option value="0">In %</option>
                                <option value="1">Flat</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Discount', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="text" name="discount"  class="form-control" id="discount">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="contentCont">
                        <div class="form-group">
                            <?php echo form_label('Content', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <textarea name="content" class="ckeditor" id="ckeditor"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="bannerCont">
                        <div class="form-group">
                            <?php echo form_label('Banner Image', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <input type="file" name="banner_image" class="form-control" id="banner_image" onchange="chkFile(this.value,'banner_image');">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo form_label('From Date', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="text" name="from_date" id="single_cal4" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('To Date', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="text" name="to_date" id="single_cal3" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Display After (in second)', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="number" name="display_after"  class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Status', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                            <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-success " />
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <a href="<?php echo base_url(); ?>admin/promotion/lists" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>



                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
    $("#contentCont").hide();
    $("#bannerCont").hide();
    function showCont(val) {
//        alert(val);
        if (val === '0') {
            $("#bannerCont").show();
            $("#contentCont").hide();
        }
        if (val === '1') {
            $("#contentCont").show();
            $("#bannerCont").hide();
        }
    }

</script>