<div class="menu_section clearfix">
    <h3>Admin Panel</h3>

    <ul class="nav side-menu">
        <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Dashboard </a></li>
        <?php if ($this->ion_auth->is_admin()) { ?>
            <li ><a><i class="fa fa-user"></i> Manage User <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>auth">All Users</a></li>
<!--                    <li><a href="<?php echo base_url(); ?>auth/create_user">Create User</a></li>
                    <li><a href="<?php echo base_url(); ?>auth/create_group">Create Group</a></li>-->
                </ul>
            </li>
        <?php } ?>
    </ul>


</div>
<?php if ($this->ion_auth->is_admin()) { ?>
    <div class="menu_section clearfix">
        <h3>Manage Product</h3>

        <ul class="nav side-menu">

            <li ><a href="#"><i class="fa fa-shopping-bag "></i> Products <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/product">Manage Products </a></li>
                    <li><a href="<?php echo base_url(); ?>admin_library/summary_discounts">Manage Coupon </a></li>
                    <li><a href="<?php echo base_url(); ?>admin/product_history">Manage Product History </a></li>
                    <li><a href="<?php echo base_url(); ?>admin/update_bulk_inventory">Bulk Inventory Update</a></li>
                    <!--<li><a href="<?php echo base_url(); ?>admin/attirbutes">Product Level</a></li>-->
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>admin/orders"><i class="fa fa-tags"></i> Orders </a></li>

            <li><a href="<?php echo base_url(); ?>admin/product_category"><i class="fa fa-product-hunt"></i> Product Category </a></li>
            <li ><a><i class="fa fa-list-alt"></i> Manage Sub Category <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/attirbutes">Create Sub Category</a></li>
                    <!--<li><a href="<?php // echo base_url();    ?>admin/attirbutes">Product Level</a></li>-->
                </ul>
            </li>


            <li><a href="<?php echo base_url(); ?>admin/subAttributesList"><i class="fa fa-list-ol" aria-hidden="true"></i> Manage Sub Attributes </a></li>

            <li ><a><i class="fa fa-gift"></i> Manage Offers <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/offer">Product Offers</a></li>
                </ul>
            </li>
    <!--        <li ><a><i class="fa fa-medium"></i> Blog Management <span class="fa fa-medium"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/blog">Add Blog</a></li>
                    <li><a href="<?php echo base_url(); ?>admin/testimonial/list">Add Testimonial</a></li>
                    <li><a href="<?php echo base_url(); ?>master/model">Add Model</a></li>
                </ul>
            </li>-->
            <li ><a><i class="fa fa-hashtag"></i> Slider <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/slider">Add Slider</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url() ?>admin/newsletter-subscriber/list"><i class="fa fa-newspaper-o"></i> Newsletter Subscriber </a>

            </li>
            <li><a href="<?php echo base_url() ?>admin/promotion/lists"><i class="fa fa-envelope"></i> Promotions </a>

            </li>

            <li><a href="<?php echo base_url() ?>admin/featured_category"><i class="fa fa-check" aria-hidden="true"></i> Featured Category </a>

            </li>
            <li><a href="<?php echo base_url() ?>admin/contactMessageList"><i class="fa fa-save" aria-hidden="true"></i> Manage Contact Messages </a>

            </li>
        </ul>
    </div>

    <div class="menu_section clearfix">
        <h3>Inventory</h3>

        <ul class="nav side-menu">
            <?php if ($this->ion_auth->is_admin()) { ?>
                <li><a href="<?php echo base_url() ?>admin/inventory/stock"><i class="fa fa-save" aria-hidden="true"></i> Manage Clover Stock </a>

                </li>
                <li ><a><i class="fa fa-user"></i> Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php echo base_url(); ?>admin/inventory/orders">All Clover Orders</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/inventory/list">Clover Products</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/inventory/weekly_inventory">Weekly Invetory Report</a></li>
                        
                    </ul>
                </li>
            <?php } ?>
        </ul>


    </div>
<?php } ?>

