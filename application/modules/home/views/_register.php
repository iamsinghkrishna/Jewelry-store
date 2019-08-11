<div class="category_inner_header">

    <div class="container">

        <div class="category_header_div">



            <h2>Register</h2>



        </div>

    </div>

</div>





<section class="login_form_div margin-top-55">

    <div class="container">

        <div class="form_center col-md-5">

            <div id="st_message"></div>

            <div class="tab-pane" id="Registration"></div>

            <form  class="" id="signupForm">



                <p class="form-row form-row-wide">

                    <label for="username">First Name<span class="required">*</span></label>

                    <input type="text" class="input-text" name="first_name" id="first_name" value="" required="">

                </p>

                <p class="form-row form-row-wide">

                    <label for="username">Last Name<span class="required">*</span></label>

                    <input type="text" class="input-text" name="last_name" id="username" value="" required="">

                </p>

                <p class="form-row form-row-wide">

                    <label for="username">Email<span class="required">*</span></label>

                    <input type="email" class="input-text" name="email" id="email" value="" required="">

                </p>

<!--                 <p class="form-row form-row-wide">

                    <label for="username">Mobile<span class="required">*</span></label>

                    <input type="tel" class="input-text" name="phone" id="mobile" value="" required="" maxlength="12">

                </p>-->

               

                <p class="form-row form-row-wide">

                    <label for="password">Password <span class="required">*</span></label>

                    <input class="input-text" type="password" name="password" id="password">

                </p>

                <p class="form-row form-row-wide">

                    <label for="password">Confirm Password <span class="required">*</span></label>

                    <input class="input-text" type="password" name="password_confirm" id="password_confirm">

                </p>





                <p class="form-row">

                        <!--<input type="hidden" id="_wpnonce" name="_wpnonce" value="1e80f4051a"><input type="hidden" name="_wp_http_referer" value="/wordpress/boutique2/my-account/">				<label for="rememberme" class="inline">-->

                                <!--<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me				</label>-->

                    <!--button type="submit" class="button" name="login" >Register</button-->
                    <input  type="submit" class="button" name="login" id="registerBtn" value="Register">


                </p>

                <p class="lost_password">

                    You Have an account?<a href="<?php echo base_url()?>home/login"> Login</a>

                </p>





            </form>





        </div>

    </div>

</section>



<div class="clearfix"></div>

<script>

      $(document).ready(function () {

        $("#signupForm").submit(function (e) {
            $('#registerBtn').attr('disabled',true);
            e.preventDefault();

            var datastring = $("#signupForm").serialize();

//            console.log(datastring);return false;

            $.ajax({

                url: base_url + 'auth/auth/ajaxUserRegisterSubmit',

                data: datastring,

                type: 'POST',

                dataType: 'JSON',

                success: function (response) {
                   
                    console.log(response);
                    var msg = response.msg;
                    if (response.status === '1') {
                        
                        //$("#st_message").html('<div class="alert alert-success"><strong>Success! </strong>' + response.msg + '</div>');
                         
                        $.toaster({priority: 'success', title: 'Registration', message: msg});

                        window.setTimeout(function () {

                            //location.reload()
                            window.location.href = "<?php echo base_url(); ?>home";

                        }, 3000);

                    } else {
                        $.toaster({priority: 'danger', title: 'Registration', message: msg});
                         $('#registerBtn').attr('disabled',false);
                        //$("#st_message").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.msg + '</div>');

                    }

                },

                error: function (error) {
                    
//                     $.toaster({priority: 'success', title: 'Registration', message: 'Registration successfull.We have send you the activation link.'});
//                     
//                     window.setTimeout(function () {
//
//                            //location.reload()
//                            window.location.href = "<?php echo base_url(); ?>home";
//
//                        }, 2000);
                     
                     
                    console.log(error);

                }

            });

        });

    });

</script>