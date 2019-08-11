<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : ''; ?></title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.cleditor.min.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.cleditor.extimage.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <link href="<?php echo base_url(); ?>media/backend/css/jquery.cleditor.css" rel='stylesheet'>
        <script type="text/javascript" language="javascript">
            jQuery(document).ready(function () {

                jQuery("#lang").bind("change", getLanguageVals);
                jQuery("#lang").change();
                jQuery("#frmBlogPosts").validate({
                    errorElement: 'div',
                    rules: {
                        inputName: {
                            required: true,
                            minlength: 3
                        },
                        inputPostShortDescription: {
                            required: true
                        },
                        inputPostDescription: {
                            required: true
                        },
                        inputPageTitle: {
                            required: true,
                            minlength: 3
                        }
                    },
                    messages: {
                        inputName: {
                            required: "Please enter post title",
                            minlength: "Please enter at least 3 characters"
                        },
                        inputPostShortDescription: {
                            required: "Please enter post short description"
                        },
                        inputPostDescription: {
                            required: "Please enter post description"
                        },
                        inputPageTitle: {
                            required: "Please enter page title",
                            minlength: "Please enter at least 3 characters"
                        }
                    },
                    // set this class to error-labels to indicate valid fields
                    success: function (label) {
                        // set &nbsp; as text for IE
                        label.hide();
                    }
                });

            });

            function getLanguageVals()
            {
                if (jQuery(this).val() != "")
                {
                    jQuery.post("<?php echo base_url(); ?>backend/blog/get-language-for-posts", {lang: jQuery(this).val(), post_id:<?php echo $post_id; ?>}, function (msg) {
                        jQuery("#inputName").val(msg.post_title);
                        jQuery("#inputPageTitle").val(msg.page_title);
                        jQuery("#inputPostTags").val(msg.post_tags);
                        jQuery("#inputPostKeywords").val(msg.post_keywords);
                        jQuery("#inputPostShortDescription").val(msg.post_short_description);
                        jQuery("#inputPostDescription").val(msg.post_description);
                        jQuery("#is_inserted").val(msg.is_inserted);

                        var obj = jQuery('#inputPostDescription').cleditor();
                        obj[0].refresh();


                    }, "json");
                }

            }

        </script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10"> 
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/home">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/blog">Manage Blog Posts</a></li>
                </ul>
            </div>

            <!--[message box]-->
            <?php if ($this->session->userdata('msg') != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                    <?php echo $this->session->userdata('msg'); ?> </div>
                <?php
                $this->session->unset_userdata('msg');
            }
            ?>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well" data-original-title>
                        <h2>Manage Post Language</h2>
                        <div class="box-icon"> <a href="<?php echo base_url(); ?>backend/blog" class="btn btn-round" title="Manage Blog Posts"><i class="icon-arrow-left"></i></a> </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <div>
                            <form name="frmBlogPosts" class="form-horizontal" id="frmBlogPosts" action="<?php echo base_url(); ?>backend/blog/lang-posts/<?php echo $post_id; ?>" method="POST" >
                                <div class="control-group">
                                    <label class="control-label" for="inputName">Select Language</label>
                                    <div class="controls">
                                        <select id="lang" name="lang">
                                            <?php
                                            foreach ($arr_languages as $language) {
                                                ?>
                                                <option value="<?php echo $language['lang_id']; ?>"><?php echo $language['lang_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputName">Post Title</label>
                                    <div class="controls">
                                        <input type="text" dir="ltr"  class="FETextInput" name="inputName" id="inputName" value="" size="80"   />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPostShortDescription">Post Short Description</label>
                                    <div class="controls">
                                        <textarea type="text" dir="ltr"  class="FETextInput" id="inputPostShortDescription"  name="inputPostShortDescription" value="" size="80"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPostDescription">Post Description</label>
                                    <div class="controls">
                                        <textarea class="cleditor" name="inputPostDescription" id="inputPostDescription" ></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPageTitle">Post Page Title</label>
                                    <div class="controls">
                                        <input type="text" dir="ltr"  class="FETextInput" id="inputPageTitle"  name="inputPageTitle" value="" size="80"   />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPostKeywords">Post Meta Keywords</label>
                                    <div class="controls">
                                        <textarea dir="ltr"  class="FETextInput" id="inputPostKeywords" name="inputPostKeywords"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPostTags">Post Tags</label>
                                    <div class="controls">
                                        <textarea dir="ltr"  class="FETextInput" id="inputPostTags" name="inputPostTags"></textarea>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes">Save changes</button>
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                    <input type="hidden" name="is_inserted" id="is_inserted" value="">
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
<?php $this->load->view('backend/sections/footer.php'); ?>
</div>
</body>
</html>