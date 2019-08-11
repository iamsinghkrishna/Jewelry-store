
<aside class="right-side">
    <section class="content-header">
<!--        <h1>
            //Blog Post Management
        </h1>-->
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-fw fa-list"></i> Blog Post Management</li>

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

                                    <tr role="row">
                                        <?php if (count($blog_posts) > 0) {
                                            ?>
                                            <th >
                                    <center>
                                        Select<br>
                                        <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                    </center>
                                    </th>
<?php } ?>	
                                <th   class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Post Title">Post Title</th>

                                <th  class="wid-130" aria-label="Post Description">Post Description</th>
                                <!--<th   class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Category">Category</th>-->
                                <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                    ?>
                                    <!--<th   class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Language">Language</th>-->
<?php } ?>	
                                <th  class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Posted On" >Posted On</th>
                                <th  class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Status">Status</th>
                                <th role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Edit">Edit</th>		
                                <th role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Comment">Comment</th>				
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($blog_posts as $post) {
                                        ?>
                                        <tr>
                                            <td><center>
                                        <input value="<?php echo $post['post_id']; ?>" class="case" type="checkbox">
                                    </center></td>
                                    <td ><?php echo $post['post_title']; ?></td>
                                    <td><p style="width:300px;word-wrap:break-word;"><?php echo $post['post_short_description']; ?></p></td>
<!--                                    <td><?php echo $post['category_name']; ?></td>-->
                                    <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                        ?> 
                                        <td><?php // echo $post['lang_name']; ?></td>
                                     <?php } ?>  
                                    <td ><?php echo date("d<\s\up>S</\s\up> M Y<b\\r>h:i A", strtotime($post['posted_on'])); ?></td>
                                    <td><?php if ($post['status'] == "0") echo "Unpublished";
                                    elseif ($post['status'] == "1") echo "Published";elseif ($post['status'] == "2") echo "Removed"; ?>
                                    </td>
                                    <td ><a class="btn btn-info" href="<?php echo base_url(); ?>admin/blog/edit-post/<?php echo $post['post_id']; ?>"> <i class="icon-edit icon-white"></i> Edit</a> 
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/blog/view-comments/<?php echo $post['post_id']; ?>"  title="Click to view comments posted by users"> <i class="icon-eye-open icon-white"></i> Comments</a>
                                    </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                                  <?php if (count($blog_posts) > 0) { ?>
                                       <tfoot>
                                    <tr>
                                        <th colspan="9"><input type="button" id="btnDeleteAll" class="btn btn-danger" value="Delete Selected" style="width: 121px;float: right;margin-top: 0px;">
                                            <a  class="btn btn-primary  pull-right" href="<?php echo base_url(); ?>admin/blog/add-post"> Add New Blog</a>
                                        </th>
                                    </tr>
                                </tfoot>
                                <?php }else{ ?>
                                          <tfoot>
                                            <tr>
                                                <th colspan="8">
                                                    <a  class="btn btn-primary  pull-right" href="<?php echo base_url(); ?>admin/blog/add-post"> Add New Blog</a>
                                                </th>
                                            </tr>
                                        </tfoot>
                                <?php }?>    
                               
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


        <script>


            jQuery("#btnDeleteAll").bind("click", function () {

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
                    objParams.post_ids = arrPostIds;

                    jQuery.post("<?php echo base_url(); ?>admin/blog/delete-post", objParams, function (msg) {
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