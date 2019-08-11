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
                    <h2>Category</h2>
                    <button id="btn_toggl_vw" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Category</button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                  <div class="msg_box alert alert-success" id="deleteRecord" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                    <?php
                    echo 'Record deleted successfully!';
                   
                    ?>
                 </div>
                    <div id="id_list_attribute_form">
                        <table id="attr_datatable" class="table">
                            <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>Value</th>
                                   <!--<th>Sub Attributes</th>-->
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($attribute_details))  ?>
                                <?php foreach ($attribute_details as $attr_data) { ?>
                                    <tr id="attr_<?php echo $attr_data['id']; ?>">
                                           
                                        <td><?php echo $attr_data['attrubute_value'] ?></td>

                                        <td>
                                            <?php echo $attr_data['createddate']; ?>
                                            <?php if (!empty($attr_data['sub_attribute_details']) && isset($attr_data['sub_attribute_details'])) { ?>

<!--                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="50%">Name</th>
                                                        <th>Value</th>
                                                    </tr>
                                                    <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>

                                                        <tr>
                                                            <td><?php echo $attr_sub_data['sub_name'] ?> </td>
                                                            <td><?php echo $attr_sub_data['sub_value'] ?></td>
                                                        </tr>

                                                    <?php } ?>
                                                </table>-->
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-round btn-xs btn-default" data-toggle="modal" data-target=".id_pa_edit_<?php echo $attr_data['id']; ?>"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteAttribute(<?php echo $attr_data['id']; ?>)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="id_add_attribute_form" hidden="">
                        <form action="<?php echo base_url(); ?>admin/attirbutes/add" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                             <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Add To clover?
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" name="add_to_clover" value="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Value<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="attribute_value" id="attribute_value" required="required" class="form-control col-md-7 col-xs-12" placeholder="Values">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Category Attribute <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    echo form_dropdown(array(
                                        'id' => 'parent_id',
                                        'name' => 'parent_id',
                                        'class' => 'form-control',
                                            ), $attt_category
                                    );
                                    ?>

                                </div>


                            </div>

<!--                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub-attribute">Sub Attributes <span class="required" ></span>
                                </label>                                

                                <div class="clearfix"></div>
                            </div>-->
                            <!--<div class="clearfix"></div>-->
<!--                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub-attribute"> <span class="required" ></span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <b>Attribute Type:</b>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <p>
                                        Input&nbsp;&nbsp;&nbsp;&nbsp;<input  type="radio"  value="0" id="optionsRadios1" name="attribute_type" required="">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        Dropdown&nbsp;&nbsp;&nbsp;&nbsp;<input  type="radio"  value="1" id="optionsRadios1" name="attribute_type" required="">
                                    </p>
                                </div>
                            </div>-->
<!--                            <div class="form-group">


                                <label for="sub_attribute_name" class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input id="sub_attribute_name" class="form-control col-md-3 col-xs-12" type="text" name="sub_attribute_name[]" placeholder="Name">
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="control-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input id="tags_1" name="tags[]" type="text" class="tags form-control" value="" />
                                            <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <input hidden="" id="tag_count" value="1">
                                <div id="div_add_more"></div>

                                <div class="col-sm-12 col-md-pull-3">
                                    <button id="id_add_tags" type="button" class="pull-right btn btn-round btn-default btn-sm"> <i class="fa fa-plus-circle"></i> Add More </button>
                                </div>
                            </div>-->



                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button id="btn_cancel_vw" type="button" class="btn btn-success">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>
<?php $this->load->view('modal/modal_edit_pa'); ?>

<script>
    $(document).ready(function () {
        $("#attr_datatable").dataTable();
        $("#id_add_tags").click(function () {
            var count = parseInt($("#tag_count").val());
            var count = count + 1;
            $("#tag_count").val(count);
            $('#div_add_more').append('<label for="sub_attribute_name" class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-3 col-sm-3 col-xs-12"> <input id="sub_attribute_name" class="form-control col-md-3 col-xs-12" type="text" name="sub_attribute_name[]" placeholder="Name">    </div>                            <div class="col-md-3 col-sm-3 col-xs-12">                                <div class="control-group">                                    <div class="col-md-12 col-sm-12 col-xs-12">                                        <input id="tags_' + count + '" name="tags[]" type="text" class="tags form-control" value="" />                                        <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>                                    </div>                                </div>                            </div><div class="clearfix"></div>');
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
    function deleteAttribute(attribute_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/attirbutes/delete/' + attribute_id,
            success: function (data) {
                $("#attr_" + attribute_id).remove();
                $('#deleteRecord').css('display','block');
                setTimeout(function(){ 
                  $('#deleteRecord').css('display','none');
                }, 3000);
            }
        });
    }
</script>