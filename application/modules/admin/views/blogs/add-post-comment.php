
<aside class="right-side">
    <section class="content-header">

<!--        <h1>
            Add Blog Post Comment
        </h1>            -->
        <ol class="breadcrumb">

            <li> <a href="<?php echo base_url(); ?>admin/blog/view-comments/<?php echo $post_id; ?>"><i class="fa fa-fw fa-comment"></i> Manage Blogs Post Comments</a></li>
            <li>Add Blog Post Comment</li>

        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <form name="frmComment" id="frmComment"  action="<?php echo base_url(); ?>admin/blog/add-comment/<?php echo $post_id; ?>" method="POST" >
                        <div class="box-body">
                            <div class="form-group">
                                <label for="parametername">Comment<sup class="mandatory">*</sup></label>
                                <textarea name="inputComment" id="inputComment" class="form-control"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="Publish Status">Publish Status</label>
                                <select name="inputPublishStatus" id="inputPublishStatus" class="form-control">
                                    <option value="0">Unpublished</option>
                                    <option selected="selected" value="1">Published</option>
                                    <option value="2">Removed (Make Abused)</option>
                                </select>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save" id="btnSubmit">Save </button>
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
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
      
        <script>

            jQuery(document).ready(function () {

                jQuery("#frmComment").validate({
                    errorElement: 'div',
                    rules: {
                        inputComment: {
                            required: true,
                            minlength: 3
                        }
                    },
                    messages: {
                        inputComment: {
                            required: "Please enter your comment",
                            minlength: "Please enter at least 3 characters"
                        }
                    },
                    submitHandler: function (form) {
                        $("#btnSubmit").hide();
                        $('#loding_image').show();
                        form.submit();
                    },
                    // set this class to error-labels to indicate valid fields
                    success: function (label) {
                        // set &nbsp; as text for IE
                        label.hide();
                    }
                });

            });
        </script>