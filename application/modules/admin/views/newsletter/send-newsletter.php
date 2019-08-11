<?php $this->load->view('backend/sections/header'); ?>
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<script src="<?php echo base_url(); ?>media/backend/js/ckeditor/ckeditor.js"></script>
<aside class="right-side">
    <section class="content-header">

        <h1> Send Newsletter	</h1>            
        <ol class="breadcrumb">

            <li> <a href="<?php echo base_url(); ?>backend/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>  </li>
            <li class="active"> <a href="<?php echo base_url(); ?>backend/newsletter/list"><i class="fa fa-fw fa-envelope"></i> Manage Newsletters</a></li>
            <li>Send Newsletter</li>

        </ol>
    </section>      	
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form  name="frm_send_newsletter" id="frm_send_newsletter" action="<?php echo base_url(); ?>backend/send-newsletter/<?php echo $newsletter_id; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="subject" value="<?php echo $email_template[0]['newsletter_subject']; ?>" />
                        <input type="hidden" name="newsletter_id" value="<?php echo $email_template[0]['newsletter_id']; ?>" />
                        <div class="box-body">
                            <div class="form-group">
                                <label for="parametername">Subject<sup class="mandatory">*</sup></label>
                                <input type="text"   class="form-control" name="input_subject" id="input_subject"  value="<?php echo $email_template[0]['newsletter_subject']; ?>"/>
                                <?php echo form_error('input_subject'); ?> 
                            </div>
                            <div class="form-group">
                                <label for="parametername">Select User<sup class="mandatory">*</sup></label>
                                <select  class="form-control" name="user_status" id="user_status" onChange="display_list_div();">
                                    <option value="" selected="selected">Select </option>
                                    <option value="3">Subscribers user</option>
                                    <option value="1">Active user</option>
                                    <option value="0">Inactive user</option>
                                    <option value="2">Blocked user</option>
                                </select>
                            </div>
                            <div class="form-group" style="display:none" id="for_list">
                                <label for="parametername">List of Emails<sup class="mandatory">*</sup></label>

                                <textarea rows="5" name="list_of_users" id="list_of_users" class="form-control"></textarea>
                            </div>
                            <div class="form-group" style="display:none" id="attach">
                                <label for="parametername">Select Attachement</label>
                                <input type="file" name="attachement" id="attachement"/>

                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" id="button_submit" style="display:none;" name="send_nessletter" class="btn btn-primary">Send</button>
                            <button type="button" name="btn_cancel" id="btn_cancel" class="btn">Cancel</button>
                        </div> 

                    </form>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/sections/footer.php'); ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#btn_cancel').click(function () {
                    window.location = "<?php echo base_url(); ?>backend/newsletter/list";
                });

                jQuery("#frm_send_newsletter").validate({
                    errorElement: 'div',
                    errorClass: 'error',
                    rules: {
                        input_subject: {
                            required: true,
                            minlength: 3
                        },
                        user_status: {
                            required: true
                        },
                        list_of_users: {
                            required: true
                        }
                    },
                    messages: {
                        input_subject: {
                            required: "Please enter newsletter subject.",
                            minlength: "Please enter at least 3 characters."
                        },
                        user_status: {
                            required: "Please select user type to send newsletter."
                        },
                        list_of_users: {
                            required: "Please select at least one user."
                        }
                    }
                });


            });
            function display_list_div()
            {

                var user_status = $("#user_status").val();
                if ($("#user_list").val() == "none")
                {
                    $("#for_list").css("display", "none");
                }
                else
                {
                    $.ajax({
                        url: "<?php echo base_url(); ?>newsletter/gettingAllUsersByStatus",
                        type: "post",
                        data: {'user_status': user_status},                      
                        success: function (msg)
                        {
                         
                            $("#for_list").css("display", "block");
                            $("#list_of_users").val('');
                            $("#list_of_users").val(msg);
                            $("#button_submit").css("display", "inline-block");
                            $("#attach").css("display", "block");

                            if (!msg) {
                                
                                $("#for_list").css("display", "none");
                                $("#attach").css("display", "none");
                                $("#list_of_users").val('');
                                $("#button_submit").css("display", "none");
                            }
                        }
                    });

                }
            }
        </script>