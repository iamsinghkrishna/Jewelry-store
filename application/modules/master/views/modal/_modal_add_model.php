<div class="modal fade id_mdl_add_year" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Model</h4>
            </div>
            <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/model/add"   class="">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="control-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="" for="make_name">Make <span class="required">*</span></label>
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'id_make',
                                    'name' => 'make',
                                    'class' => 'form-control',
                                    'required' => 'required'
                                        ), $make_dropdown
                                );
                                ?>


                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="control-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="" for="yaer">year <span class="required">*</span></label>
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'id_year',
                                    'name' => 'year',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'disabled' => 'disabled',
                                        ), $year_dropdown
                                );
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="" for="make_name">Model <span class="required">*</span></label>
                                <input id="tags_1" name="model" type="text" class="tags form-control" value="" />
                                <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //On make change change year
        $("#id_make").change(function () {
//            return false;

            $('select[name="id_year"]').prop("disabled", true);

            $("#product_model").prop("selectedIndex", 0)

            var product_make_id = $("select#id_make option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/make',
                data: {'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="year"]').prop("disabled", false);
                    $('select[name="year"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });
    });
</script>