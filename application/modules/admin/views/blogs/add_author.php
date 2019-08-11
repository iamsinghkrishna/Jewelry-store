<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : ''; ?></title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.cleditor.min.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.cleditor.extimage.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <link href="<?php echo base_url(); ?>media/backend/css/jquery.cleditor.css" rel='stylesheet'>
        <script type="text/javascript" language="javascript">

            jQuery(document).ready(function () {

                jQuery("#frmForumPost").validate({
                    errorElement: 'div',
                    rules: {
                        inputName: {
                            required: true,
                            minlength: 3
                        }
                    },
                    messages: {
                        inputName: {
                            required: "Please enter author name",
                            minlength: "Please enter at least 3 characters"
                        }
                    }
                });

            });
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
                    <li> <a href="<?php echo base_url(); ?>backend/blog/author-list">Manage Authors</a><span class="divider">/</span> </li>
                    <li>Add Author</li>
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
                        <h2>Add Author</h2>
                        <div class="box-icon"> <a href="<?php echo base_url(); ?>backend/blog/author-list" class="btn btn-round" title="Manage Forum Posts"><i class="icon-arrow-left"></i></a>  </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <div class="box-content">
                            <div>
                                <FORM name="frmForumPost" id="frmForumPost" action="<?php echo base_url(); ?>backend/blog/add-author" method="POST" >
                                    <div class="control-group">
                                        <!--<label class="control-label" for="inputName"></label>-->
                                        <label for="inputName" class="control-label">Author Name:<sup class="mandatory">*</sup> </label>
                                        <div class="controls">
                                            <input type="text" dir="ltr"  class="FETextInput" name="inputName" value="" size="80"   />
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes">Save changes</button>
                                    </div>
                                </FORM>
                            </div>
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