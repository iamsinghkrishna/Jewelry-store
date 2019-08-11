<script src="<?php echo base_url(); ?>media/backend/js/ckeditor/ckeditor.js"></script>
<aside class="right-side">
    <section class="content-header">
<!--        <h1>
            Add Blog 
        </h1>            -->
        <ol class="breadcrumb">
          
            <li> <a href="<?php echo base_url(); ?>admin/blog"><i class="fa fa-fw fa-list"></i>  Manage Blogs</a>					 						  </li>
            <li>Add Blog</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <!--[message box]-->
                    <?php if ($this->session->userdata('msg') != '') { ?>
                        <div class="msg_box alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                            <?php echo $this->session->userdata('msg'); ?> </div>
                        <?php
                        $this->session->unset_userdata('msg');
                    }
                    if ($this->session->userdata('images_error') != '') {
                        ?>
                        <div class="msg_box alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                            <?php echo $this->session->userdata('images_error'); ?> </div>
                        <?php
                        $this->session->unset_userdata('images_error');
                    }
                    ?>

                    <form name="frmBlogPost" id="frmBlogPost" action="<?php echo base_url(); ?>admin/blog/add-post" method="post" enctype="multipart/form-data" >
                        <div class="box-body">
                            <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                ?>	
                                <div class="form-group">
                                    <label for="Language">Language<sup class="mandatory">*</sup></label>
                                    <select class="form-control" name="lang_id" id="lang_id">
                                        <option value="">Select Language</option>
                                        <?php foreach ($arr_get_language as $languages) { ?>
                                            <option value="<?php echo $languages['lang_id'] ?>" ><?php echo $languages['lang_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="lang_id" id="lang_id" value="17" />
                            <?php } ?>	
                            <div class="form-group">
                                <label for="parametername">Post Title<sup class="mandatory">*</sup></label>
                                <input type="text" dir="ltr"  class="form-control" name="inputName" id="inputName" value=""  />
                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Short Description<sup class="mandatory">*</sup></label>
                                <textarea type="text" dir="ltr"  name="inputPostShortDescription" class="form-control"  ></textarea>
                            </div>

                            <div class="form-group">
                                <label for="parametername">Post Description<sup class="mandatory">*</sup></label>
                                <textarea type="text" dir="ltr"  class="form-control" id="inputPostDescription" name="inputPostDescription" ></textarea>
                                <div class="error hidden" id="labelProductError">Please enter post description</div>
                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Page Title<sup class="mandatory">*</sup></label>
                                <textarea type="text" dir="ltr"  class="form-control" name="inputPostPageTitle" ></textarea>

                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Tags</label>
                                <textarea type="text" dir="ltr"  class="form-control" id="inputPostTags" name="inputPostTags" ></textarea>

                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Keywords</label>
                                <textarea type="text" dir="ltr"  class="form-control" id="inputPostKeywords" name="inputPostKeywords" ></textarea>

                            </div>
                                <div class="form-group">
                        <?php echo form_label(lang('category'), 'category', array('for' => 'category')); ?>
                        
                            <?php
                            echo form_dropdown(array(
                                'id' => 'product_category',
                                'name' => 'category',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                    ), $product_category
                            );
                            ?>
                       
                    </div>
                            <div class="form-group">
                                <label for="city_name">Suburb<sup class="mandatory">*</sup></label>
                                <input type="text" name="search_location" id="search_location" class="form-control" placeholder="Choose Suburb" value="<?php echo (isset($arr_testimonial['suburb'])) ? stripslashes($arr_testimonial['suburb']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="city_name">Helpers<sup class="mandatory">*</sup></label>
                                <select id="helper" name="helper" class="form-control">
                                    <option value="1">hepere</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city_name">Blog Video</label>
                                <input type="text" class="form-control" name="blog_video" id="blog_video" value="<?php echo $post_info['video_link'] ?>"/>                                            
                            </div>
                            <small class="controls">http://www.youtube.com/embed/XGSy3_Czz8k</small>
                            <div class="form-group">
                                <label for="parametername">Publish Status</label>
                                <select class="form-control" name="inputPublishStatus" class="">
                                    <option value="1">Published</option>
                                    <option value="0">Unpublished</option>
                                    <option value="2">Removed (Make Abused)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="parametername">Blog Images</label>
                                <input type="file" dir="ltr"  class="" name="blog_image" id="blog_image" value="" size="80"  autocomplete="off"  />
                                <div id="img_div" style="display: none"><img id="imageHolder" src=""accesskey=" " width="150" height="150">

                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes" id="btnSubmit">Save</button>
                            <img src="<?php echo base_url(); ?>media/front/img/loader.gif" style="display: none;" id="loding_image">
                        </div>
                    </form>
                </div>
            </div>
            <!--[sortable body]--> 
        </div>
        </div>
        <!--[sortable table end]--> 
        <!--[include footer]--> 
        </div>
        </div>

        <!--including footer here-->
        
         <link rel="stylesheet" href="<?php echo base_url(); ?>media/backend/css/jquery-ui.min.css" />
         <script src="<?php echo base_url(); ?>media/backend/js/jquery-ui.js"></script>
        </div>
        <script>
            (function($) {
                $.fn.checkFileType = function(options) {
                    var defaults = {
                        allowedExtensions: [],
                        success: function() {
                        },
                        error: function() {
                        }
                    };
                    options = $.extend(defaults, options);

                    return this.each(function() {

                        $(this).on('change', function() {
                            var value = $(this).val(),
                                    file = value.toLowerCase(),
                                    extension = file.substring(file.lastIndexOf('.') + 1);

                            if ($.inArray(extension, options.allowedExtensions) == -1) {
                                options.error();
                                $(this).focus();
                            } else {
                                options.success();

                            }

                        });

                    });
                };

            })(jQuery);

            $(function() {
                $('#blog_image').checkFileType({
                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    error: function() {
                        $('#blog_image').replaceWith($('#blog_image').val('').clone(true));
                        alert('Please upload only jpg,jpeg,png,gif type file.');
                    }

                });

            });
        </script> 
        <script type="text/javascript">
            var _URL = window.URL || window.webkitURL;
            $("#blog_image").change(function(e) {
                var file, img;
                var width = 795;
                var height = 400;
                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function() {
                        if (this.width > width && this.height > height) {
                            $('#blog_image').replaceWith($('#blog_image').val('').clone(true));
                            alert("Please upload image of " + width + "px width and " + height + "px height or smaller");
                        } else {

                            var input = document.getElementById('blog_image');
                            readURL(input);
                        }

                    };
                    img.src = _URL.createObjectURL(file);
                }
            });
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#img_div").show();
                        $('#imageHolder').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            jQuery(document).ready(function() {
                
                $("#search_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                 url: "<?php echo base_url().'get-area-name'?>" ,
                type: 'POST',
                dataType: "json",
                data: {
                   search_val: $("#search_location").val(),
                },
                success: function(data) {
                   // response(data);

                   if (data.length > 0) {
                response($.map(data, function(item) {
                    return {
                        label: item.suburb_name,
                        id: item.suburb_id,
                        lat:item.lat,
                        long:item.long
                    }
                }))
            } else {
                var data = [
                    {
                        label: 'No matching locations found.',
                        value: ''
                    }
                ];
                response(data);
            }

                }
            });
        },
        minLength: 1
    });

                jQuery("#frmBlogPost").validate({
                    errorElement: 'div',
                    rules: {
                        inputName: {
                            required: true,
                            minlength: 3
                        },
                        inputPostShortDescription: {
                            required: true
                        },
                        inputPostPageTitle: {
                            required: true
                        },
                        lang_id: {
                            required: true
                        },
                        search_location:{
                              required: true
                        },
                        inputPageUrl: {
                            required: true,
                            minlength: 3//,
                                    //remote: {url: "<?php echo base_url(); ?>backend/blog/validate-page-url", data: {type: "blog-post", edit_id: ""}, method: "post"}
                        }
                    },
                    messages: {
                        inputName: {
                            required: "Please enter title for blog post",
                            minlength: "Please enter at least 3 characters"
                        },
                        inputPostShortDescription: {
                            required: "Please enter post content."
                        },
                        inputPostPageTitle: {
                            required: "Please enter title for page."
                        },
                        lang_id: {
                            required: "Please select language."
                        },
                        search_location: {
                            required: "Please select suburb."
                        },
                        inputPageUrl: {
                            required: "Please enter url for the page",
                            minlength: "Please enter atleast 3 characters",
                            remote: "Sorry, this url is already exists. Please try another url"
                        }
                    },
                    submitHandler: function(form) {
                        if ((jQuery.trim(jQuery("#cke_1_contents iframe").contents().find("body").html())).length < 12)
                        {
                            jQuery("#labelProductError").removeClass("hidden");
                            jQuery("#labelProductError").show();
                        }
                        else {
                            jQuery("#labelProductError").addClass("hidden");
                            $("#btnSubmit").hide();
                            $('#loding_image').show();
                            form.submit();

                        }
                    }
                });
                CKEDITOR.replace('inputPostDescription',
                        {
                            filebrowserUploadUrl: '<?php echo base_url(); ?>upload-image'
                        });
            });
        </script>
