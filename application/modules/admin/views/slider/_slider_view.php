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
                    <h2>Slider</h2>
                    <button id="btn_toggl_vw" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Slider</button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div id="id_list_attribute_form">
                        <table id="attr_datatable" class="table">
                            <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>Title</th>
                                    <th>Slide Img</th>
                                    <th>Description </th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <?php
                            // print_r($slider);
                            foreach ($slider as $slide) {
                                ?>
                                <tbody>

                                    <tr id="attr_<?= $slide['id'] ?>">
                                            <!--<td>1</td>-->
                                        <td><?= $slide['title'] ?></td>
                                        <td>
                                            <img class="img-responsive img-thumbnail p_img_50 " src="<?= base_url() ?><?= $slide['banner_image'] ?>" alt="slider_img">

                                        </td>
                                        <td style="width: 50%">
                                            <?= $slide['description'] ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-round btn-xs btn-default"  href="<?php echo base_url(); ?>admin/slider/edit/<?php echo $slide['id'] ?>"><i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteAttribute(<?php echo $slide['id']; ?>)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>

                                </tbody>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div id="id_add_attribute_form" hidden="">
                        <form action="<?php echo base_url(); ?>admin/slider/add_slider/add" id="demo-form2"  name ="demo-form2"   data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="title" id="title"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea type="text" name="description" id="description"  class="form-control col-md-7 col-xs-12" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Style<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="product_category" name="style" name="style" class="form-control" required="required" placeholder="Select Style">
                                        <option value="">Select Style</option>
                                        <option value="top">Top</option>
                                        <option value="bottom">Bottom</option>
                                        <option value="right">Right</option>
                                        <option value="left">Left</option>
                                        <option value="center">Center</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Banner Image<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="slider" id="slider" required="required" class="form-control col-md-7 col-xs-12" placeholder="Values" onchange="chkFile(this.value,'slider');">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">link
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="link" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">
                                </div>
                            </div>


                            <div class="clearfix"></div>


                            <div id="file_error"></div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                                    <!--<button class="btn btn-success ">Submit</button>-->
                                    <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-success " />
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    
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
<?php //$this->load->view('modal/modal_edit_pa');  ?>

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
    function deleteAttribute(id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/slider/delete/' + id,
            success: function (data) {

                $('#attr_' + id).remove();
                window.location.reload();

            }
        });
    }
//    function validate() {
//        //alert('test');
//        $("#file_error").html("");
//        $(".demoInputBox").css("border-color", "#F0F0F0");
//        var file_size = $('#file1')[0].files[0].size;
//        console.log(file_size);
//        if (file_size > 123981) {
//            //$('#file1')[0].val('');
//            $("#file1").val("");
//            alert('File size is greater than 2MB');
//            $("#file_error").html("File size is greater than 2MB");
//            $(".demoInputBox").css("border-color", "#FF0000");
//            return false;
//        }
//        return true;
//    }
</script>

