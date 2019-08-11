<div class="category_inner_header">

    <div class="container">

        <div class="category_header_div">



            <h2>Login</h2>



        </div>

    </div>

</div>





<section class="login_form_div margin-top-55">

    <div class="container">

        <div class="form_center col-md-5">



            <form method="post" class="login" id="loginForm">

				<p>
                    <?php 
                        $error_message =  $this->session->userdata('blockMessage'); 
                        if($error_message != ''){ ?>
                    <label style="color:red;"> <?php echo  $error_message; ?> </label>
                          <?php
                          $this->session->unset_userdata('blockMessage');
                            ?>
                            
                        <?php }
                    ?>
                </p>




                <p class="form-row form-row-wide">

                    <label for="username">Email ID <span class="required">*</span></label>

                    <input type="text" class="input-text" name="username" id="username" value="">

                </p>

                <p class="form-row form-row-wide">

                    <label for="password">Password <span class="required">*</span></label>

                    <input class="input-text" type="password" name="password" id="password">

                </p>





                <p class="form-row">

                        <!--<input type="hidden" id="_wpnonce" name="_wpnonce" value="1e80f4051a"><input type="hidden" name="_wp_http_referer" value="/wordpress/boutique2/my-account/">				<label for="rememberme" class="inline">-->

                                <!--<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember me				</label>-->

                    <input type="submit" class="button" name="login" id="btnLogin" value="Login">



                </p>

               <p class="lost_password">
                   Don't Have an account?<a href="<?php echo base_url() ?>home/register"> Signup</a> OR <a href="<?php echo base_url() ?>home/forgotPassword">Lost your password? </a>
                </p>
<?php if(isset($authUrl_g)) ?>
                <a id="btn-fblogin" href="<?= $authUrl ?>" class="btn btn-primary"><i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook</a><span> <b>OR</b></span>
                <a id="btn-google" href="<?php echo $authUrl_g ?>" class="btn btn-danger"><i class="fa fa-google-plus" aria-hidden="true"></i> Login with Google</a>
            </form>





        </div>

    </div>

</section>



<div class="clearfix"></div>

<script>

    $(document).ready(function () {

//        alert('hi');

        $("#loginForm").submit(function (e) {

            $("#btnLogin").val("Login...");
             $('#btnLogin').prop('disabled', true);

            e.preventDefault();

            var datastring = $("#loginForm").serialize();

            console.log(datastring);

//            return false;

            $.ajax({

                url: base_url + 'auth/auth/ajaxLoginSubmit',

                data: datastring,

                type: 'POST',

                dataType: 'JSON',

                success: function (response) {
                    
                    if (response.status === '1') {
                        $("#btnLogin").val("Login Success...");

                        $.toaster({priority: 'success', title: 'Login', message: response.msg});

                        window.setTimeout(function () {

                            location.href='<?php echo base_url()?>home'

                        }, 3000);

                    } else {
                    $("#btnLogin").val("Login");
                    $('#btnLogin').prop('disabled', false);
                        $.toaster({priority: 'danger', title: 'Fail', message: response.msg});

                    }

                },

                error: function (error) {

                    console.log(error);

                }

            });

        });

    });

</script>