<script src="<?php echo base_url(); ?>backend/build/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>backend/build/js/validate.min.js"></script>
<div class="category_inner_header">

    <div class="container">

        <div class="category_header_div">



            <h2>Forgot Password</h2>



        </div>

    </div>

</div>





<section class="login_form_div margin-top-55">

    <div class="container">

        <div class="form_center col-md-5">

            <div id="st_message"></div>

            <div class="tab-pane" id="Registration"></div>
            
                <form name="forgotPassword" id="forgotPassword" action="<?php echo base_url(); ?>home/forgotPassword" method="POST" >



                <p class="form-row form-row-wide">

                    <label for="username">email address <span class="required">*</span></label>

                    <input type="text" class="input-text" name="username" id="username" value="" required="">

                </p>

                



                <p class="form-row">

                        <!--<input type="hidden" id="_wpnonce" name="_wpnonce" value="1e80f4051a"><input type="hidden" name="_wp_http_referer" value="/wordpress/boutique2/my-account/">				<label for="rememberme" class="inline">-->

                                <!--<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me				</label>-->

                    <!--button type="submit" class="button" name="login" >Register</button-->
                    <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;margin-left:158px;" />
                    <input  type="submit" class="button" id="btn_submit" name="login" value="Submit">


                </p>

                <p class="lost_password">

                    You Have an account?<a href="<?php echo base_url()?>home/login"> Login</a> OR  <a href="<?php echo base_url() ?>home/register"> Signup</a>

                </p>





            </form>





        </div>

    </div>

</section>



<div class="clearfix"></div>



<script src="<?php echo base_url(); ?>backend/build/js/validation.js"></script>