        
<style>
    .danger, .mandatory {
        color: #BD4247;
    }
    .alert{
        padding:8px 0px;
    }
</style> 
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<!-- page content -->
<div class="right_col" role="main"> <!-- top tiles -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Newsletter</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form name="frm_add_newsletter" class="form-horizontal form-label-left" id="frm_add_newsletter" action="<?php echo base_url(); ?>admin/newsletter/add" method="post" >

                        <div class="item form-group">
                            <label for="parametername" class="control-label col-md-3 col-sm-3 col-xs-12">Title<sup class="mandatory">*</sup></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text"   class="form-control col-md-7 col-xs-12" name="input_subject" id="input_subject" required  value=""/>
                                <?php echo form_error('input_subject'); ?> 
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="input_content" class="control-label col-md-3 col-sm-3 col-xs-12">Content<sup class="mandatory">*</sup></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="form-control col-md-7 col-xs-12" id="input_content" name="input_content" required></textarea>
                                <div class="error hidden" id="labelProductError" name="labelProductError">Please enter post description</div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" name="submit_button" id="btnSubmit" class="btn btn-primary" value="Save" id="submit_button">Save</button>
                            <button type="reset" name="cancel" class="btn" onClick="window.top.location = '<?php echo base_url(); ?>backend/newsletter/list';">Cancel</button>
                            <img src="<?php echo base_url(); ?>media/front/img/loader.gif" style="display: none;" id="loding_image">
                        </div>             
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of weather widget -->
</div>
</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('#btn_cancel').click(function () {
            window.location = "<?php echo base_url(); ?>backend/newsletter/list";
        });

        

        CKEDITOR.replace('input_content',
                {
                    filebrowserUploadUrl: '<?php echo base_url(); ?>upload-image'
                });
    });
</script>
<!-- /page content -->