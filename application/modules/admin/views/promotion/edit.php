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
                    <h2>Edit Promotion</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php 
                    echo form_open_multipart('admin/promotion/add_banner/'. $id, array('name' => 'form_add_promotions_edit','id' => 'form_add_promotions_edit', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>

                    <div class="form-group">
                        <?php echo form_label('Promotion Type', 'Promotion Type', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                            <select onchange="showCont(this.value)" class="form-control" name="type">
                                <option value="">Select</option>
                                <option value="0" <?php echo ($promotion[0]['type'] == '0') ? 'selected' : '' ?>>Image Banner</option>
                                <option value="1" <?php echo ($promotion[0]['type'] == '1') ? 'selected' : '' ?>>Html</option>
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?php echo form_label('Discount Type', 'Discount Type', array('for' => 'is_feature', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="discount_in">
                                <option value="0" <?php echo ($promotion[0]['discount_in'] == '0') ? 'selected' : '' ?>>In %</option>
                                <option value="1" <?php echo ($promotion[0]['discount_in'] == '1') ? 'selected' : '' ?>>Flat</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Discount', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="text" name="discount" value="<?php echo $promotion[0]['discount']; ?>"  class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="contentCont">
                        <div class="form-group">
                            <?php echo form_label('Content', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <textarea name="content" class="ckeditor" id="ckeditor"><?php echo $promotion[0]['content'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="bannerCont">
                        <div class="form-group">
                            <?php echo form_label('Banner Image', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                 <input  dir="ltr"  class="form-control" id="img_file" name="banner_image" type="file" accept="image/*" onchange="chkFile(this.value,'banner_image');">
                                    <?php if ($promotion[0]["banner_image"] != '') { ?>
                                        <input type="hidden" name="old_banner_image" id="old_img_file" value="<?php echo stripslashes($promotion[0]["banner_image"]); ?>">
                                        <br>
                                        <img width="100" height="100" src="<?php echo base_url(); ?>backend/uploads/promotional_banners/<?php echo stripslashes($promotion[0]["banner_image"]); ?>" id="front_image_tag_id" title="image" > 
                                    <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo form_label('From Date', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="text" name="from_date" id="single_cal4" value="<?php echo date("m/d/Y", strtotime($promotion[0]['from_date'])) ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('To Date', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="text" name="to_date" id="single_cal3" value="<?php echo date("m/d/Y", strtotime($promotion[0]['to_date'])) ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Display After (in second)', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <input type="number" name="display_after" value="<?php echo ($promotion[0]['display_after'] / 1000) ?>"  class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Status', 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <select class="form-control" name="status">
                                <option value="1" <?php echo ($promotion[0]['status'] == '1') ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?php echo ($promotion[0]['status'] == '0') ? 'selected' : '' ?>>Inactive</option>
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

                    <input type="hidden" name="promotion_id" id="promotion_id" value="<?php echo $promotion[0]['id']; ?>" />

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
//    $("#contentCont").hide();
    <?php if($promotion[0]["type"] == '0'){ ?>
    $("#bannerCont").show();
    $("#contentCont").hide();
    <?php } else{ ?>
        $("#contentCont").show();
         $("#bannerCont").hide();
    <?php }?>
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