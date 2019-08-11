<div class="category_inner_header">
<div class="container">
<div class="category_header_div">
<script src="<?php echo base_url(); ?>backend/build/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>backend/build/js/validate.min.js"></script>

<h2>Contact Us</h2>

</div>
</div>
</div>

<div class="container">
        <div class="row">
            <div class="col-sm-6">
                

                <div class="kt-contact-form margin-top-60">
                    <form name="frm_send_message" id="frm_send_message" action="<?php echo base_url(); ?>home/sendMessage" method="POST"enctype="multipart/form-data" >
                    <div id="message-box-conact"></div>
                    <h3 class="title" style='text-transform: none'>
                        <!--REACH US FOR ANY QUESTIONS YOU MIGHT HAVE-->
                        
                        There is a Vaskia team member available around the clock to answer any of your queries! Leave us a message and we'll get back to you ASAP.
                    
                    </h3>
                    <p>
                        <input id="name" name="name" required="required" type="text" value="<?php if($dataHeader['first_name'] != ''){ echo $dataHeader['first_name'].' '.$$dataHeader['first_name']; } ?>" placeholder="Your name">
                    </p>
                    <p>
                        <input id="email" name="email" required="required" type="text" placeholder="Your Email" value="<?php echo $dataHeader['email']; ?>">
                    </p>
                    <p>
                        <textarea id="message" name="message" placeholder="Your message!"></textarea>
                    </p>
                    <!--<button id='btn-send-contact' class="button">SEND MESSAGE</button>-->
                    <img src="<?php echo base_url(); ?>assets/images/xloading.gif" id="loader" name="loader" style="display:none;" />
                    <input type="submit" id="btn_submit" name="btn_submit" value="SEND MESSAGE" class="button" />
                          
                    </form>
                    <div id="st_message"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="margin-top-60">
                    
 
<iframe width="600" height="450" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q=7263+Southwest+57th+Avenue+South+Miami+33143&key=AIzaSyBpiGf-qNlzyMrRhEbxO8mZG5QvHYHvd2c" allowfullscreen></iframe>

                    <h6 class="margin-top-20">GIVE US A CALL</h6>
                    <p class="roboto">Want to speak with a sales representative? Drop us a line and we’d be happy to answer any questions!</p>
                    <p style="font-size: 18px; color: #222; font-weight: bold;"><i class="fa fa-phone"></i> +1 (305) 988-3585</p>
                </div>
            </div>
        </div>
    </div>
<!--			<div class="margin-top-60 margin-bottom-30">
       <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="element-icon style2">
                        <div class="icon"><i class="flaticon flaticon-origami28"></i></div>
                        <div class="content">
                            <h4 class="title">FREE SHIPPING WORLD WIDE</h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="element-icon style2">
                        <div class="icon"><i class="flaticon flaticon-curvearrows9"></i></div>
                        <div class="content">
                            <h4 class="title">MONEY BACK GUARANTEE</h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="element-icon style2">
                        <div class="icon"><i class="flaticon flaticon-headphones54"></i></div>
                        <div class="content">
                            <h4 class="title">ONLINE SUPPORT 24/7</h4>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>-->
<script src="<?php echo base_url(); ?>backend/build/js/validation.js"></script>