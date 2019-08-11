
<?php // echo '<pre>', print_r($prodcut_cat_detail);die;       ?>
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
                    <h2>Add Product Category</h2>
                    <button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target=".id_mdl_add_prodcut_cat"><i class="fa fa-plus-circle"> Add Product Category </i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <table class="table">
                        <thead>
                        <th>Name</th>
                        <th>#</th>

                        </thead>
                        <tbody>
                            <?php if (!empty($prodcut_cat_detail) && isset($prodcut_cat_detail))  ?>
                            <?php foreach ($prodcut_cat_detail as $key => $pData) { ?>
                                <tr id="pc_<?php echo $pData['id'] ?>">
                                    <td><?php echo $pData['name'] ?></td>
                                    <td>
                                        <button class="btn btn-round btn-xs btn-default" data-toggle="modal" data-target=".id_pc_edit_make_<?php echo $pData['id']; ?>"><i class="fa fa-pencil"></i></button>
                                        <?php if($key > 2) {?>
                                        <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteProductCategory(<?php echo $pData['id']; ?>)"><i class="fa fa-trash"></i></button>
                                        <?php } ?>
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

<!--Modal-->
<?php $this->load->view('modal/modal_add_product_cat'); ?>
<?php $this->load->view('modal/modal_edit_product_cat'); ?>
<!--Modal-->
<script>
    $(document).ready(function () {

        $("#id_am_attr").click(function () {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/ajax_product_category',
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('#id_dv_add_more_attr').append(parsed.content);
                    $('#id_remove_btn').append('');
                }
            });
        });
    });
</script>

<script>
    function deleteProductCategory(product_cat_id) {
        if(confirm('Are you sure to delete this category')){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/product_category/delete/' + product_cat_id,
            success: function (data) {
                $("#pc_" + product_cat_id).remove();
                alert('Category deleted successfully');
            }
        });
    }
    }
</script>