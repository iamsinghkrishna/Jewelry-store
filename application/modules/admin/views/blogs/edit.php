
<script src="<?php echo base_url(); ?>media/backend/js/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>media/front/css/jquery-ui.css">
<aside class="right-side">
    <section class="content-header">

<!--        <h1>
            Edit Blog 
        </h1>            -->
        <ol class="breadcrumb">
           
            <li> <a href="<?php echo base_url(); ?>admin/blog"><i class="fa fa-fw fa-list"></i> Manage Blogs</a></li>
            <li>Edit Blog</li>

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

                    <form name="frmBlogPost"  id="frmBlogPost" action="<?php echo base_url(); ?>admin/blog/add-post" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                ?>
                                <div class="form-group">
                                    <label for="Language">Language<sup class="mandatory">*</sup></label>
                                    <select class="form-control" name="lang_id" id="lang_id">
                                        <option value="">Select Language</option>
                                        <?php foreach ($arr_get_language as $languages) { ?>
                                            <option value="<?php echo $languages['lang_id'] ?>" <?php echo(isset($post_info['lang_id']) && ($languages['lang_id'] == $post_info['lang_id'])) ? 'selected' : ''; ?>><?php echo $languages['lang_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="lang_id" id="lang_id" value="17" />
                            <?php } ?>	
                            <div class="form-group">
                                <label for="parametername">Post Title<sup class="mandatory">*</sup></label>
                                <input type="text" dir="ltr"  class="form-control" name="inputName" id="inputName" value="<?php echo $post_info['post_title']; ?>"  />
                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Short Description<sup class="mandatory">*</sup></label>
                                <textarea type="text" dir="ltr"  name="inputPostShortDescription" class="form-control" ><?php echo stripslashes($post_info['post_short_description']); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="parametername">Post Description</label>
                                <textarea type="text" dir="ltr"  class="form-control ckeditor" name="inputPostDescription" ><?php echo stripslashes($post_info['post_content']); ?></textarea>
                                <div class="error hidden" id="labelProductError">Please enter post description</div>
                            </div>

                            <div class="form-group">
                                <label for="parametername">Post Page Title<sup class="mandatory">*</sup></label>
                                <textarea type="text" dir="ltr"  class="form-control" name="inputPostPageTitle" ><?php echo stripslashes($post_info['page_title']); ?></textarea>

                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Tags</label>
                                <textarea type="text" dir="ltr"  class="form-control" id="inputPostTags" name="inputPostTags" ><?php echo stripslashes($post_info['post_tags']); ?></textarea>

                            </div>
                            <div class="form-group">
                                <label for="parametername">Post Keywords</label>
                                <textarea type="text" dir="ltr"  class="form-control" id="inputPostKeywords" name="inputPostKeywords" ><?php echo stripslashes($post_info['post_keywords']); ?></textarea>

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
                                    ), $product_category, set_value('category_id', $post_info['category_id'])
                            );
                            ?>
                       
                    </div>
                            <div class="form-group">
                                <label for="city_name">Suburb<sup class="mandatory">*</sup></label>
                                <input type="text" name="search_location" id="search_location" class="form-control" placeholder="Choose Suburb" value="<?php echo (isset($post_info['suburb'])) ? stripslashes($post_info['suburb']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="city_name">Helpers<sup class="mandatory">*</sup></label>
                                <select id="helper" name="helper" class="form-control">
                                    <option value="">Select Helper</option>

                                    <?php foreach ($helpers as $helpers) { ?>
                                        <option value="<?php echo $helpers['user_id'] ?>" <?php if ($helpers['user_id'] == $post_info['helper_id']) { ?>selected="selected"<?php } ?>><?php echo $helpers['first_name'] . " " . $helpers['last_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city_name">Blog Video</label>
                                <input type="text" class="form-control" name="blog_video" id="blog_video" value="<?php echo $post_info['video_link'] ?>"/>                                            
                            </div>
                            <small class="controls">http://www.youtube.com/embed/XGSy3_Czz8k</small>
                        </div>
                        <div class="form-group">
                            <label for="parametername">Publish Status</label>
                            <select class="form-control" name="inputPublishStatus" class="">
                                <option <?php if ($post_info["status"] == "0") echo 'selected="selected"'; ?> value="0">Unpublished</option>
                                <option <?php if ($post_info["status"] == "1") echo 'selected="selected"'; ?> value="1">Published</option>
                                <option <?php if ($post_info["status"] == "2") echo 'selected="selected"'; ?> value="2">Removed (Make Abused)</option>
                            </select>
                        </div>
                        <?php if ($post_info['blog_image'] != '') { ?>
                            <div class="form-group">
                                <label for="parametername">Image</label>
                                <div class="controls"> <img id="imageHolder" src="<?php echo base_url() ?>media/backend/img/blog_image/<?php echo $post_info['blog_image'] ?>" width="150" height="150"> </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="parametername">Blog Images</label>
                            <input type="file" dir="ltr"  class="" name="blog_image" id="blog_image" value="" size="80"  autocomplete="off"  />
                            <div id="img_div" style="display: none"><img id="imageHolder" src=""accesskey=" " width="150" height="150">

                            </div>
                        </div>

                </div>
                <div class="box-footer">
                    <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes">Save changes</button>
                    <input type="hidden" name="edit_id" value="<?php echo $post_info["post_id"]; ?>">
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
        </body>
        <script type="text/javascript">
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imageHolder').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

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

            var _URL = window.URL || window.webkitURL;
            $("#blog_image").change(function(e) {

                var file, img;
                var width = 200;
                var height = 400;
                if ((file = this.files[0])) {
                    img = new Image();
                    var reader = new FileReader();
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

        </script> 
        <script type="text/javascript" language="javascript">
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
                        inputPageUrl: {
                            required: true,
                            minlength: 3//,
                                    //remote: {url: "<?php echo base_url(); ?>backend/blog/validate-page-url", data: {type: "blog-post", edit_id: "<?php echo $post_id; ?>"}, method: "post"}
                        },
                        search_location: {
                            required: true
                        },
                        category:{
                            required:true
                        },
                        helper:{
                            required:true
                        }
                    },
                    messages: {
                        inputName: {
                            required: "Please enter title for blog post",
                            minlength: "Please enter at least 3 characters"
                        },
                        inputPostShortDescription: {
                            required: "Please enter short description"
                        },
                        lang_id: {
                            required: "Please select language"
                        },
                        inputPostPageTitle: {
                            required: "Please enter title for blog post"
                        },
                        inputPageUrl: {
                            required: "Please enter url for the page",
                            minlength: "Please enter atleast 3 characters",
                            remote: "Sorry, this url is already exists. Please try another url"
                        },
                        search_location: {
                            required: "Please enter suburb."
                        },
                        category:{
                            required: "Please select category."
                        },
                        helper:{
                            required:"Please select helper."
                        }
                    },
                    // set this class to error-labels to indicate valid fields
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
             
            });
               CKEDITOR.replace('inputPostDescription',
                        {
                            filebrowserUploadUrl: '<?php echo base_url(); ?>upload-image'
                        });
        </script>
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