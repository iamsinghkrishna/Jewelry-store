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
                    <h2>Products</h2>.
                    
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table-responsive">
                        <form id="form_offer" method="post" action="<?php echo base_url() ?>admin/inventory">
                            <table id="product_offer_dt" class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Product Name</td>
                                        <td>Product Code</td>
                                        <td>Price</td>
                                        <td>Cost</td>
                                        <td>Stock Count</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                </tbody>

                            </table>
                            <div style="text-align:center">
                            <?php if(!$this->uri->segment('4')){?>
                                <a class="btn btn-default btn-xs" href="<?php echo base_url('admin/inventory/list/showlimit')?>">Load more</a>
                                <?php } else{ ?>
                                  <a class="btn btn-default btn-xs" href="<?php echo base_url('admin/inventory/list')?>">Back</a>
    <?php }
                                
?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
    $(document).ready(function () {

        $('#product_offer_dt').DataTable( {
        "ajax": '<?php echo base_url()?>admin/inventory/loadCloverInventory/<?php if($this->uri->segment('4')) echo $this->uri->segment('4')?>',
        "aaSorting": []
    } );
    });
</script>
<script>
    function funEditDiscountedOffer(productId) {
        if ($("#productCheck_" + productId).is(':checked')) {
            $("#id_discount_" + productId).removeAttr('readonly');
            $("#id_discount_" + productId).prop('required', true);
            var max_rate = $("#tr_price_" + productId).text();
            $("#id_discount_" + productId).attr({"max": max_rate});
        } else {
            $("#id_discount_" + productId).attr('readonly',true);
            $("#id_discount_" + productId).prop('required', false);
        }

    }

    function validateQuantity(qty, id) {
        if (qty === '0' || qty < 0) {
            alert("Please enter value greater than zero");
            $("#id_discount_" + id).val("");
            return false;
        }
        if (qty > $("#tr_price_" + id).text()) {
            alert("Current stock is less than quantity");
            $("#id_discount_" + id).val("");
        }
    }

    function updateQuantity(id,val){
        var qty = $("#qty_"+val).val();
        $("#save_"+val).text("Saving..");
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/inventory/updateCloverInventoryStock',
                data: {'item_id': id,'quantity':qty},
                dataType:"JSON",
                success: function (data) {
                    if(data.status === "1"){
                        $("#save_"+val).text("Saved");
                    }else{
                        alert("Something went wrong. Please try again");
                    }
                }
            });
    }
</script>