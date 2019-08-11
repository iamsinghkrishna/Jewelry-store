<?php $this->load->view('backend/sections/header'); ?>
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<aside class="right-side">
    <section class="content-header">

        <h1>
            Add Blog Category

        </h1>            
        <ol class="breadcrumb">

            <li> <a href="<?php echo base_url(); ?>backend/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>  </li>
            <li> <a href="<?php echo base_url(); ?>backend/blog/blog-category"> Manage Blog Categories</a></li>
            <li>Add Category</li>

        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form name="category_form"  id="category_form" action="<?php echo base_url(); ?>backend/blog/add-category" method="POST" >
                        <div class="box-body">
                            <div class="form-group">
                                <label for="parametername">Category Name<sup class="mandatory">*</sup></label>
                                <input type="text" dir="ltr"  class="form-control" name="category_name" id="category_name" value="" size="80"   />
                            </div>
                            <div class="form-group">
                                <label for="parametername">Parent Category</label>
                                <select id="parent_category" name="parent_category" class="form-control">
                                    <option value="0">No Parent</option>
                                    <?php
                                    foreach ($arr_categories as $blog_category) {
                                        ?>
                                        <option  value="<?php echo $blog_category['category_id']; ?>"><?php echo $blog_category['category_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes" id="btnSubmit">Save </button>
                            <img src="<?php echo base_url(); ?>media/front/img/loader.gif" style="display: none;" id="loding_image">
                        </div>
                    </form>
                </div>
            </div>
            <!--[sortable body]--> 
        </div>
        </div>

        <!--[sortable table end]--> 

        <!--[include footer]--> 
        </div>
        </div>

        <!--including footer here-->
        <?php $this->load->view('backend/sections/footer.php'); ?>

        <script type="text/javascript" language="javascript">
            /* add admin Js */
            jQuery(document).ready(function () {

                jQuery("#category_form").validate({
                    errorElement: 'div',
                    rules: {
                        category_name: {
                            required: true
                        },
                        parent_category: {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() ?>backend/blog/check-blog-category",
                                type: "post",
                                data: {
                                    category_name: function () {
                                        return jQuery('#category_name').val();
                                    }
                                }
                            }
                        }
                    },
                    messages: {
                        category_name: {
                            required: "Please enter category name."
                        },
                        parent_category: {
                            required: "Please select the parent category.",
                            remote: "Category name already exists with this parent category. "
                        }
                    },
                    submitHandler: function (form) {
                        $("#btnSubmit").hide();
                        $('#loding_image').show();
                        form.submit();
                    }
                });
            });
        </script>