<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $page_title; ?></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
         <?php
            $msg = $this->session->userdata('msg');
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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sub Attributes</h2>
                    
                    <a href="<?php echo base_url(); ?>admin/subAttributesAdd" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Sub Attribute</a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div >
                        <form name="frm_list_products" id="frm_list_products" action="<?php echo base_url(); ?>admin/subAttributesList" method="post">
                        <table id="product_datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Select</td>
                                    <td>Category Name</td>
                                    <td>Attribute Name</td>
                                   
                                    <td>Sub Attribute Name</td>
                                    
                                    <td>Created Date</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  if (isset($arr_sub_attributes))  ?>
                                <?php foreach ($arr_sub_attributes as $productData) { ?>
                                    <tr>
                                        <td>
                                        <center>
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $productData['id']; ?>" />
                                        </center>
                                        </td>
                                        <td width="">
                                            <?php echo $productData['category_name']; ?>
                                        </td>
                                         <td width="">
                                            <?php echo $productData['attrubute_value']; ?>
                                        </td>
                                        <td width="">
                                            <?php echo $productData['name']; ?>
                                        </td>
                                        <td width="">
                                            <?php echo $productData['created']; ?>
                                        </td>
                                        <td><a class="btn btn-xs btn-default btn-round" href="<?php echo base_url(); ?>admin/subAttributesEdit/<?php echo $productData['id']; ?>"><i class="fa fa-pencil"></i></a></td>
                                     </tr>
                                <?php } ?>
                                     <?php if (count($arr_sub_attributes) > 0) { ?>
                                    <tfoot>
                                     <tr>
                                         <th colspan="6">
                                             <input style="width:133px !important;" type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value="Delete Selected">
                                             <!--<a id="add_new_user" name="add_new_subject" href="<?php echo base_url(); ?>backend/subject/add" class="btn btn-primary pull-right" >Add New Subject </a>-->
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


<script>
    function changeStatus(id, isactive)
            {
                /* changing the user status*/
                var obj_params = new Object();
                obj_params.id = id;
                obj_params.isactive = isactive;
                jQuery.post("<?php echo base_url(); ?>admin/changeStatus", obj_params, function(msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                    }
                    else
                    {
                        /* toogling the bloked and active div of user*/
                        if (isactive == 1)
                        {
                            $("#blocked_div" + id).css('display', 'inline-block');
                            $("#active_div" + id).css('display', 'none');
                        }
                        else
                        {
                            $("#active_div" + id).css('display', 'inline-block');
                            $("#blocked_div" + id).css('display', 'none');
                        }
                    }

                }, "json");

            }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#product_datatable').DataTable({
//            dom: 'Bfrtip',
//           // buttons: ['csv', 'excel', 'pdf', 'print'],
//             buttons: [
//            {
//                extend: 'csv',
//                footer: false,
//                exportOptions: {
//                     columns: [1,2,3,4,5,6]
//                 }
//            },
//            {
//                extend: 'excel',
//                footer: false,
//                 exportOptions: {
//                     columns: [1,2,3,4,5,6]
//                 }
//
//            },
//            {
//                extend: 'pdf',
//                footer: false,
//                 exportOptions: {
//                     columns: [1,2,3,4,5,6]
//                 }
//            },
//            {
//                extend: 'print',
//                footer: false,
//                exportOptions:{
//                     columns: [1,2,3,4,5,6]
//                }
//            }, 
//    ]  
        });
    });
</script>