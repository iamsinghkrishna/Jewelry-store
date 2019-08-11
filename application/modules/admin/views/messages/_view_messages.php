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
                    <h2>Contact Messages</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div >
                        <form name="frm_list_messages" id="frm_list_messages" action="<?php echo base_url(); ?>admin/contactMessageList" method="post">
                        <table id="product_datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Select</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Message</td>
                                    <td>Date</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  if (isset($arr_message_details))  ?>
                                <?php foreach ($arr_message_details as $messages) { ?>
                                    <tr>
                                        <td>
                                        <center>
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $messages['id']; ?>" />
                                        </center>
                                        </td>
                                        <td>
                                          <?php echo ucfirst($messages['name']); ?>  
                                        </td>
                                        <td>
                                          <?php echo ucfirst($messages['email']); ?>  
                                        </td>
                                         
                                        <td>
                                          <?php echo $ur_str = (strlen($messages['message']) > 200) ? substr($messages['message'],0,200).'...' :$messages['message']; ?>  
                                        </td>
                                        <td>
                                          <?php echo ucfirst($messages['created']); ?>  
                                        </td>
                                        
                                        <td><a class="btn btn-xs btn-default btn-round" href="<?php echo base_url(); ?>admin/contactMessageView/<?php echo $messages['id']; ?>"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                <?php } ?>
                                     <?php if (count($arr_message_details) > 0) { ?>
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#product_datatable').DataTable({
        });    
    });
</script>

<script>
//    $(document).ready(function (){
//        $("#product_datatable").dataTable();
//        
//        //ordering: false,
//   //"bSort" : false
//    });
    
    
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