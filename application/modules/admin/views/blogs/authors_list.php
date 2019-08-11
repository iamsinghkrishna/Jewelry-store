<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : ''; ?></title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!--library for advanced tooltip-->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10"> 
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/home">Dashboard</a> <span class="divider">/</span> </li>
                    <li> Manage Authors</li>
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
                    <div class="box-header well">
                        <h2><i class=""></i>Authors Management</h2>
                        <div class="box-icon"> <a title="Add new forum category" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/blog/add-author"><i class="icon-plus"></i></a> </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="5%" class="workcap"><center>
                                    Select<br>
                                    <input type="checkbox" id="chkAll">
                                </center></th>
                                <th width="70%" class="workcap">Author Name</th>
                                <th width="35%" class="workcap" align="center">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($arr_post_categories as $post) {
                                        ?>
                                        <tr>
                                            <td class="worktd" align="left"><center>
                                        <input value="<?php echo $post['author_id']; ?>" class="chkselect" type="checkbox">
                                    </center></td>
                                    <td class="worktd"  align="left"><?php echo $post['author_name']; ?></td>
                                    <td class="worktd" ><a class="btn btn-info" href="<?php echo base_url(); ?>backend/blog/edit-author/<?php echo $post['author_id']; ?>"> <i class="icon-edit icon-white"></i> Edit</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7"><input type="button" id="btnDeleteAll" class="btn btn-danger" value="Delete Selected"></th>
                                    </tr>
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
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div>
<script>
    function confirmDeletion(id)
    {
        if (confirm("Are you sure to delete this forum post?"))
        {
            var objParams = new Object();
            objParams.post_id = id;
            jQuery.post("<?php echo base_url(); ?>backend/forum/delete-category", objParams, function (msg) {
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

    jQuery("#chkAll").bind("click", function () {
        if (jQuery(this).is(":checked"))
        {
            jQuery(".chkselect").attr("checked", "checked");
        }
        else
        {
            jQuery(".chkselect").removeAttr("checked");
        }
    });

    jQuery(".chkselect").bind("click", function () {
        updateSelectAll();
    });

    function updateSelectAll()
    {
        var totChecked = jQuery(".chkselect:checked").length;
        var totCheckboxes = jQuery(".chkselect").length;

        if (totChecked < totCheckboxes)
        {
            jQuery("#chkAll").removeAttr("checked");
        }
        else
        {
            jQuery("#chkAll").attr("checked", "checked");
        }

    }

    jQuery("#btnDeleteAll").bind("click", function () {

        if (jQuery(".chkselect:checked").length < 1)
        {
            alert("Please select atleast one post to delete");
            return;
        }

        if (confirm("Are you sure to delete these author?"))
        {
            var arrPostIds = [];
            jQuery(".chkselect").each(function (index, element) {

                if (jQuery(element).is(":checked"))
                    arrPostIds.push(jQuery(element).val());

            });

            var objParams = new Object();
            objParams.post_ids = arrPostIds;

            jQuery.post("<?php echo base_url(); ?>backend/blog/delete-author", objParams, function (msg) {
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
    });
</script>
</body>
</html>