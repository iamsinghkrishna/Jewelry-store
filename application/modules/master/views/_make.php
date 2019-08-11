<?php // var_dump($make_detail);die;               ?>
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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Make</h2>
                    <button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target=".id_md_add_make"><i class="fa fa-plus-circle"> Add Make</i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="make_datatable" class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($make_detail))  ?>
                            <?php foreach ($make_detail as $mkData) { ?>
                                <tr id="mk_<?php echo $mkData['id'] ?>">

                                    <td><?php echo $mkData['name'] ?></td>
                                    <td>
                                        <?php echo $mkData['isactive'] == '0' ? 'Active' : 'In - Active' ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-round btn-xs btn-default" data-toggle="modal" data-target=".id_md_edit_make_<?php echo $mkData['id'] ?>"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteMake(<?php echo $mkData['id'] ?>)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>       
</div>


<!-- Add Make modal -->
<?php $this->load->view('modal/_modal_add_make'); ?>
<?php $this->load->view('modal/_modal_edit_make'); ?>


<!-- /modals -->
<script>
    $(document).ready(function () {
        $("#make_datatable").dataTable();

        $("#id_add_more_mk").click(function () {
            var count = parseInt($("#make_count").val());
            var count = count + 1;
            $("#make_count").val(count);
            $('#dv_add_more_make').append('<div class="form-group"><label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name">Make Name <span class="required">*</span><input placeholder="Make Name" type="text" id="make_name" name="make_name[]" required="required" class="form-control col-md-7 col-xs-12"></label></div><div class="form-group"><label class="control-label col-md-6 col-sm-3 col-xs-12" for="make_name">Description<span class="required">*</span><div class="control-group"><textarea id="message" required="required" class="form-control" name="make_description[]" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea></div></label><input hidden="" id="make_count" value="1"><div id="dv_add_more_make"></div></div>');
            $('#tags_' + count).tagsInput({
                width: 'auto'
            });
        });
        $("#btn_toggl_vw").click(function () {
            $("#id_list_attribute_form").toggle();
            $("#id_add_attribute_form").toggle();
            $("#btn_toggl_vw").toggle();
        });
        $("#btn_cancel_vw").click(function () {
            $("#id_list_attribute_form").toggle();
            $("#id_add_attribute_form").hide();
            $("#btn_toggl_vw").toggle();
        });

    });

</script>
<script>
    function deleteMake(make_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>master/make/delete/' + make_id,
            success: function (data) {
                $("#mk_" + make_id).remove();
            }
        });


    }
</script>