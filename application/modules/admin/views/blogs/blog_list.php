<script type="text/javascript">

    function changeBlogStatus(post_id, post_status)
    {
        /* changing the user status*/
        var obj_params = new Object();
        obj_params.post_id = post_id;
        obj_params.post_status = post_status;
        jQuery.post("<?php echo base_url(); ?>admin/blog/change-status", obj_params, function (msg) {
            if (msg.error == "1")
            {
                alert(msg.error_message);
            } else
            {
                /* togling the Active and Inactive div of user*/
                if (post_status == '0')
                {
                    $("#inactive_div" + post_id).css('display', 'inline-block');
                    $("#active_div" + post_id).css('display', 'none');
                } else
                {
                    $("#active_div" + post_id).css('display', 'inline-block');
                    $("#inactive_div" + post_id).css('display', 'none');
                }
            }
        }, "json");
    }
</script>







<!-- page content -->
<div class="right_col" role="main">

    <!-- /top tiles -->


    <br />



    <?php
    $msg = $this->session->flashdata('msg');

    if ($msg) {
        ?>
        <script type='text/javascript'>
            $(function () {
                new PNotify({
                    title: 'Success',
                    text: "<?= $msg ?>",
                    type: 'success',
                    hide: true,
                    styling: 'bootstrap3',
                    delay: 2500,
                    history: false,
                    sticker: true,
                    addclass: "stack-modal",
                });
            });
        </script>
    <?php } ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Blog List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a title="Add new blog post" class="btn btn-info pull-right" href="<?php echo base_url(); ?>admin/blog/add-post"><i class="fa fa-plus-circle"></i></a>		


                <table id="datatable-responsive" class="table table-striped table-bordered  nowrap" >
                    <thead>
                        <tr role="row">
                            <th>Blog Title</th>
                            <th>Posted On</th>
                            <th>Posted by</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>


                    </thead>
                    <tbody>
                        <?php
                        $cnt = 0;
                        if (!empty($blog_posts)) {
                            foreach ($blog_posts as $post) {
                                ?>
                                <tr>

                                    <td class="worktd"  align="left"><?php echo stripslashes($post['post_title']); ?></td>
                                    <td>
                                        <?php// echo date($global['date_format'], strtotime($post['posted_on'])); ?>
                                    </td>
                                    <td class="worktd"  align="left"><?php //echo stripslashes($post['username']); ?></td>
                                    <td>
                                        <div id="inactive_div<?php echo $post['post_id']; ?>" <?php if ($post['status'] == '0') { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?> >
                                            <a class="label label-danger" title="Click to Change Status" onClick="changeBlogStatus('<?php echo $post['post_id']; ?>', '1');" href="javascript:void(0);" id="status_<?php echo $post['post_id']; ?>">Unpublished</a>
                                        </div>
                                        <div id="active_div<?php echo $post['post_id']; ?>"<?php if ($post['status'] == '1') { ?> style="display:inline-block" <?php } else { ?>  style="display:none;" <?php } ?>>
                                            <a class="label label-success" title="Click to Change Status" onClick="changeBlogStatus('<?php echo $post['post_id']; ?>', '0');" href="javascript:void(0);" id="status_<?php echo $post['post_id']; ?>">Published</a>
                                        </div>
                                    </td>
                                    <td class="worktd" style="text-align:left">
                                        <a class="btn btn-primary btn-xs" title="Edit Blog Post" href="<?php echo base_url(); ?>admin/blog/edit-post/<?php echo $post['post_id']; ?>">
                                            <i class="fa fa-edit"></i> Edit</a>
                                        <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>admin/blog/view-comments/<?php echo $post['post_id']; ?>"  title="Click to view comments posted by users">
                                            <i class="fa fa-comment"></i> Comments</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php // if (!empty($blog_posts)) { ?>
                    <!--<input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value=" Delete Selected">-->
                <?php //} ?>


            </div>
        </div>
    </div>
</div>
<!-- /page content -->