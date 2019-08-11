<script type="text/javascript">

    function changeEventStatus(post_id, post_status)
    {
        /* changing the user status*/
        var obj_params = new Object();
        obj_params.post_id = post_id;
        obj_params.post_status = post_status;
        jQuery.post("<?php echo base_url(); ?>admin/event/change-status", obj_params, function (msg) {
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
    function deleteConfirm() {
        var t = confirm("Do you want to delete these subscribers?");
        if (t) {
            return true;
        } else {
            return false;
        }
    }
    function toggle(source) {

        var checkboxes = document.getElementsByName('checkbox[]');
        //alert(checkboxes.length);
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>







<!-- page content -->
<div class="" role="main">

    <!-- /top tiles -->


    <br />



    <?php
    $msg = $this->session->userdata('msg');

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
                <h2> Newsletter Subscribers Management</h2>

                <div class="clearfix"></div>
            </div>
            <form name="frm_newsletter" id="frm_newsletter" action="<?php echo base_url(); ?>admin/newsletter-subscriber/list" method="post">
                <table class="table table-bordered table-striped dataTable" id="FlagsExport" aria-describedby="example1_info">
                    <thead>

                    <th> 
                        <?php
                        if (count($arr_newsletter_list) > 0) {
                            ?>
                        <center>
                            Select <br>
                            <input type="checkbox" name="check_all" id="check_all" onclick="toggle(this)"  class="select_all_button_class" value="select all" />
                        </center>
                        <?php
                    }
                    ?>
                    </th>
                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="User Email">User Email</th>
                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Subscribe Status">Subscribe Status</th>
                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Created on">Created on</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arr_newsletter_list as $newsletter) {
                            ?>
                            <tr>
                                <td >
                        <center><input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $newsletter['newsletter_subscription_id']; ?>" /></center>
                        </td>
                        <td ><?php echo stripslashes($newsletter['user_email']); ?></td>
                        <td >


                            <div id="active_div<?php echo $newsletter['newsletter_subscription_id']; ?>"  <?php if ($newsletter['subscribe_status'] == 'Active') { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
                                <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $newsletter['newsletter_subscription_id']; ?>', 'Inactive');" href="javascript:void(0);" id="status_<?php echo $newsletter['newsletter_subscription_id']; ?>">Active</a>
                            </div>

                            <div id="blocked_div<?php echo $newsletter['newsletter_subscription_id']; ?>" <?php if ($newsletter['subscribe_status'] == 'Inactive') { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?> >
                                <a class="label label-danger" title="Click to Change Status" onClick="changeStatus('<?php echo $newsletter['newsletter_subscription_id']; ?>', 'Active');" href="javascript:void(0);" id="status_<?php echo $newsletter['newsletter_subscription_id']; ?>">Inactive</a>
                            </div>

                        </td>
                        <td ><?php echo date("d-m-Y", strtotime($newsletter['date'])); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
                <?php
                if (count($arr_newsletter_list) > 0) {
                    ?>

                    <input type="submit" value="Delete Selected" onclick="return deleteConfirm();" class="btn btn-danger" name="btn_delete_all" id="btn_delete_all">


                <?php } ?>

            </form>
        </div>
    </div>
</div>
<!-- /page content -->
<script>
    function changeStatus(newsletter_subscription_id, subscribe_status)
    {
        var obj_params = new Object();
        obj_params.newsletter_subscription_id = newsletter_subscription_id;
        obj_params.subscribe_status = subscribe_status;
        jQuery.post("<?php echo base_url(); ?>admin/subscriber-newsletter/change-status", obj_params, function (msg) {
            if (msg.error == "1")
            {
                alert(msg.error_message);
            } else
            {
                if (subscribe_status == 'Inactive')
                {
                    $("#blocked_div" + newsletter_subscription_id).css('display', 'inline-block');
                    $("#active_div" + newsletter_subscription_id).css('display', 'none');
                } else
                {
                    $("#active_div" + newsletter_subscription_id).css('display', 'inline-block');
                    $("#blocked_div" + newsletter_subscription_id).css('display', 'none');
                }

            }
        }, "json");

    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#FlagsExport').DataTable({
            
            //"pageLength": 10,
            //"order": [],
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print'],
             buttons: [
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
                     columns: [1,2,3]
                 }
            },
            {
                extend: 'excel',
                footer: false,
                 exportOptions: {
                     columns: [1,2,3]
                 }

            },
            {
                extend: 'pdf',
                footer: false,
                 exportOptions: {
                     columns: [1,2,3]
                 }
            },
            {
                extend: 'print',
                footer: false,
                 exportOptions: {
                     columns: [1,2,3]
                 }
            }, 
    ]  
        });
    });
</script>