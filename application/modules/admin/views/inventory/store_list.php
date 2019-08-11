
<aside class="right-side">

    <section class="content">
       
        <div class="row">
            <div class="col-xs-12">
                 <?php
        $msg = $this->session->flashdata('msg');
        $msg_error = $this->session->flashdata('msg_error');
        ?>
        <?php if ($msg != '') { ?>
            <div class="msg_box alert alert-success">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg;
                ?>
            </div>
        <?php } ?>
        <?php if ($msg_error != '') { ?>
            <div class="msg_box alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg_error;
                ?>
            </div>
        <?php } ?>
                <div class="x_title">
                    <h2> Store List</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="">
                    <div class="box-body table-responsive">
                        <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">									
                            <a class="btn btn-xs btn-success pull-right"  href="<?php echo base_url()?>admin/inventory/add-store"><i class="fa fa-plus"></i> Add New</a>
                            <form name="frmtestimonials" id="frmtestimonials" action="<?php echo base_url(); ?>backend/testimonial/list" method="post">								
                                <table class="table table-bordered table-striped dataTable" id="table-buttons" aria-describedby="example1_info" id="table-responsive" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th> <center>
                                        Select <br>
                                        <?php
                                        if (count($store_list) > 1) {
                                            ?>
                                            <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                        <?php } ?>
                                    </center></th>
                                    <th class="sorting_asc">Store Name</th>
                                    <th class="sorting_asc" >Phone </th>
                                    <th class="sorting_asc" >Address</th>                                  		
                                    <th class="sorting_asc" >Status</th>
                                    <th  role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Action">Action</th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($store_list as $store_list) {
                                            ?>
                                            <tr>
                                                <td ><center>
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $store_list['id']; ?>" />
                                        </center></td>
                                        <td><?php echo $store_list['name']; ?></td>
                                        <td><?php echo $store_list['phone']; ?></td>
                                        <td><?php echo $store_list['address']; ?></td>


                                        <td ><?php
                                            switch ($store_list['is_active']) {
                                                case '1':
                                                    $class = 'label-success';
                                                    $status = $store_list['is_active'];
                                                    $status_to_change = '0';
                                                    break;
                                                case '0':
                                                    $class = 'label-warning';
                                                    $status = $store_list['is_active'];
                                                    $status_to_change = 'Active';
                                                    break;
                                            }
                                            ?>
                                            <div  id="activeDiv<?php echo $store_list['id']; ?>" <?php if ($store_list['is_active'] == "1") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
                                                <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $store_list['id']; ?>', '0');" href="javascript:void(0);" id="status_<?php echo $store_list['id']; ?>">Active</a>
                                            </div>

                                            <div id="inActiveDiv<?php echo $store_list['id']; ?>" <?php if ($store_list['is_active'] == "0") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>

                                                <a class="label label-warning" title="Click to Change Status" onClick="changeStatus('<?php echo $store_list['id']; ?>', '1');" href="javascript:void(0);" id="status_<?php echo $store_list['id']; ?>">Inactive</a>
                                            </div>

                                        </td>



                                        <td class="">
                                            <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>admin/inventory/edit-store/<?php echo base64_encode($store_list['id']); ?>"> <i class="fa fa-edit"></i> Edit</a>
                                            <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>admin/inventory/updateStock/<?php echo $store_list['id']; ?>"> <i class="fa fa-edit"></i> Update Stock</a>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
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

            function changeStatus(id, status)
            {
                var objParams = new Object();
                objParams.id = id;
                objParams.status = status;
                jQuery.post("<?php echo base_url(); ?>admin/inventory/change-status", objParams, function (msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.errorMessage);
                    } else
                    {
                        if (status == "0")
                        {
                            $("#inActiveDiv" + id).css('display', 'inline-block');
                            $("#activeDiv" + id).css('display', 'none');

                        } else
                        {
                            $("#activeDiv" + id).css('display', 'inline-block');
                            $("#inActiveDiv" + id).css('display', 'none');
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
                    } else
                    {
                        if (is_featured == '0')
                        {
                            $("#display_div" + testimonial_id).css('display', 'inline-block');
                            $("#notdisplay_div" + testimonial_id).css('display', 'none');
                            location.href = location.href;

                        } else
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