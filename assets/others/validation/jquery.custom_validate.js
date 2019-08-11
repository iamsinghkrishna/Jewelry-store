/*Login */

$("#login_form").validate({
    rules: {
        identity: {
            required: true,
            minlength: 2,
            maxlength: 25,
           
        },
         password: {
            required: true,
            minlength: 4,
            maxlength:12,
            
        },
        
        req_no_positions: {
            required: true,
            
           
        },
    },
    //For custom messages
    messages: {
        uname: {
            required: "Enter a username",
            minlength: "Enter at least 5 characters"
        },
        curl: "Enter your website",
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});
/*End Login */


/*Registration */

$("#reg_form").validate({
    rules: {
        first_name: {
            required: true,
            minlength: 2,
            maxlength: 25,
           
        },
         last_name: {
            required: true,
            minlength: 4,
            maxlength:12,
            
        },
        
            company: {
            required: true,
            minlength: 4,
            maxlength:12,
            
        },
        
        email: {
            required: true
        },
        
         j_date: {
            required: true,
            date: true
        },
        
         profile_image: {
            extension: "jpg,jpeg,png",
        },
        
         phone: {
            number: true,
            required: true,
            phoneUS: true,
        },
        
      
    },
    //For custom messages
    messages: {
        uname: {
            required: "Enter a username",
            minlength: "Enter at least 5 characters"
        },
        curl: "Enter your website",
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});
/*End Registration */