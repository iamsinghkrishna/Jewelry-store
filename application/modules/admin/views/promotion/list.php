
<aside class="right-side">

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
                <div class="x_title">
                    <h2> Promotions Banner List</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="">
                    <div class="box-body table-responsive">
                        <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">									
                            <a class="btn btn-xs btn-success pull-right"  href="<?php echo base_url()?>admin/promotion/add_banner"><i class="fa fa-plus"></i> Add New</a>
                            <form name="frmtestimonials" id="frmtestimonials" action="<?php echo base_url(); ?>admin/promotion/lists" method="post">								
                                <table class="table table-bordered table-striped dataTable" id="table-buttons" aria-describedby="example1_info" id="table-responsive" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th> <center>
                                        Select <br>
                                        <?php
                                        if (count($promotions) > 1) { 
                                            ?>
                                       
                                            <!--<input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />-->
                                        <?php } ?>
                                    </center></th>
                                    <th class="sorting_asc">Type</th>
                                    <th class="sorting_asc" >Discount</th>
                                    <th class="sorting_asc" >From Date</th>
                                    <th class="sorting_asc" >To Date</th>                                    		
                                    <th class="sorting_asc" >Status</th>
                                    <th  role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Action">Action</th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($promotions as $promotions) {
                                            ?>
                                            <tr>
                                                <td ><center>
                                            
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $promotions['id']; ?>" />
                                        </center></td>
                                        <td><?php echo ($promotions['type'] == '0') ? 'Banner' : 'Content'; ?></td>
                                        <td><?php echo ($promotions['discount_in'] == '0') ? $promotions['discount'] : $promotions['discount']; ?></td>
                                        <td><?php echo $promotions['from_date'] ?></td>
                                        <td><?php echo $promotions['to_date']; ?></td>


                                        <td ><?php
                                            switch ($promotions['status']) {
                                                case '1':
                                                    $class = 'label-success';
                                                    $status = $promotions['status'];
                                                    $status_to_change = 'Inactive';
                                                    break;
                                                case '0':
                                                    $class = 'label-warning';
                                                    $status = $promotions['status'];
                                                    $status_to_change = 'Active';
                                                    break;
                                            }
                                            ?>
                                            <div  id="activeDiv<?php echo $promotions['id']; ?>" <?php if ($promotions['status'] == "1") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
                                                <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $promotions['id']; ?>', '0');" href="javascript:void(0);" id="status_<?php echo $promotions['id']; ?>">Active</a>
                                            </div>

                                            <div id="inActiveDiv<?php echo $promotions['id']; ?>" <?php if ($promotions['status'] == "0") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>

                                                <a class="label label-warning" title="Click to Change Status" onClick="changeStatus('<?php echo $promotions['id']; ?>', '1');" href="javascript:void(0);" id="status_<?php echo $promotions['id']; ?>">Inactive</a>
                                            </div>

                                        </td>



                                        <td class=""><a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>admin/promotion/add_banner/<?php echo base64_encode($promotions['id']); ?>"> <i class="fa fa-edit"></i> Edit</a></td>
                                        </tr>
                                            <?php
                                    }
                                    ?>
                                         <?php if (count($promotions) > 0) { ?>
                                       <tfoot>
                                    <tr>
                                        <th colspan="9">
                                            <input style="width:133px !important;" type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value="Delete Selected">
                                            <!--<a id="add_new_user" name="add_new_subject" href="<?php echo base_url(); ?>backend/subject/add" class="btn btn-primary pull-right" >Add New Subject </a>-->
                                        </th>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                                
                                  <?php if (count($promotions) < 1) { ?>
                                       <tfoot>
                                    <tr>
                                        <th colspan="9">
                                            
                                           <?php echo 'No available data.' ?>
                                        </th>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                                
                                    </tbody>
                                </table>
                                </form>
                        </div>
                    </div>
                    
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
                jQuery.post("<?php echo base_url(); ?>admin/changeStatusPromotions", objParams, function (msg) {
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

                        //location.href = location.href;
                    }
                }, "json");
            }

            function changeTestimonialDispaly(id, is_featured)
            {

                var obj_params = new Object();
                obj_params.id = id;
                obj_params.is_featured = is_featured;
                jQuery.post("<?php echo base_url(); ?>admin/testimonial/change-homepage-testimonial-status", obj_params, function (msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                    } else
                    {
                        if (is_featured == '0')
                        {
                            $("#display_div" + id).css('display', 'inline-block');
                            $("#notdisplay_div" + id).css('display', 'none');
                            location.href = location.href;

                        } else
                        {
                            $("#notdisplay_div" + id).css('display', 'inline-block');
                            $("#display_div" + id).css('display', 'none');
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