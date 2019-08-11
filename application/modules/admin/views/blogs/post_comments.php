
<aside class="right-side">
    <section class="content-header">
<!--        <h1>
            Blog Comments Management
        </h1>-->
        <ol class="breadcrumb">
            <li> <a href="<?php echo base_url(); ?>admin/blog/"><i class="fa fa-fw fa-list"></i> Blog Posts</a></li>
            <li class="active">Blog Comments Management</li>
        </ol>
    </section>
    <section class="content">
        <?php
        $msg = $this->session->userdata('msg');
        $msg_error = $this->session->userdata('msg_error');
        ?>
<?php if ($msg != '') { ?>
            <div class="msg_box alert alert-success">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg;
                $this->session->unset_userdata('msg');
                ?>
            </div>
        <?php } ?>
<?php if ($msg_error != '') { ?>
            <div class="msg_box alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg_error;
                $this->session->unset_userdata('msg_error');
                ?>
            </div>
<?php } ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="">
                    <div class="box-body table-responsive">
                        <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">									
                            <table class="table table-bordered table-striped dataTable" id="example1" aria-describedby="example1_info">
                                <thead>
                                    <?php if (count($arr_post_comments) > 0) {
                                        ?>
                                    <th width="5%">
                                    <center>
                                        Select<br>
                                        <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                    </center>
                                    </th>
<?php } ?>	
                                <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Comment By">Comment By</th>
                                <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Comment">Comment</th>
                                <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Comment on">Comment on</th>
                                <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Status">Status</th>
                                <th  role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Action">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($arr_post_comments as $comment) {
                                        $cnt++;
                                        ?>
                                        <tr>
                                            <td>
                                    <center>
                                        <input value="<?php echo $comment['comment_id']; ?>" class="case" type="checkbox">
                                    </center></td>
                                    <td ><?php echo $comment['commented_by']; ?></td>
                                    <td   align="center"><?php echo stripslashes(nl2br($comment['comment'])); ?></td>
                                    <td><?php echo date("d<\s\up>S</\s\up> M Y<b\\r>h:i A", strtotime($comment['comment_on'])); ?></td>
                                    <td><?php
                                        if ($comment['status'] == "0")
                                            echo "Unpublished";
                                        elseif ($comment['status'] == "1")
                                            echo "Published";elseif ($comment['status'] == "2")
                                            echo "Removed";
                                        ?>
                                    </td>
                                    <td  style="text-align:center"><a class="btn btn-info" href="<?php echo base_url(); ?>admin/blog/edit-post-comment/<?php echo $comment['post_id']; ?>/<?php echo $comment['comment_id']; ?>"> <i class="icon-edit icon-white"></i> Edit</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                                <tfoot>
                                <th colspan="8">
                                    <input type="button" id="btnDeleteAll" class="btn btn-danger" value="Delete Selected" style="width: 121px;float: right;margin-top: 0px;">
                                    <a title="Add new comment" class="btn btn-primary pull-right" href="<?php echo base_url(); ?>admin/blog/add-comment/<?php echo $post_id; ?>">Add New Comment</a>
                                </th>
                                </tfoot>

                            </table>
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

        </div>
        <script>
            function confirmDeletion(id)
            {
                if (confirm("Are you sure to delete this comment?"))
                {
                    var objParams = new Object();
                    objParams.comment_id = id;
                    jQuery.post("<?php echo base_url(); ?>admin/blog/delete-post-comment", objParams, function (msg) {
                        if (msg.error == "1")
                        {
                            alert(msg.errorMessage);
                        }
                        else
                        {
                            alert("Your request has been completed successfully!");
                            location.href = location.href;
                        }
                    }, "json");
                }
            }


            jQuery("#btnDeleteAll").on("click", function () {

                if (jQuery(".case:checked").length < 1)
                {
                    alert("Please select atleast one record to delete");
                    return;
                }

                if (confirm("Are you sure to delete these records?"))
                {
                    var arrPostIds = [];

                    jQuery(".case").each(function (index, element) {

                        if (jQuery(element).is(":checked"))
                            arrPostIds.push(jQuery(element).val());

                    });

                    var objParams = new Object();
                    objParams.comment_ids = arrPostIds;

                    jQuery.post("<?php echo base_url(); ?>admin/blog/delete-post-comment", objParams, function (msg) {
                        if (msg.error == "1")
                        {
                            alert(msg.errorMessage);
                        }
                        else
                        {
                            location.href = location.href;
                        }
                    }, "json");
                }
            });
        </script>
        </body>
        </html>
