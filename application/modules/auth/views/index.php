<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('index_heading'); ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id="infoMessage"><?php echo $message; ?></div>
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
                <div class="table-responsive">
                    <table id="FlagsExport" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>



                        <tbody>
                            <?php  foreach ($users as $user): ?>
                                <tr>
                                    <td><a data-toggle="modal" href="#viewCandidateDetails_<?php echo $user->id ?>"><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php foreach ($user->groups as $group): ?>
                                            <button class="btn btn-xs btn-default"><i class="fa fa-users"></i> <?php echo anchor("auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br /></button>
                                        <?php endforeach ?>
                                    </td>
                                    <td>
                                        <label class="btn btn-xs btn-default"><i class="fa fa-check"></i>
                                            <?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?>
                                        </label>
                                    </td>

                                    <td>
                                        <label class="btn btn-xs btn-default"><i class="fa fa-pencil"></i>
                                            <?php echo anchor("auth/edit_user/" . $user->id, 'Edit'); ?>
                                        </label>
                                        <label class="btn btn-xs btn-default"><i class="fa fa-pencil"></i>
                                            <?php echo anchor("auth/delete_user/" . $user->id, 'Delete'); ?>
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


                <p><?php // echo anchor('auth/create_user', lang('index_create_user_link'))   ?>  <?php // echo anchor('auth/create_group', lang('index_create_group_link'))   ?></p>
            </div>
        </div>
    </div>
</div>
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
                     columns: [0,1,2,3,4]
                 }
            },
            {
                extend: 'excel',
                footer: false,
                 exportOptions: {
                     columns: [0,1,2,3,4]
                 }

            },
            {
                extend: 'pdf',
                footer: false,
                 exportOptions: {
                     columns: [0,1,2,3,4]
                 }
            },
            {
                extend: 'print',
                footer: false,
                 exportOptions: {
                     columns: [0,1,2,3,4]
                 }
            }, 
    ]  
        });
    });
</script>

<!--<link type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">-->
<link type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css" rel="stylesheet">
<!--<script type="text/javascript" src="jquery-1.12.0.min.js"></script>-->

<!--<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>-->
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>


<?php
$this->load->view('modal/show_user')?>