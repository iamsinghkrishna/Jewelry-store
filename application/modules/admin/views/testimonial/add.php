
<link rel="stylesheet" href="<?php echo base_url(); ?>media/front/css/jquery-ui.css">
<aside class="right-side">
    <section class="content-header">
        <h3>
            <?php   echo (isset($edit_id) && $edit_id != "") ? "Update" : "Add New"; ?> Testimonial</li>    
        </h3>            
        <ol class="breadcrumb">
            <li> <a href="<?php echo base_url(); ?>admin/testimonial/list"><i class="fa fa-fw fa-retweet"></i> Manage Testimonials</a></li>
            <li class="active"><?php echo (isset($edit_id) && $edit_id != "") ? "Update" : "Add"; ?> Testimonial</li>

        </ol>
    </section>
    <?php// echo print_r($arr_testimonial[0]['name']);?>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <form name="frmTestimonials" id="frmTestimonials" action="<?php echo base_url(); ?>admin/testimonial/add" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="edit_id" value="<?php echo(isset($edit_id)) ? $edit_id : '' ?>">					 
                        <div class="box-body">
                            <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                ?>	
                                <div class="form-group">
                                    <label for="parametername">Language<sup class="mandatory">*</sup></label>
                                    <select class="form-control" name="lang_id" id="lang_id">
                                        <option value="">Select Language</option>
                                        <?php foreach ($arr_get_language as $languages) { ?>
                                            <option value="<?php echo $languages['lang_id'] ?>" <?php echo(isset($arr_testimonial[0]['lang_id']) && ($languages['lang_id'] == $arr_testimonial[0]['lang_id'])) ? 'selected' : ''; ?>><?php echo $languages['lang_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('lang_id'); ?>

                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="lang_id" id="lang_id" value="17" />
                            <?php } ?>	
                            <div class="form-group">
                                <label for="parametername">Name<sup class="mandatory">*</sup></label>
                                <input type="text" autofocus  class="form-control" name="inputName" value="<?php echo @$arr_testimonial[0]['name'] ?>"   />
                            </div>
                            <div class="form-group">
                                <label for="city_name">Suburb<sup class="mandatory">*</sup></label>
                                <input type="text" name="suburb" id="suburb_helpee" class="form-control" placeholder="Choose Suburb" value="<?php echo (isset($arr_testimonial[0]['suburb'])) ? stripslashes($arr_testimonial[0]['suburb']) : ''; ?>">
                            </div>    
                            <div class="form-group">
                                <label for="parametername">Description<sup class="mandatory">*</sup></label>
                                <textarea rows="6"  class="form-control" name="inputTestimonial"><?php echo (isset($arr_testimonial[0]['testimonial'])) ? stripslashes($arr_testimonial[0]['testimonial']) : ''; ?></textarea>
                            </div>
                            <?php if (@$arr_testimonial['image'] != '') { ?>
                                <div class="form-group">
                                    <label for="parametername">Image:</label>
                                    <div class="controls"> <img id="imageHolder" src="<?php echo base_url() ?>media/backend/img/testimonial_img/<?php echo @$arr_testimonial[0]['image'] ?>" width="150" height="150"> </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="parametername">Upload Image
                                    <?php if(!@$edit_id){?>
                                    <sup class="mandatory">*</sup>
                                    <?php }?>
                                </label>
                                <input type="file" dir="ltr"  class="" name="testi_image" id="testi_image" value="" size="80"  autocomplete="off">
                                <div id="img_div" style="display: none">
                                    <img id="imageHolder" src="" accesskey=" " width="150" height="150">
                                    <input type="hidden" name="old_testi_image" id="old_testi_image" value="<?php echo @$arr_testimonial[0]['image']; ?>">  
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="btnSubmit" class="btn btn-primary" id="btnSubmit" value="Save Changes">Save <?php echo (isset($edit_id) && $edit_id != "") ? "Changes" : ""; ?> </button>
                                <input type="hidden" name="edit_id" value="<?php echo @$edit_id; ?>">
                                <img src="<?php echo base_url(); ?>media/front/img/loader.gif" style="display: none;" id="loding_image">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    
        <script type="text/javascript">
            $(document).ready(function() {
                $("input[id*='suburb_helpee']").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "<?php echo base_url(); ?>admin/testimonial/get-suburbs-for-autocomplete",
                            type: 'POST',
                            dataType: "json",
                            data: {
                                suburb: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 3
                });
            });
        </script>  

        <script>
            $(document).ready(function()
            {
                $('#testi_image').change(function()
                {
                    var ext = $('#testi_image').val().split('.').pop().toLowerCase();
                    $('#loadingimg').show();
                    if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                        $('#testi_image').val('');
                        // extension is not allowed 
                        alert('Only JPG, PNG or GIF files are allowed');
                        $('#testi_image').val('');
                        return false;
                    }
                });
            });
        </script>



        <script type="text/javascript" language="javascript">
            if ($("#old_testi_image").val() == '') {
                $(document).ready(function() {
                    jQuery("#frmTestimonials").validate({
                        errorElement: 'label',
                        rules: {
                            lang_id: {
                                required: true
                            },
                            inputTestimonial: {
                                required: true,
                                minlength: 20
                            },
                            inputName: {
                                required: true
                            },
                            suburb: {
                                required: true
                            },
                            testi_image: {
                                required: true
                            }
                        },
                        messages: {
                            lang_id: {
                                required: "Please select language."
                            },
                            inputTestimonial: {
                                required: "Please enter testimonial description.",
                                minlength: "Please enter at least 20 characters."
                            },
                            inputName: {
                                required: "Please enter testimonial name."
                            },
                            suburb: {
                                required: "Please select suburb"
                            },
                            testi_image: {
                                required: "Please select image for upload"
                            }
                        },
                        submitHandler: function(form) {
                            $("#btnSubmit").hide();
                            $('#loding_image').show();
                            form.submit();
                        }

                    });

                });
            } else {
                $(document).ready(function() {
                    jQuery("#frmTestimonials").validate({
                        errorElement: 'label',
                        rules: {
                            lang_id: {
                                required: true
                            },
                            inputTestimonial: {
                                required: true,
                                minlength: 20
                            },
                            inputName: {
                                required: true
                            },
                            suburb: {
                                required: true
                            }
                        },
                        messages: {
                            lang_id: {
                                required: "Please select language."
                            },
                            inputTestimonial: {
                                required: "Please enter testimonial description.",
                                minlength: "Please enter at least 20 characters."
                            },
                            inputName: {
                                required: "Please enter testimonial name."
                            },
                            suburb: {
                                required: "Please select suburb"
                            }
                        },
                        submitHandler: function(form) {
                            $("#btnSubmit").hide();
                            $('#loding_image').show();
                            form.submit();
                        }

                    });

                });
            }
        </script>