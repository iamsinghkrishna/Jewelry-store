<?php $this->load->view('backend/sections/header'); ?>
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<aside class="right-side">
    <section class="content-header">
        <h1>
            Blog Categories Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>backend/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Blog Categories Management</li>

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
                <div class="box">
                    <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>backend/user/list" method="post">
                        <div class="box-body table-responsive">
                            <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">									
                                <table class="table table-bordered table-striped dataTable" id="example1" aria-describedby="example1_info">
                                    <thead>   
                                        <?php if (count($arr_post_categories) > 0) {
                                            ?>
                                        <th width="5%">
                                        <center>
                                            Select<br>
                                            <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                        </center>
                                        </th>
                                   <?php } ?>		
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Category Name">Category Name</th>
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Parent Category">Parent Category</th>

                                    <th  role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Action">Action</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cnt = 0;
                                        foreach ($arr_post_categories as $post) {
                                            ?>
                                            <tr>
                                                <td >
                                        <center>
                                            <input value="<?php echo $post['category_id']; ?>" name="checkbox[]" id="checkbox" class="case" type="checkbox">
                                        </center>
                                        </td>
                                        <td><?php echo $post['category_name']; ?></td>
                                        <td ><?php echo $post['parent_category']; ?></td>
                                        <td ><a class="btn btn-info" href="<?php echo base_url(); ?>backend/blog/edit-category/<?php echo $post['category_id']; ?>"> <i class="icon-edit icon-white"></i> Edit</a></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7">
                                                <input type="button" id="btnDeleteAll" class="btn btn-danger" value="Delete Selected">
                                                <a  class="btn btn-primary  pull-right" href="<?php echo base_url(); ?>backend/blog/add-category"> Add New Category</a>

                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </form>
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
        <script>
            jQuery("#btnDeleteAll").on("click", function () {

                if (jQuery(".case:checked").length < 1)
                {
                    alert("Please select atleast one record to delete");
                    return;
                }

                if (confirm("Are you sure to delete selected records? Please note all categoris under these category will also be delete."))
                {
                    var arrPostIds = [];
                    jQuery(".case").each(function (index, element) {

                        if (jQuery(element).is(":checked"))
                            arrPostIds.push(jQuery(element).val());

                    });

                    var objParams = new Object();
                    objParams.post_ids = arrPostIds;

                    jQuery.post("<?php echo base_url(); ?>backend/blog/delete-category", objParams, function (msg) {
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