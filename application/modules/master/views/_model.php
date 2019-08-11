<?php // var_dump($model_detail);die;              ?>
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
                    <h2>Year</h2>
                    <button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target=".id_mdl_add_year"><i class="fa fa-plus-circle"> Add Model</i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="model_datatable" class="table">
                        <thead>
                            <tr>
                                <th>Make</th>
                                <th>Year</th>
                                <th>Model</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($model_detail))  ?>
                            <?php foreach ($model_detail as $mdlData) { ?>
                                <tr id="md_<?php echo $mdlData['id'] ?>">

                                    <td><?php echo $mdlData['make_name'] ?></td>
                                    <td><?php echo $mdlData['year_name'] ?></td>
                                    <td><?php echo $mdlData['name'] ?></td>
                                    <td>
                                        <?php echo $mdlData['isactive'] == '0' ? 'Active' : 'In - Active' ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-round btn-xs btn-default" data-toggle="modal" data-target=".id_md_edit_make_<?php echo $mdlData['id'] ?>"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteModel(<?php echo $mdlData['id'] ?>)"><i class="fa fa-trash"></i></button>
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


<!-- modal -->
<?php $this->load->view('modal/_modal_add_model'); ?>
<?php $this->load->view('modal/_modal_edit_model'); ?>
<!-- /modals -->
<script>
    $(document).ready(function () {
        $("#model_datatable").dataTable();



    });

</script>
<script>
    function deleteModel(model_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>master/model/delete/' + model_id,
            success: function (data) {
                $("#md_" + model_id).remove();
            }
        });
    }
</script>