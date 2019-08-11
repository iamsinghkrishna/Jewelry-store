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
                    <h2>Contact Message</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                   

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $arr_message_details[0]['name']; ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                      <br/>
                    <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $arr_message_details[0]['email']; ?>
                        </div>
                    </div>
                     <br/>
                      <div class="clearfix"></div>
                       <br/>
                    <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Message</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo $arr_message_details[0]['message']; ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
 <br/>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <a href="<?php echo base_url(); ?>admin/contactMessageList" class="btn btn-primary">Back</a>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>     
</div>




