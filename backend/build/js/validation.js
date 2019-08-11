

jQuery(document).ready(function () {

//    refreshCaptha();

    /*Contact Us Form Validation Start */
    var base_url = $('#base_url').val();

    $.validator.addMethod('positiveNumber', function (value) {
        return Number(value) > 0;
    }, 'Please enter a positive number.');

    jQuery.validator.addMethod('chk_username_field', function (value, element, param) {
        if (value.match('^[a-zA-Z0-9-_.]{5,20}$')) {
            return true;
        } else {
            return false;
        }

    }, "");

    jQuery.validator.addMethod('chk_name', function (value, element, param) {
        if (value.match('^[a-zA-Z]{1,20}$')) {
            return true;
        } else {
            return false;
        }

    }, "");
    jQuery.validator.addMethod('checkOwnMail', function (value, element, param) {
        if ($("#ownEmail").val() == value) {
            return false;
        } else {
            return true;
        }

    }, "");
    jQuery.validator.addMethod("numbersonly", function (value, element) {
        return this.optional(element) || /^\$?[0-9][0-9\,]*(\.\d{1,2})?$|^\$?[\.]([\d][\d]?)$/.test(value);
    }, "Please enter valid price.");

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Please enter valid name");

    jQuery.validator.addMethod("noSpace", function (value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Please enter valid characters");


    jQuery.validator.addMethod('chk_full_name', function (value, element, param) {
        if (value.match("^[a-zA-Z]([-']?[a-zA-Z]+)*( [a-zA-Z]([-']?[a-zA-Z']+)*)+$")) {
            return true;
        } else {
            return false;
        }

    }, "");
    jQuery.validator.addMethod("validUrl", function (value, element) {
        return this.optional(element) || /^(http(s)?:\/\/)?(www\.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/i.test(value);
    }, "Please enter valid url.");

    jQuery.validator.addMethod("phoneno", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "Please enter a valid phone number");


    jQuery.validator.addMethod("password_strenth", function (value, element) {
        return isPasswordStrong(value, element);
    }, "Password must be combination of at least 1 number, 1 special character, 1 lower case letter and 1 upper case letter with minimum 8 characters");


    jQuery.validator.addMethod("specialChars", function (value, element) {
        var regex = new RegExp("^[a-zA-Z0-9.@_-]+$");
        var key = value;
        if (!regex.test(key)) {
            return false;
        }
        return true;
    }, "please enter a valid value for the field.");





    jQuery("#reg_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            first_name: {
                required: true,
                lettersonly: true
            },
            last_name: {
                required: true,
                lettersonly: true
            },
            company: {
                // required: true,
                lettersonly: true
            },
            email: {
                required: true,
                email: true,
                checkOwnMail: true,
//                remote: {
//                    url: 'chk-external-email-duplicate',
//                    method: 'post'
//                }

            },
            phone: {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 12,
                phoneno: true,
            },
            password: {
                required: false,
                minlength: 8,
//                password_strenth: true
            },
            password_confirm: {
                required: false,
                equalTo: "#password"
            },

        },
        messages: {
            first_name: {
                required: 'Please enter first name.',
                lettersonly: "Please enter valid name."
            },
            last_name: {
                required: 'Please enter last name.',
                lettersonly: "Please enter valid name."
            },

            email: {
                required: 'Please enter email.',
                email: 'Please enter valid email id.',
                checkOwnMail: "Please use other email.You can't rate to yourself.",
                remote: "This email is already used for the external."
            },
            phone: {
                required: 'Please enter mobile number.',
                number: 'Please enter valid mobile number.',
                minlength: 'Please enter exactly 10 digits.',
                phoneno: 'Please enter valid mobile number.',
            },
            password: {
                required: 'Please enter a password',
                minlength: 'Please enter at least eight characters',
            },
            password_confirm: {
                required: 'Please confirm above password',
                equalTo: 'These passwords dont match',
            },

        },
        submitHandler: function (form) {
            //form.submit();
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('reg_form').submit();
        }
    });



    jQuery("#group").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            group_name: {
                required: true,
                lettersonly: true
            },
            description: {
                required: true,
                // lettersonly: true
            },

        },
        messages: {
            group_name: {
                required: 'Please enter group name.',
                lettersonly: "Please enter valid name."
            },
            description: {
                required: 'Please enter description.',
                //lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {
            //form.submit();
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('group').submit();
        }
    });



    jQuery("#form_add_product").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            product_name: {
                required: true,
                // lettersonly: true
            },
            "product_category[]": "required",
//             "sub_category[]": "required",
            product_quantity: {
                required: true,
                numbersonly: true,
//                positiveNumber:true,
            },
            product_price: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },
            product_sku: {
                required: true,
            },
            product_shipping_region: {
                required: true,
            },
            "product_images[]": "required",
            hover_images: {
                required: true,
            },
            product_desc: {
                required: true,
            },
//             isactive: {
//                required: true,
//            },



        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
            "product_category[]": "Please select product category.",
//             "sub_category[]": "Please select product sub category.",
            product_quantity: {
                required: 'Please enter product quantity.',
                numbersonly: "Please enter only digits.",
//                positiveNumber: "Please enter positive number only."
            },
            product_price: {
                required: 'Please enter product price.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_sku: {
                required: 'Please enter product SKU.',
            },
            product_shipping_region: {
                required: 'Please enter product shipping region.',

            },
            "product_images[]": "Please select product image",
            hover_images: {
                required: 'Please select product hover image.',
            },
            product_desc: {
                required: 'Please enter product description.',
            },
//            isactive: {
//                required: 'Please select product status.',
//            },
        },
        submitHandler: function (form) {
            //form.submit();
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('form_add_product').submit();
        }
    });




    jQuery("#form_add_product_edit").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            product_name: {
                required: true,
                // lettersonly: true
            },
            "product_category[]": "required",
//            "sub_category[]": "required",
            product_quantity: {
                required: true,
                numbersonly: true,
//                positiveNumber:true,
            },
            product_price: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },
            product_sku: {
                required: true,
            },
            product_shipping_region: {
                required: true,
            },
//            "product_images[]": "required",
//            hover_images: {
//                required: true,
//            },
            product_desc: {
                required: true,
            },
            isactive: {
                required: true,
            },

        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                //lettersonly: "Please enter valid name."
            },
            "product_category[]": "Please select product category.",
//            "sub_category[]": "Please select product sub category.",
            product_quantity: {
                required: 'Please enter product quantity.',
                numbersonly: "Please enter only digits.",
//                positiveNumber: "Please enter positive number only."
            },
            product_price: {
                required: 'Please enter product price.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_sku: {
                required: 'Please enter product SKU.',
            },
            product_shipping_region: {
                required: 'Please enter product shipping region.',

            },
            //"product_images[]": "Please select product image",
//             hover_images: {
//                required: 'Please select product hover image.',
//            },
            product_desc: {
                required: 'Please enter product description.',
            },
            isactive: {
                required: 'Please select product status.',
            },
        },
        submitHandler: function (form) {
            //form.submit();
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('form_add_product_edit').submit();
        }
    });



    jQuery("#form_add_coupon").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            coupon_type: {
                required: true,
                // lettersonly: true
            },
            coupon_method: {
                required: true,
                // lettersonly: true
            },
            tax_method: {
                required: true,
                // lettersonly: true
            },
            coupon_code: {
                required: true,
                // lettersonly: true
            },
            coupon_desc: {
                required: true,
                // lettersonly: true
            },
            quantity: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },
            coupon_quantity: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },
            coupon_quantity_a: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },
            coupon_value: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },
            uses_limit: {
                required: true,
                numbersonly: true,
                positiveNumber: true,
            },

        },
        messages: {
            coupon_type: {
                required: 'Please select coupon type.',
                //lettersonly: "Please enter valid name."
            },
            coupon_method: {
                required: 'Please select coupon method.',
                //lettersonly: "Please enter valid name."
            },
            tax_method: {
                required: 'Please select appliance method.',
                //lettersonly: "Please enter valid name."
            },
            coupon_code: {
                required: 'Please enter coupon code.',
                //lettersonly: "Please enter valid name."
            },
            coupon_desc: {
                required: 'Please enter coupon description.',
                //lettersonly: "Please enter valid name."
            },
            quantity: {
                required: 'Please enter quantity to activate.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            coupon_quantity: {
                required: 'Please enter coupon quantity.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            coupon_quantity_a: {
                required: 'Please enter coupon value required to activate.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            coupon_value: {
                required: 'Please enter coupon value.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            uses_limit: {
                required: 'Please enter coupon uses limit.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('form_add_coupon').submit();
        }
    });




    jQuery("#demo-form2").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            title: {
                // required: true,
                lettersonly: true
            },
//            description: {
//                required: true,
//               // lettersonly: true
//            },
            style: {
                required: true,
                // lettersonly: true
            },
            slider: {
                required: true,
                // lettersonly: true
            },
            link: {
                validUrl: true,
                // lettersonly: true
            },

        },
        messages: {
            title: {
                required: 'Please enter title.',
                lettersonly: "Please enter valid name."
            },
            description: {
                required: 'Please enter description.',
                //lettersonly: "Please enter valid name."
            },
            style: {
                required: 'Please select style.',
                //lettersonly: "Please enter valid name."
            },
            slider: {
                required: 'Please select banner image.',
                //lettersonly: "Please enter valid name."
            },
            link: {
                validUrl: 'Please enter valid url.',
                //lettersonly: "Please enter valid name."
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('demo-form2').submit();
        }
    });



    jQuery("#sliderEdit").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            title: {
                // required: true,
//                lettersonly: true
            },
//            description: {
//                required: true,
//               // lettersonly: true
//            },
            style: {
                required: true,
                // lettersonly: true
            },
//            slider: {
//                required: true,
//               // lettersonly: true
//            },
            link: {
                validUrl: true,
                // lettersonly: true
            },

        },
        messages: {
            title: {
                required: 'Please enter title.',
                lettersonly: "Please enter valid name."
            },
            description: {
                required: 'Please enter description.',
                //lettersonly: "Please enter valid name."
            },
            style: {
                required: 'Please select style.',
                //lettersonly: "Please enter valid name."
            },
            slider: {
                required: 'Please select banner image.',
                //lettersonly: "Please enter valid name."
            },
            link: {
                validUrl: 'Please enter valid url.',
                //lettersonly: "Please enter valid name."
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('sliderEdit').submit();
        }
    });



    jQuery("#form_add_promotions").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            type: {
                required: true,
                // lettersonly: true
            },
            discount: {
                required: true,
                numbersonly: true,
                //positiveNumber:true,
            },
            from_date: {
                required: true,
                // lettersonly: true
            },
            to_date: {
                required: true,
                // lettersonly: true
            },

        },
        messages: {
            type: {
                required: 'Please select promotion type.',
                //lettersonly: "Please enter valid name."
            },
            discount: {
                required: 'Please enter discount.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            from_date: {
                required: 'Please select from date.',
                //lettersonly: "Please enter valid name."
            },
            to_date: {
                required: 'Please select to date.',
                //lettersonly: "Please enter valid name."
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
//            document.getElementById ('form_add_promotions').submit();
            var from_date = $('#single_cal4').val();
            var to_date = $('#single_cal3').val();
            submitPromotions(from_date, to_date);
        }
    });





    jQuery("#form_add_subAttributes").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            product_category: {
                required: true,
                // lettersonly: true
            },
            attribute_name: {
                required: true,
                // lettersonly: true
            },
            subattribute_name: {
                required: true,
                lettersonly: true
            },

        },
        messages: {
            product_category: {
                required: 'Please select category.',
            },
            attribute_name: {
                required: 'Please select attribute name.',
            },
            subattribute_name: {
                required: 'Please enter sub attribute name.',
                lettersonly: "Please enter only characters.",
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            var attribute_name = $('#attribute_name').val();
            var subattribute_name = $('#subattribute_name').val();
            var product_category = $('#product_category').val();
            submitAttributes(attribute_name, subattribute_name, product_category);
        }
    });


    jQuery("#form_add_subAttributesEdit").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            product_category: {
                required: true,
                // lettersonly: true
            },
            attribute_name: {
                required: true,
                // lettersonly: true
            },
            subattribute_name: {
                required: true,
                lettersonly: true
            },

        },
        messages: {
            product_category: {
                required: 'Please select category.',
            },
            attribute_name: {
                required: 'Please select attribute name.',
            },
            subattribute_name: {
                required: 'Please enter sub attribute name.',
                lettersonly: "Please enter only characters.",
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            var attribute_name = $('#attribute_name').val();
            var subattribute_name = $('#subattribute_name').val();
            var product_category = $('#product_category').val();
            submitAttributesEdit(attribute_name, subattribute_name, product_category);
        }
    });




    jQuery("#form_add_promotions_edit").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            type: {
                required: true,
                // lettersonly: true
            },
            discount: {
                required: true,
                numbersonly: true,
                //positiveNumber:true,
            },
            from_date: {
                required: true,
                // lettersonly: true
            },
            to_date: {
                required: true,
                // lettersonly: true
            },

        },
        messages: {
            type: {
                required: 'Please select promotion type.',
                //lettersonly: "Please enter valid name."
            },
            discount: {
                required: 'Please enter discount.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            from_date: {
                required: 'Please select from date.',
                //lettersonly: "Please enter valid name."
            },
            to_date: {
                required: 'Please select to date.',
                //lettersonly: "Please enter valid name."
            },

        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
//            document.getElementById ('form_add_promotions').submit();
            var from_date = $('#single_cal4').val();
            var to_date = $('#single_cal3').val();
            submitPromotionsEdit(from_date, to_date);
        }
    });


    jQuery("#uploadCSV").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            userfile: {
                required: true,
                // lettersonly: true
            },

        },
        messages: {
            userfile: {
                required: 'Please select CSV file.',
                //lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('uploadCSV').submit();
        }
    });


    jQuery("#form1").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            userfile: {
                required: true,
                // lettersonly: true
            },

        },
        messages: {
            userfile: {
                required: 'Please select CSV file.',
                //lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('form1').submit();
        }
    });



    jQuery("#forgotPassword").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            username: {
                required: true,
                email: true,
            },
        },
        messages: {
            username: {
                required: 'Please enter username or email address',
                email: 'Please enter valid email address',
            },
        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            //document.getElementById ('forgotPassword').submit();
            sendUsernamePassword();
        }
    });



    jQuery("#frm_send_message").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                lettersonly: true
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true,
            },

        },
        messages: {
            name: {
                required: 'Please enter name.',
                lettersonly: 'Please enter valid name.',
            },
            email: {
                required: 'Please enter email.',
                email: 'Please enter valid email id.',
            },
            message: {
                required: 'Please enter message.',
            },
        },
        submitHandler: function (form) {
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            // document.getElementById ('frm_send_message').submit();
            sendContactUsMessage();
        }
    });


    jQuery(".sub_category").change(function () {
        var check = 0;
        if ($(this).is(':checked')) {
            var check = 1;
        }
        var subatt = $(this).val();
        var javascript_site_path = $('#base_url').val();
        $.ajax({
            type: "POST",
            url: javascript_site_path + 'admin/getThirdLevelSubCategory',
            data: {'sub_category': subatt, 'check': check},
//            cache: false,
//            contentType: false,
//            processData: false,
            mimeType: "multipart/form-data",
            dataType: 'html',
            success: function (data)
            {
                if (check === 1) {
                    if (data != '') {
                        $('#_div_sub_attr_view').append(data);
                    } else {
                        var str = '';
                        str = 'Sub attribute not available.';
                        //alert(str);
                        $('#_div_sub_attr_view').html(str);
                    }
                } else {
                    if (data != '') {
                        $('.div_' + subatt).remove();
                    }
                }
            }
        });

    });
});



function checkDuplicateEmail(email) {
    var x = email;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    //setTimeout(function(){
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
        $('#email').val('');
        return false;
    }

    var formData = new FormData($("#reg_form")[0]);
    var javascript_site_path = $('#base_url').val();
    $.ajax({
        type: "POST",
        url: javascript_site_path + 'auth/chkEmailDuplicateNew',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        mimeType: "multipart/form-data",
        dataType: 'html',
        success: function (data)
        {
            if (data == 1) {
                // alert('true'+data);
            } else if (data == 0) { //alert('false'+data);
                var msg = 'This email address is already registered with site';
                $('#my_message').html(msg);
                $('#myModalNew').modal('show');
                $('#email').val('');
            } else { //alert('other'+data);
                // location.reload(); 
            }

            //document.getElementById('frm_page_menu').submit();
        }
    });
    //return false;
}


function chkFile(image, id) {
    //alert(id);
    var text = $('#' + id).val();
    ext = text.split('.')[1];

    if (ext == 'jpg' || ext == 'png' || ext == 'jpeg' || ext == 'JPG' || ext == 'PNG' || ext == 'JPEG') {
        var oFile = document.getElementById("" + id).files[0];

        //$('#save_crop').css('display','inline');

        if (oFile.size > 2097152) // 2 mb for bytes.
        {
            $('#save_crop').css('display', 'none');
            document.getElementById("" + image).value = "";
            var msg = 'file size must be under 2mb';
            $('#my_message').html(msg);
            $('#myModal').modal('show');
            return;
        }

    } else {
        //$('#save_crop').css('display','none');
        document.getElementById("" + id).value = "";
        var imagemsg = 'Please upload only image';
        $('#my_message').html(imagemsg);
        $('#myModalNew').modal('show');
    }
}

function chkFileCSV(image, id) {
    //alert(id);
    var text = $('#' + id).val();
    ext = text.split('.')[1];

    if (ext == 'csv' || ext == 'CSV') {

    } else {
        //$('#save_crop').css('display','none');
        document.getElementById("" + id).value = "";
        var imagemsg = 'Please upload only CSV file';
        $('#my_message').html(imagemsg);
        $('#myModalNew').modal('show');
    }
}






function checkGroupName(name, id) {
    //alert(name);
    if (name != '') {
        var formData = new FormData($("#group")[0]);
        var javascript_site_path = $('#base_url').val();
        $.ajax({
            type: "POST",
            url: javascript_site_path + 'auth/chkGroupName',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            mimeType: "multipart/form-data",
            dataType: 'html',
            success: function (data)
            {

                if (data == 1) {
                    // alert('true'+data);
                } else if (data == 0) { //alert('false'+data);
                    var msg = 'This group name already available,please enter another name.';
                    $('#my_message').html(msg);
                    $('#myModalNew').modal('show');
                    $('#' + id).val('');
                } else { //alert('other'+data);
                    // location.reload(); 
                }

                //document.getElementById('frm_page_menu').submit();
            }
        });
    }
    //return false
}



function chkCouponCode(name, id) {
    if (name != '') {
        var couponCode = $.trim($('#' + id).val());
        if (couponCode != '') {
            var formData = new FormData($("#form_add_coupon")[0]);
            var javascript_site_path = $('#base_url').val();
            $.ajax({
                type: "POST",
                url: javascript_site_path + 'admin/chkCouponName',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'html',
                success: function (data)
                {

                    if (data == 1) {
                        // alert('true'+data);
                    } else if (data == 0) { //alert('false'+data);
                        var msg = 'This coupon code already available,please enter another code.';
                        $('#my_message').html(msg);
                        $('#myModalNew').modal('show');
                        $('#' + id).val('');
                    } else {

                    }


                }
            });
        }
    }
}


function chkCouponCodeEdit(name, id) {
    if (name != '') {
        var couponCode = $.trim($('#' + id).val());
        if (couponCode != '') {
            var formData = new FormData($("#form_add_coupon")[0]);
            var javascript_site_path = $('#base_url').val();
            $.ajax({
                type: "POST",
                url: javascript_site_path + 'admin/chkCouponNameEdit',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'html',
                success: function (data)
                {

                    if (data == 1) {
                        // alert('true'+data);
                    } else if (data == 0) { //alert('false'+data);
                        var msg = 'This coupon code already available,please enter another code.';
                        $('#my_message').html(msg);
                        $('#myModalNew').modal('show');
                        $('#' + id).val('');
                    } else {

                    }


                }
            });
        }
    }
}


function submitPromotions(from_date, to_date) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var current_date = mm + '/' + dd + '/' + yyyy;



    //alert(current_date);
    if (new Date(from_date) >= new Date(current_date))
    {
        if (new Date(to_date) >= new Date(from_date)) {

            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');


            var formData = new FormData($("#form_add_promotions")[0]);
            var javascript_site_path = $('#base_url').val();
            $.ajax({
                type: "POST",
                url: javascript_site_path + 'admin/chkPromotionAvailable',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'html',
                success: function (data)
                {

                    if (data == 1) {
                        document.getElementById('form_add_promotions').submit();
                    } else if (data == 0) { //alert('false'+data);
                        $('#btn_submit').css('display', 'inline');
                        $('#loader').css('display', 'none');
                        var msg = 'Promotions available for selected date so please change from and to date.';
                        $('#my_message').html(msg);
                        $('#myModalNew').modal('show');
                        // $('#'+id).val('');
                    } else {

                    }


                }
            });



            // document.getElementById ('form_add_promotions').submit();

        } else {
            $('#btn_submit').css('display', 'inline');
            $('#loader').css('display', 'none');
            var msg = 'To date must be greater than from date';
            $('#my_message').html(msg);
            $('#myModalNew').modal('show');
            $('#single_cal3').val('');
        }
    } else {
        $('#btn_submit').css('display', 'inline');
        $('#loader').css('display', 'none');
        var msg = 'From date must be greater than todays date';
        $('#my_message').html(msg);
        $('#myModalNew').modal('show');
        $('#single_cal4').val('');
    }
    // alert(from_date);


}



function submitPromotionsEdit(from_date, to_date) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var current_date = mm + '/' + dd + '/' + yyyy;



    //alert(current_date);
    if (new Date(from_date) >= new Date(current_date))
    {
        if (new Date(to_date) >= new Date(from_date)) {

            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');


            var formData = new FormData($("#form_add_promotions_edit")[0]);
            var javascript_site_path = $('#base_url').val();
            $.ajax({
                type: "POST",
                url: javascript_site_path + 'admin/chkPromotionAvailableEdit',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'html',
                success: function (data)
                {

                    if (data == 1) {
                        document.getElementById('form_add_promotions_edit').submit();
                    } else if (data == 0) { //alert('false'+data);
                        $('#btn_submit').css('display', 'inline');
                        $('#loader').css('display', 'none');
                        var msg = 'Promotions available for selected date so please change from and to date.';
                        $('#my_message').html(msg);
                        $('#myModalNew').modal('show');
                        // $('#'+id).val('');
                    } else {

                    }


                }
            });
        } else {
            $('#btn_submit').css('display', 'inline');
            $('#loader').css('display', 'none');
            var msg = 'To date must be greater than from date';
            $('#my_message').html(msg);
            $('#myModalNew').modal('show');
            $('#single_cal3').val('');
        }
    } else {
        $('#btn_submit').css('display', 'inline');
        $('#loader').css('display', 'none');
        var msg = 'From date must be greater than todays date';
        $('#my_message').html(msg);
        $('#myModalNew').modal('show');
        $('#single_cal4').val('');
    }
    // alert(from_date);


}


function submitAttributes(attribute_name, subattribute_name, product_category) {

    if (attribute_name != '' && subattribute_name != '' && product_category != '')
    {
        $('#btn_submit').css('display', 'none');
        $('#loader').css('display', 'inline');
        var formData = new FormData($("#form_add_subAttributes")[0]);
        var javascript_site_path = $('#base_url').val();
        $.ajax({
            type: "POST",
            url: javascript_site_path + 'admin/chkSubattributesAvailableAdd',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            mimeType: "multipart/form-data",
            dataType: 'html',
            success: function (data)
            {

                if (data == 1) {
                    document.getElementById('form_add_subAttributes').submit();
                } else if (data == 0) { //alert('false'+data);
                    $('#btn_submit').css('display', 'inline');
                    $('#loader').css('display', 'none');
                    var msg = 'Selected attribute name and subattribute name already available so please enter another subattribute name';
                    $('#my_message').html(msg);
                    $('#myModalNew').modal('show');
                    // $('#'+id).val('');
                } else {

                }
            }
        });

    } else {
        $('#btn_submit').css('display', 'inline');
        $('#loader').css('display', 'none');
        var msg = 'Please select attribute name and also enter subattribute name.';
        $('#my_message').html(msg);
        $('#myModalNew').modal('show');
    }

}



function getThirdLevelSubCategoryEdit() {

    var formData = new FormData($("#form_add_product_edit")[0]);
    var javascript_site_path = $('#base_url').val();
    $.ajax({
        type: "POST",
        url: javascript_site_path + 'admin/getThirdLevelSubCategoryEdit',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        mimeType: "multipart/form-data",
        dataType: 'html',
        success: function (data)
        {
            if (data != '') {
                $('#_div_sub_attr_view').html(data);
            } else {
                var str = '';
                str = 'Sub attribute not available.';
                //alert(str);
                $('#_div_sub_attr_view').html(str);
            }
        }
    });

}

function submitAttributesEdit(attribute_name, subattribute_name, product_category) {

    if (attribute_name != '' && subattribute_name != '' && product_category != '')
    {
        $('#btn_submit').css('display', 'none');
        $('#loader').css('display', 'inline');
        var formData = new FormData($("#form_add_subAttributesEdit")[0]);
        var javascript_site_path = $('#base_url').val();
        $.ajax({
            type: "POST",
            url: javascript_site_path + 'admin/chkSubattributesAvailableEdit',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            mimeType: "multipart/form-data",
            dataType: 'html',
            success: function (data)
            {

                if (data == 1) {
                    document.getElementById('form_add_subAttributesEdit').submit();
                } else if (data == 0) { //alert('false'+data);
                    $('#btn_submit').css('display', 'inline');
                    $('#loader').css('display', 'none');
                    var msg = 'Selected attribute name and subattribute name already available so please enter another subattribute name';
                    $('#my_message').html(msg);
                    $('#myModalNew').modal('show');
                    // $('#'+id).val('');
                } else {

                }
            }
        });

    } else {
        $('#btn_submit').css('display', 'inline');
        $('#loader').css('display', 'none');
        var msg = 'Please select attribute name and also enter subattribute name.';
        $('#my_message').html(msg);
        $('#myModalNew').modal('show');
    }

}


function getSubCategory(attribute_name, addEdit) { //1 for add and 2 for edit
    var javascript_site_path = $('#base_url').val();
    if (attribute_name != '') {
        $.ajax({
            type: "POST",
            url: javascript_site_path + 'admin/getSubAttributeByName',
            data: {
                'attribute_name': attribute_name,
                'addEdit': addEdit,
            },
            cache: false,
            dataType: 'html',
            success: function (data)
            {
                if (data != '') {
                    $('#_div_sub_attr_view').html(data);
                } else {
                    var str = '';
                    str = 'Sub attribute not available.';
                    //alert(str);
                    $('#_div_sub_attr_view').html(str);
                }
            }
        });
    }
}

function getSubCategoryById(attribute_name, addEdit) { //1 for add and 2 for edit
    var javascript_site_path = $('#base_url').val();
    if (attribute_name != '') {
        $.ajax({
            type: "POST",
            url: javascript_site_path + 'admin/getSubAttributeById',
            data: {
                'attribute_name': attribute_name,
                'addEdit': addEdit,
            },
            cache: false,
            dataType: 'html',
            success: function (data)
            {
                if (data != '') {
                    $('#_div_sub_attr_view').html(data);
                } else {
                    var str = '';
                    str = 'Sub attribute not available.';
                    //alert(str);
                    $('#_div_sub_attr_view').html(str);
                }
            }
        });
    }
}


function sendContactUsMessage() {
    var formData = new FormData($("#frm_send_message")[0]);
    var javascript_site_path = $('#base_url').val();

    $.ajax({
        type: "POST",
        url: javascript_site_path + 'admin/sendContactUsMessage',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        mimeType: "multipart/form-data",
        dataType: 'JSON',
        success: function (response)
        {
            if (response.status === '1') {
                $('#st_message').css('display', 'inline');
                $("#st_message").html('<div class="alert alert-success"><strong>Success! </strong>' + response.msg + '</div>');
                $('#loader').css('display', 'none');
                $('#btn_submit').css('display', 'inline');
                $('#message').val('');
            } else {
                $('#st_message').css('display', 'inline');
                $("#st_message").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.msg + '</div>');
                $('#loader').css('display', 'none');
                $('#btn_submit').css('display', 'inline');

            }
            window.setTimeout(function () {
                $('#st_message').css('display', 'none');
            }, 3000);
        }
    });
}


function sendUsernamePassword() {
    var formData = new FormData($("#forgotPassword")[0]);
    var javascript_site_path = $('#base_url').val();

    $.ajax({
        type: "POST",
        url: javascript_site_path + 'home/sendUsernamePassword',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        mimeType: "multipart/form-data",
        dataType: 'JSON',
        success: function (response)
        {
            if (response.status === '1') {
                $.toaster({priority: 'success', title: 'Username and password', message: response.msg});
                window.location = javascript_site_path + 'home/login';
            } else {
                $.toaster({priority: 'danger', title: 'Fail', message: response.msg});
                $('#loader').css('display', 'none');
                $('#btn_submit').css('display', 'none');
            }
        }
    });
}
