
<aside class="right-side">
    <section class="content-header">

<!--        <h1>
            Edit Blog Comment
        </h1>            -->
        <ol class="breadcrumb">

         
            <li> <a href="<?php echo base_url(); ?>admin/blog/view-comments/<?php echo $post_id; ?>"><i class="fa fa-fw fa-comment"></i> Manage Blog Comments</a></li>
            <li>Edit Blog Post Comment</li>

        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <form name="frmComment" id="frmComment" action="<?php echo base_url(); ?>admin/blog/edit-post-comment/<?php echo $post_id; ?>/<?php echo $comment_id ?>" method="POST" >
                        <div class="box-body">
                            <div class="form-group">
                                <label for="parametername">Comment<sup class="mandatory">*</sup></label>
                                <textarea name="inputComment" id="inputComment" class="form-control"><?php echo $arr_post_comment_info["comment"]; ?></textarea>

                            </div>
                            <div class="form-group">
                                <label for="Publish Status">Publish Status</label>
                                <div class="controls">
                                    <select name="inputPublishStatus" autocomplete="off" class="form-control">
                                        <option <?php if ($arr_post_comment_info['status'] == "0") echo 'selected="selected"'; ?> value="0">Unpublished</option>
                                        <option <?php if ($arr_post_comment_info['status'] == "1") echo 'selected="selected"'; ?> value="1">Published</option>
                                        <option <?php if ($arr_post_comment_info['status'] == "2") echo 'selected="selected"'; ?> value="2">Removed (Make Abused)</option>
                                    </select>

                                </div>

                            </div>
                            <div class="box-footer">
                                <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes">Save changes</button>
                                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
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
   

        <script type="text/javascript" language="javascript">

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
                    // set this class to error-labels to indicate valid fields
                    success: function (label) {
                        // set &nbsp; as text for IE
                        label.hide();
                    }
                });

            });
        </script>