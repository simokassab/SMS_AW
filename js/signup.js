
function fileValidation (id){
    const fi = document.getElementById(id);
    const fsize = fi.files.item(0).size;
    const file = Math.round((fsize / 1024));
    if(file > 1024){
        alert('File size not allowed (less than 1024KB)');
        $('#'+id).val('');
        return false;
    }
    else {
        return true;
    }
}

jQuery(document).ready(function(){
        $("#phone1").keyup(function(){
            //alert('d');
            if ($("#phone").val() != $("#phone1").val()) {
                $("#msg").html("Phone doesnt not match").css("color","red");
            }else{
                $("#msg").html("Phone matched").css("color","green");
            }
        });
        $('#fullname').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            if(is_name){input.removeClass("invalid").addClass("valid");}
            else{input.removeClass("valid").addClass("invalid");}
        });
        $('#username').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            if(is_name){input.removeClass("invalid").addClass("valid");}
            else{input.removeClass("valid").addClass("invalid");}
        });
        $('#phone').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            //alert(is_name.length);
            if((is_name.length<10) || (is_name.length>10)){
                input.removeClass("valid").addClass("invalid");
                $(".length").css("display", "block");
            }
            else if(is_name){
                input.removeClass("invalid").addClass("valid");
                $(".length").css("display", "none");
            }
            else{
                input.removeClass("valid").addClass("invalid");
                $(".length").css("display", "none");
            }
        });
        $('#email').blur(function() {
            var input=$(this);
            var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            var is_email=re.test(input.val());
            if(is_email){input.removeClass("invalid").addClass("valid");}
            else{input.removeClass("valid").addClass("invalid");}
        });
        $('#company').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            if(is_name){input.removeClass("invalid").addClass("valid");}
            else{input.removeClass("valid").addClass("invalid");}
        });
        $('#address').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            if(is_name){input.removeClass("invalid").addClass("valid");}
            else{input.removeClass("valid").addClass("invalid");}
        });

        $('#sender').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            if((is_name) && (/^[A-Za-z0-9_]+$/.test(is_name) == true)){
                input.removeClass("invalid").addClass("valid");
                $(".sender").css("display", "none");

            }
            else{
                input.removeClass("valid").addClass("invalid");
                $(".sender").css("display", "block");
            }
        });
        $('#password').blur(function() {
            var input=$(this);
            console.log(input);
            var is_name=input.val();
            if(is_name){input.removeClass("invalid").addClass("valid");}
            else{input.removeClass("valid").addClass("invalid");}
        });


        $("#submit").click(function(event){
            var cphone = $('#msg').html();
            if(cphone=="Phone doesnt not match"){
                $('html, body').animate({
                    scrollTop: $("#phone1").offset().top
                }, 100);
            }
            var form_data=$("#form").serializeArray();
            var error_free=true;
            var email = $("#email").val();
            var username = $("#username").val();
            var phone = $("#phone").val();
            $.ajax({
                url: './requests/checkemail.php',
                type: 'post',
                data: {
                    'email':email,
                    'username':username,
                    'phone':phone,
                    'email_check':1,
                },
                success:function(response) {
                    if(response=="0"){
                        $(".checkemail").css("display", "block");
                        $(".checkuser").css("display", "block");
                        $(".checkphone").css("display", "block");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else if(response=="-1") {
                        $(".checkemail").css("display", "block");
                        $(".checkuser").css("display", "none");
                        $(".checkphone").css("display", "none");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else if(response=="-2") {
                        $(".checkemail").css("display", "none");
                        $(".checkuser").css("display", "block");
                        $(".checkphone").css("display", "none");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else if(response=="-3") {
                        $(".checkemail").css("display", "none");
                        $(".checkuser").css("display", "none");
                        $(".checkphone").css("display", "block");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else if(response=="-4") {
                        $(".checkemail").css("display", "block");
                        $(".checkuser").css("display", "none");
                        $(".checkphone").css("display", "block");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else if(response=="-5") {
                        $(".checkemail").css("display", "none");
                        $(".checkuser").css("display", "block");
                        $(".checkphone").css("display", "block");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else if(response=="-6") {
                        $(".checkemail").css("display", "block");
                        $(".checkuser").css("display", "block");
                        $(".checkphone").css("display", "none");
                        $('html, body').animate({
                            scrollTop: $("#email").offset().top
                        }, 100);
                    }
                    else {
                        $(".checkemail").css("display", "none");
                        $(".checkuser").css("display", "none");
                        $(".checkphone").css("display", "none");
                        var form = $("#form");
                          var formData = new FormData(form[0]);
                         /* var total=0;
                          for(var i=1; i<=7; i++){

                              total = $('#file'+i).prop('files').length;

                              if(total==0){
                                  continue;
                              }
                              else {
                                  for (var index = 0; index <total; index++){
                                      console.log(total+"---"+index);
                                     // formData.append('file'+i+'[]', $('#file'+i).prop('files')[index]);
                                  }
                              }
                          }
                          var file1 = $('#file1').prop('files')[0];
                          var file2 = $('#file2').prop('files')[0];
                          var file3 = $('#file3').prop('files')[0];
                          var file4 = $('#file4').prop('files')[0];
                          var file5 = $('#file5').prop('files')[0];
                          var file6 = $('#file6').prop('files')[0];
                          var file7 = $('#file7').prop('files')[0];
                          formData.append('file1', file1);
                          formData.append('file2', file2);
                          formData.append('file3', file3);
                          formData.append('file4', file4);
                          formData.append('file5', file5);
                          formData.append('file6', file6);
                          formData.append('file7', file7); */

                        $.ajax({
                            url: './requests/signup.php',
                            dataType: 'text',  // what to expect back from the PHP script, if anything
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                               $("#submit").val("Loading... It might take up to a minute depending on your file sizes..");
                                $("#submit").attr("disabled", true);
                            },
                            success: function (data) {
                                if(data=="OK"){
                                    $.notify("You have been registred successfully.., you will receive an email once confirmed from our side", "success");
                                    window.setTimeout(function () {
                                        location.reload();
                                    }, 3000);
                                }
                                else {
                                    alert(data);
                                }
                            },
                        });
                    }
                }
            });
            for (var input in form_data){
                var element=$("#"+form_data[input]['name']);
                var valid=element.hasClass("valid");
                var error_element=$("span", element.parent());
                if (!valid){error_element.removeClass("error").addClass("error_show"); error_free=false;}
                else{error_element.removeClass("error_show").addClass("error");}
            }
        });
});