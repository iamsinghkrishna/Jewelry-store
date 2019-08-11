<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            
        <div class="page-title">
            <h1>Checkout</h1>  
            <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
        </div> 
    </div>  
    <!-- top page above -->
</div>
<!-- kopa top page -->

<div class="kopa-shop-product-page pt-40 mb-40 checkOutSteps">
    <div class="container">
        <div class="row">
            <div id="main-col" class="col-md-9">    
                <div class="kopa-tab-1">              
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="member_details active"><a aria-controls="memberDetails" role="tab"><i class="fa fa-edit"></i> Member Details</a></li>
                        <li role="presentation" class="payment_details disabled"><a aria-controls="payment" role="tab"><i class="fa fa-money"></i> Payment</a></li>
                        <li role="presentation" class="status_details disabled"><a aria-controls="status" role="tab"><i class="fa fa-check"></i> Status</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content mb-40">
                        <div role="tabpanel" class="tab-pane active member_details" id="memberDetails">
                            <form id="memberDetailsForm" role="form" action="" method="post" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <h4>STEP #1: Tell us about yourself</h4>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>First Name</label>
                                        <input name="first_name" class="form-control" id="first_name" required="required" type="text" placeholder="First Name" value="">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Last Name</label>
                                        <input name="last_name" class="form-control" id="last_name" required="required" type="text" placeholder="Last Name" value="">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Country code</label>
                                        <select name="country_code" id="country_code" class="signin_input form-control -lg">
                                            <option value="0" label="Select a country" selected="selected">Select Country Code</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" class="form-control" id="phone" required="required" type="text" maxlength="10" onkeydown="return isNumberKey(event);" placeholder="Phone Number" value="">
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Email</label>
                                        <input name="email" class="form-control" id="email" required="required" type="text" placeholder="Email Address" value="">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Password</label>
                                        <input name="password" id="password" class="form-control" required="required" type="password" placeholder="Password" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Confirm Password</label>
                                        <input name="confirmpassword" id="confirmpassword" class="form-control" required="required" type="password" placeholder="Confirm Password" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <hr>
                                        <h4>STEP #2: Billing Address</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Address</label>
                                        <input name="address" class="form-control" id="billing_address" required="required" type="text" placeholder="Address" value="">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>City</label>
                                        <input name="billing_city" class="form-control" id="billing_city" required="required" type="text" placeholder="City" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Country</label>
                                        <select name="billing_country" id="billing_country" class="form-control" required="required">
                                            <option value="select">Select Country</option>
                                            <option value='1'>Afghanistan</option><option value='2'>Albania</option><option value='3'>Algeria</option><option value='4'>American Samoa</option><option value='5'>Andorra</option><option value='6'>Angola</option><option value='7'>Anguilla</option><option value='8'>Antarctica</option><option value='9'>Antigua And Barbuda</option><option value='10'>Argentina</option><option value='11'>Armenia</option><option value='12'>Aruba</option><option value='13'>Australia</option><option value='14'>Austria</option><option value='15'>Azerbaijan</option><option value='16'>Bahamas The</option><option value='17'>Bahrain</option><option value='18'>Bangladesh</option><option value='19'>Barbados</option><option value='20'>Belarus</option><option value='21'>Belgium</option><option value='22'>Belize</option><option value='23'>Benin</option><option value='24'>Bermuda</option><option value='25'>Bhutan</option><option value='26'>Bolivia</option><option value='27'>Bosnia and Herzegovina</option><option value='28'>Botswana</option><option value='29'>Bouvet Island</option><option value='30'>Brazil</option><option value='31'>British Indian Ocean Territory</option><option value='32'>Brunei</option><option value='33'>Bulgaria</option><option value='34'>Burkina Faso</option><option value='35'>Burundi</option><option value='36'>Cambodia</option><option value='37'>Cameroon</option><option value='38'>Canada</option><option value='39'>Cape Verde</option><option value='40'>Cayman Islands</option><option value='41'>Central African Republic</option><option value='42'>Chad</option><option value='43'>Chile</option><option value='44'>China</option><option value='45'>Christmas Island</option><option value='46'>Cocos (Keeling) Islands</option><option value='47'>Colombia</option><option value='48'>Comoros</option><option value='49'>Congo</option><option value='50'>Congo The Democratic Republic Of The</option><option value='51'>Cook Islands</option><option value='52'>Costa Rica</option><option value='53'>Cote D'Ivoire (Ivory Coast)</option><option value='54'>Croatia (Hrvatska)</option><option value='55'>Cuba</option><option value='56'>Cyprus</option><option value='57'>Czech Republic</option><option value='58'>Denmark</option><option value='59'>Djibouti</option><option value='60'>Dominica</option><option value='61'>Dominican Republic</option><option value='62'>East Timor</option><option value='63'>Ecuador</option><option value='64'>Egypt</option><option value='65'>El Salvador</option><option value='66'>Equatorial Guinea</option><option value='67'>Eritrea</option><option value='68'>Estonia</option><option value='69'>Ethiopia</option><option value='70'>External Territories of Australia</option><option value='71'>Falkland Islands</option><option value='72'>Faroe Islands</option><option value='73'>Fiji Islands</option><option value='74'>Finland</option><option value='75'>France</option><option value='76'>French Guiana</option><option value='77'>French Polynesia</option><option value='78'>French Southern Territories</option><option value='79'>Gabon</option><option value='80'>Gambia The</option><option value='81'>Georgia</option><option value='82'>Germany</option><option value='83'>Ghana</option><option value='84'>Gibraltar</option><option value='85'>Greece</option><option value='86'>Greenland</option><option value='87'>Grenada</option><option value='88'>Guadeloupe</option><option value='89'>Guam</option><option value='90'>Guatemala</option><option value='91'>Guernsey and Alderney</option><option value='92'>Guinea</option><option value='93'>Guinea-Bissau</option><option value='94'>Guyana</option><option value='95'>Haiti</option><option value='96'>Heard and McDonald Islands</option><option value='97'>Honduras</option><option value='98'>Hong Kong S.A.R.</option><option value='99'>Hungary</option><option value='100'>Iceland</option><option value='101'>India</option><option value='102'>Indonesia</option><option value='103'>Iran</option><option value='104'>Iraq</option><option value='105'>Ireland</option><option value='106'>Israel</option><option value='107'>Italy</option><option value='108'>Jamaica</option><option value='109'>Japan</option><option value='110'>Jersey</option><option value='111'>Jordan</option><option value='112'>Kazakhstan</option><option value='113'>Kenya</option><option value='114'>Kiribati</option><option value='115'>Korea North</option><option value='116'>Korea South</option><option value='117'>Kuwait</option><option value='118'>Kyrgyzstan</option><option value='119'>Laos</option><option value='120'>Latvia</option><option value='121'>Lebanon</option><option value='122'>Lesotho</option><option value='123'>Liberia</option><option value='124'>Libya</option><option value='125'>Liechtenstein</option><option value='126'>Lithuania</option><option value='127'>Luxembourg</option><option value='128'>Macau S.A.R.</option><option value='129'>Macedonia</option><option value='130'>Madagascar</option><option value='131'>Malawi</option><option value='132'>Malaysia</option><option value='133'>Maldives</option><option value='134'>Mali</option><option value='135'>Malta</option><option value='136'>Man (Isle of)</option><option value='137'>Marshall Islands</option><option value='138'>Martinique</option><option value='139'>Mauritania</option><option value='140'>Mauritius</option><option value='141'>Mayotte</option><option value='142'>Mexico</option><option value='143'>Micronesia</option><option value='144'>Moldova</option><option value='145'>Monaco</option><option value='146'>Mongolia</option><option value='147'>Montserrat</option><option value='148'>Morocco</option><option value='149'>Mozambique</option><option value='150'>Myanmar</option><option value='151'>Namibia</option><option value='152'>Nauru</option><option value='153'>Nepal</option><option value='154'>Netherlands Antilles</option><option value='155'>Netherlands The</option><option value='156'>New Caledonia</option><option value='157'>New Zealand</option><option value='158'>Nicaragua</option><option value='159'>Niger</option><option value='160'>Nigeria</option><option value='161'>Niue</option><option value='162'>Norfolk Island</option><option value='163'>Northern Mariana Islands</option><option value='164'>Norway</option><option value='165'>Oman</option><option value='166'>Pakistan</option><option value='167'>Palau</option><option value='168'>Palestinian Territory Occupied</option><option value='169'>Panama</option><option value='170'>Papua new Guinea</option><option value='171'>Paraguay</option><option value='172'>Peru</option><option value='173'>Philippines</option><option value='174'>Pitcairn Island</option><option value='175'>Poland</option><option value='176'>Portugal</option><option value='177'>Puerto Rico</option><option value='178'>Qatar</option><option value='179'>Reunion</option><option value='180'>Romania</option><option value='181'>Russia</option><option value='182'>Rwanda</option><option value='183'>Saint Helena</option><option value='184'>Saint Kitts And Nevis</option><option value='185'>Saint Lucia</option><option value='186'>Saint Pierre and Miquelon</option><option value='187'>Saint Vincent And The Grenadines</option><option value='188'>Samoa</option><option value='189'>San Marino</option><option value='190'>Sao Tome and Principe</option><option value='191'>Saudi Arabia</option><option value='192'>Senegal</option><option value='193'>Serbia</option><option value='194'>Seychelles</option><option value='195'>Sierra Leone</option><option value='196'>Singapore</option><option value='197'>Slovakia</option><option value='198'>Slovenia</option><option value='199'>Smaller Territories of the UK</option><option value='200'>Solomon Islands</option><option value='201'>Somalia</option><option value='202'>South Africa</option><option value='203'>South Georgia</option><option value='204'>South Sudan</option><option value='205'>Spain</option><option value='206'>Sri Lanka</option><option value='207'>Sudan</option><option value='208'>Suriname</option><option value='209'>Svalbard And Jan Mayen Islands</option><option value='210'>Swaziland</option><option value='211'>Sweden</option><option value='212'>Switzerland</option><option value='213'>Syria</option><option value='214'>Taiwan</option><option value='215'>Tajikistan</option><option value='216'>Tanzania</option><option value='217'>Thailand</option><option value='218'>Togo</option><option value='219'>Tokelau</option><option value='220'>Tonga</option><option value='221'>Trinidad And Tobago</option><option value='222'>Tunisia</option><option value='223'>Turkey</option><option value='224'>Turkmenistan</option><option value='225'>Turks And Caicos Islands</option><option value='226'>Tuvalu</option><option value='227'>Uganda</option><option value='228'>Ukraine</option><option value='229'>United Arab Emirates</option><option value='230'>United Kingdom</option><option value='231'>United States</option><option value='232'>United States Minor Outlying Islands</option><option value='233'>Uruguay</option><option value='234'>Uzbekistan</option><option value='235'>Vanuatu</option><option value='236'>Vatican City State (Holy See)</option><option value='237'>Venezuela</option><option value='238'>Vietnam</option><option value='239'>Virgin Islands (British)</option><option value='240'>Virgin Islands (US)</option><option value='241'>Wallis And Futuna Islands</option><option value='242'>Western Sahara</option><option value='243'>Yemen</option><option value='244'>Yugoslavia</option><option value='245'>Zambia</option><option value='246'>Zimbabwe</option>                                           
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>State</label>
                                        <select class="form-control" name="billing_state" id="billing_state">
                                            <option value="select">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Zip</label>
                                        <input name="zip" class="form-control" id="billing_zip" required="required" type="text" onkeydown="return isNumberKey(event);" placeholder="Zip" value="">
                                    </div>
                                </div>
                                <ul class="list-inline">
                                    <li><button type="submit" class="btn kopaBtn" >Next</button></li>
                                </ul>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane payment_details" id="payment">
                            <div class="row">
                                <form id="paymentDetailsForm" role="form" action="" method="post" novalidate="novalidate" class="">
                                    <div class="col-sm-12 form-group">
                                        <h4>STEP #3: Enter payment details</h4>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <ul class="list-inline">
                                            <li>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymentOption" data-payment-type="card" class="paymentOpt" checked> 
                                                    <img src="<?php echo base_url()?>assets/images/visa.png" width="40">
                                                    <img src="<?php echo base_url()?>assets/images/mastercard.png" width="40">
                                                    <img src="<?php echo base_url()?>assets/images/american-express.png" width="40">
                                                    <img src="<?php echo base_url()?>assets/images/discover.png" width="40">
                                                </label>
                                            </li>
                                            <li>
                                                <label class="radio-inline">
                                                    <input type="radio" name="paymentOption" data-payment-type="paypal" class="paymentOpt">
                                                    <img src="<?php echo base_url()?>assets/images/paypal.png" width="40">
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6 form-group creaditCardInfo">
                                        <label>Card Number</label>
                                        <input name="credit_number" class="form-control" required="required" type="text" onkeydown="return isNumberKey(event);" placeholder="Card Number">
                                    </div>
                                    <div class="col-sm-6 form-group securityCode creaditCardInfo">
                                        <label>Security Code 
                                            <span data-toggle="popover" data-trigger="hover" data-html="true" title="CVV" data-content="
                                            <p>Your card code is a 3 or 4 digit number that is found in these locations:</p>
                                            <div class='clearfix'>
                                            <div class='contents'>
                                            <p><strong>Visa/Mastercard</strong></p>
                                            <p>The security code is a 3 digit number on the back of your credit card. It immediately follows your main card number.</p>
                                            <p><strong>American Express</strong></p>
                                            <p>The security code is a 4 digit number on the front of your card, just above and to the right of your main card number.</p>
                                            </div>
                                            <div class='imgBlock'>
                                            <img src='<?php echo base_url()?>assets/images/cvv.png' class=''>
                                            </div>
                                            </div>
                                            ">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        </label>
                                        <input name="security_code" class="form-control" required="required" type="text" onkeydown="return isNumberKey(event);" placeholder="Security Code">
                                    </div>
                                    <div class="col-sm-6 form-group creaditCardInfo">
                                        <label>Expiration Date</label>
                                        <input name="exp_date" class="form-control" required="required" type="text" placeholder="MM/YY">
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="terms" checked> I accept <a href="" target="_blank">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="list-inline">
                                <li>
                                    <form method="POST" action="http://localhost/RPDigitel/frontend/multi_plan_checkout/SetExpressCheckout">
                                        
                                        <div class="center padding-bottom-25">
                                            <input type="hidden" value="" name="amount">
                                            <input type="hidden" value="1" name="plan_id">
                                            <input type="hidden" value="" name="user_id">
                                            
                                            <input type="hidden" value="http://localhost/RPDigitel/subscription" name="success_url">
                                            
                                            <input type="hidden" value="http://localhost/RPDigitel/subscription" name="fail_url">
                                            
                                            <input type="submit" class="btn kopaBtn" value="Submit">
                                            
                                        </div>
                                        
                                    </form>
                                    
                                </li>
                                
                            </ul>
                            
                        </div>
                        <div role="tabpanel" class="tab-pane status_details" id="status">
                            <div class="thankYou text-center">
                                <h3>Thank You</h3>
                                <p class="confirmText">Your subscription has been confirmed.</p>
                                <p>Welcome to ITTires.</p>
                                <p>We are thrilled to have you here and look forward to serving you often!<br> 
                                    Please login to ITTires portal and start enjoying your benefits.<br> 
                                    We have sent you <b>Email Verification link</b> to your email address.<br>
                                    
                                </p>
                                <p>We are happy to assist you in any way we can.</p>
                                <p>You can reach us at:<br>
                                    Contact : +123 456 6789<br>
                                    Email : name@gmail.com 
                                </p>
                                <p>Regards,<br>
                                    ITTires Team.
                                </p>    
                            </div>
                            <!-- <ul class="list-inline">
                                <li><button type="button" class="btn btnRed prev-step">Previous</button></li>
                            </ul> -->
                        </div>
                    </div>
                </div>  
            </div>
            <!-- main column -->

            <div id="sidebar" class="col-md-3">  
                <div class="widget kopa-product-list-widget checkoutOrderWrap">
                    <div class="widget-title title-s2">
                        <h3>ORDER SUMMARY</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table checkoutOrdertable">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td class="text-right">$24.59</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td class="text-right">Free</td>
                                </tr>
                                <tr>
                                    <th>Estimated Tax</th>
                                    <td class="text-right">$24.59</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Price:</th>
                                    <td class="text-right">$50</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="text-center">
                            <button class="btn kopaBtn">Place Order</button>
                        </div>
                    </div>
                </div>
                <!-- kopa product list widget -->
            </div>
            <!-- sidebar -->
            
        </div>
        <!-- row -->
    </div>   
    <!-- container -->    
</div>
<!-- main content -->

<script type="text/javascript">
        
    var payment_successful = "";
    
    if (payment_successful != '') {
        $('li[role=presentation]').removeClass('active');
        $('.tab-pane').removeClass('active');
        $('.status_details').removeClass('disabled').addClass('active');
    }

    var getCityURL = 'http://localhost/RPDigitel/frontend/subscription/getcities';
    var memberDetailsForm_save_URL = "http://localhost/RPDigitel/checkout_save_member"; 

</script>

