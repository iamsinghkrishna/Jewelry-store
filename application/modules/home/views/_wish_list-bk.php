<div class="category_inner_header">
    <div class="container">
        <div class="category_header_div">

            <h2>My Wishlist</h2>

        </div>
    </div>
</div>
<!-- ./Home slide -->

<section class="cart_div">
    <div class="main-container no-sidebar">
        <div class="container">
            <div class="main-content">
                <div class="row">

                    <div class="col-sm-12 col-md-8">
                        <?php if (isset($product_details) && !empty($product_details)) { ?>

                            <?php // if (isset($cart_items) && !empty($cart_items)) {    ?>
                            <div class="table-responsive">    


                                <?php
//                        echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
                                ?>
                                <table class="table table-hover cartTable">
                                    <thead>
                                        <tr>
                                            <th >Sr No</th>
                                            <!--<th>Product Name</th>-->
                                            <th >Product Image</th>
                                            <th >Product Name</th>
                                            <th >Price</th>
                                            <!--<th class="text-center" width="100">Unit Price</th>-->

                                            <th > Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        echo "<pre>";
//                                        print_r($product_details_tes);
//                                        die;
                                        if (isset($product_details))
                                            $count = 1;
                                        $i = 0;
                                        foreach ($product_details as $key => $wish) {
//                                            print_r($wish);die();
                                            if (!empty($wish['product_name'])) {
                                            ?>
                                   <tr id="arr_<?php echo $wish['id']; ?>">
                                                <td><?php echo $count++; ?></td> 
                                                <td> <a href="<?php echo base_url() ?>home/shop_product/<?php echo $wish['product_id'] ?>/<?php echo base64_encode($wish['product_name']['category_id']); ?>">
                                                        <img src="<?php echo ($wish['product_images_details'][0]['url'] !='') ? base_url() . $wish['product_images_details'][0]['url'] : base_url().'assets/images/product-no-image2.jpg'; ?>" class="user-img" style=" width:50px;height: 50px;"></a></td> 
                                                <td><?php echo $wish['product_name']['product_name']; ?></td> 
                                                <td><?php echo $wish['product_name']['price']; ?></td> 
                                                <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteWishlist(<?php echo $wish['id']; ?>)"></i></td> 
                                        </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                                 <button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block">Share this wishlist <i class="fa fa-send"></i></button>



                            </div>
                        <?php } else { ?>
                            <div class="text-center">
                                <p><i class="fa fa-5x fa-heart text-danger"></i></p>
                                <p>Your wishlist is empty</p>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="box-cart-total">
                            <h2 class="title">My Account</h2>
                            <table class="table checkoutOrdertable">
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url(); ?>home/orders">My Orders</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="active">My Wishlist</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url(); ?>home/cart" >My Cart</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url(); ?>home/checkout">Checkout</a>
                                    </td>
                                </tr>
                            </table>

                           

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- line modal -->
    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Share Wish List</h3>
                </div>
                <div class="modal-body">

                    <!-- content goes here -->
                    <form id="emlfrm" action="<?php echo base_url() ?>home/shareWishList" method="post">
                        <div id="applystatus">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="email" name="email[]" required class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="col-md-3">
                                    <button id="addmorepaymentplans" type="button" class="Custom btn btn-success btn-xs"><i class="fa fa-plus"></i></button>

                                </div>
                            </div>
                        </div>

                        <div id="custompaymentplans"></div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>



                </div>
            </div>
        </div>
</section>
<script>
    function deleteWishlist(id)
    {
//        alert(id);

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>home/add_wishlist/delete',
            data: {'wishlist_id': id},
            success: function (data) {
                $('#arr_' + id).remove();
                $.toaster({priority: 'success', title: 'Wishlist', message: 'Product has been removed from wishlist.'});
                location.reload();
            }
        });
    }

    $(document).ready(function () {
        $("#addmorepaymentplans").click(function () {
//        alert();
            $("#custompaymentplans").append('<div class="form-group"><div class="row"><div class="col-md-9"><input type="email" required name="email[]" class="form-control" id="exampleInputEmail1" placeholder="Enter email"></div><div class="col-md-3"><button  type="button" class="btn rempaymentplans btn-danger btn-xs"><i class="fa fa-times"></i></button></div></div></div>');
//            $("#custompaymentplans").append('<div class="item form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"></label><div class="col-md-6 col-sm-6 col-xs-12"><input class="form-control col-md-7 col-xs-12"  name="payment_plans[]" type="file" accept="image/pdf"></div> <div class="col-md-3 col-sm-3 col-xs-12"><button  type="button" class="btn rempaymentplans btn-danger btn-xs"><i class="fa fa-times"></i></button></div></div>');
        });
        $("#custompaymentplans").on('click', '.rempaymentplans', function () {
            $(this).parent().parent().remove();
        });



        $("#emlfrm").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#emlfrm")[0]);
//            alert($(this).serialize());
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'json',
                success: function (response) {
                    if (response.status === '1') {
                        $("#applystatus").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button><strong>' + response.msg + '</div>');
                        $('#emlfrm')[0].reset();
                        $('label.label-error').remove();
                        $('input').removeClass('label-error');
                        $('#applystatus').focus();
                        setTimeout(function () {
                            $('#squarespaceModal').modal('hide');
                        }, 4000);
                        return true;
                    } else {
                        $.each(response.errors, function (i, v) {
                            console.log(i + " => " + v); // view in console for error messages 
                            var msg = '<label class="label-error" for="' + i + '">' + v + '</label>';
                            $('input[name="' + i + '"]').addClass('label-error').after(msg);
                        });
//                    var keys = Object.keys(response.errors);
//                    $('input[name="' + keys[0] + '"]').focus();
                    }
                }
            });

        });
    });
</script>


