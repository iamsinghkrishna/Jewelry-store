
<aside class="right-side">
    <section class="content-header">
<!--        <h1>
            Testimonials Management
        </h1>-->
        <ol class="breadcrumb">
<li class="active"><i class="fa fa-fw fa-retweet"></i> Manage  Testimonials</li>

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

                            <form name="frmtestimonials" id="frmtestimonials" action="<?php echo base_url(); ?>backend/testimonial/list" method="post">								
                                <table class="table table-bordered table-striped dataTable" id="example1" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th> <center>
                                        Select <br>
                                        <?php
                                        if (count($arr_tetimonials) > 1) {
                                            ?>
                                            <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
<?php } ?>
                                    </center></th>
                                     <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Name">Title</th>
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Testimonial">Description</th>
         
                                    <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                        ?>	
                                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Language">Language</th>
<?php } ?>			
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Added By<">Added By</th>
                                    <th  role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Action">Action</th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($arr_tetimonials as $tetimonials) {
                                            ?>
                                            <tr>
                                                <td ><center>
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $tetimonials['testimonial_id']; ?>" />
                                        </center></td>
                                        <td><?php echo stripslashes($tetimonials['name']); ?></td>
                                        <td><?php echo str_replace("\r\n", "", substr(stripcslashes($tetimonials['testimonial']), 0, 40)); ?></td>
                                        
                                        <?php if ($this->config->item('is_multi_language') == 'Yes') {
                                            ?>	
                                            <td ><?php echo stripslashes($tetimonials['lang_name']); ?></td>
                                            <?php } ?>  
                                        <td ><?php
                                            switch ($tetimonials['status']) {
                                                case 'Active':
                                                    $class = 'label-success';
                                                    $status = $tetimonials['status'];
                                                    $status_to_change = 'Inactive';
                                                    break;
                                                case 'Inactive':
                                                    $class = 'label-warning';
                                                    $status = $tetimonials['status'];
                                                    $status_to_change = 'Active';
                                                    break;
                                            }
                                            ?>
                                            <div  id="activeDiv<?php echo $tetimonials['testimonial_id']; ?>" <?php if ($tetimonials['status'] == "Active") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
                                                <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $tetimonials['testimonial_id']; ?>', 'Inactive');" href="javascript:void(0);" id="status_<?php echo $tetimonials['testimonial_id']; ?>">Active</a>
                                            </div>

                                            <div id="inActiveDiv<?php echo $tetimonials['testimonial_id']; ?>" <?php if ($tetimonials['status'] == "Inactive") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>

                                                <a class="label label-warning" title="Click to Change Status" onClick="changeStatus('<?php echo $tetimonials['testimonial_id']; ?>', 'Active');" href="javascript:void(0);" id="status_<?php echo $tetimonials['testimonial_id']; ?>">Inactive</a>
                                            </div>

                                        </td>


                                        <td ><?php echo $tetimonials['added_by']; ?></td>
                                        <td class=""><a class="btn btn-info" href="<?php echo base_url(); ?>admin/testimonial/add/<?php echo base64_encode($tetimonials['testimonial_id']); ?>"> <i class="icon-edit icon-white"></i>Edit</a></td>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="7"><input type="submit" id="btnDeleteAll" value="Delete Selected" onclick="return deleteConfirm();" class="btn btn-danger" name="btn_delete_all" id="btn_delete_all" style="width: 121px;float: right;margin-top: 0px;">
                                                <a  class="btn btn-primary  pull-right" href="<?php echo base_url(); ?>admin/testimonial/add"> Add New Testimonial</a>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

        </div>
        <script type="text/javascript">

            function changeStatus(testimonial_id, status)
            {
                var objParams = new Object();
                objParams.testimonial_id = testimonial_id;
                objParams.status = status;
                jQuery.post("<?php echo base_url(); ?>admin/testimonial/change-status", objParams, function (msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.errorMessage);
                    }
                    else
                    {
                        if (status == "Inactive")
                        {
                            $("#inActiveDiv" + testimonial_id).css('display', 'inline-block');
                            $("#activeDiv" + testimonial_id).css('display', 'none');

                        }
                        else
                        {
                            $("#activeDiv" + testimonial_id).css('display', 'inline-block');
                            $("#inActiveDiv" + testimonial_id).css('display', 'none');
                        }

                        location.href = location.href;
                    }
                }, "json");
            }

            function changeTestimonialDispaly(testimonial_id, is_featured)
            {

                var obj_params = new Object();
                obj_params.testimonial_id = testimonial_id;
                obj_params.is_featured = is_featured;
                jQuery.post("<?php echo base_url(); ?>admin/testimonial/change-homepage-testimonial-status", obj_params, function (msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                    }
                    else
                    {
                        if (is_featured == '0')
                        {
                            $("#display_div" + testimonial_id).css('display', 'inline-block');
                            $("#notdisplay_div" + testimonial_id).css('display', 'none');
                            location.href = location.href;

                        }
                        else
                        {
                            $("#notdisplay_div" + testimonial_id).css('display', 'inline-block');
                            $("#display_div" + testimonial_id).css('display', 'none');
                            location.href = location.href;

                        }
                    }

                }, "json");
                
            }
//             jQuery("#btnDeleteAll").bind("click", function () {
//
//                if (jQuery(".case:checked").length < 1)
//                {
//                    alert("Please select atleast one record to delete");
//                    return;
//                }
//
//                if (confirm("Are you sure to delete these records?"))
//                {
//                    var arrPostIds = [];
//                    jQuery(".case").each(function (index, element) {
//                        if (jQuery(element).is(":checked"))
//                            arrPostIds.push(jQuery(element).val());
//                    });
//
//                    var objParams = new Object();
//                    objParams.post_ids = arrPostIds;
//
//                    jQuery.post("<?php echo base_url(); ?>admin/blog/delete-post", objParams, function (msg) {
//                        if (msg.error == "1")
//                        {
//                            alert(msg.errorMessage);
//                        }
//                        else
//                        {
//                            location.href = location.href;
//                        }
//                    }, "json");
//                }
//            });
        </script>
        </body>
        </html>