<?php
ob_start();
session_start();


//print_r($_GET['t']);
?>
<?php include('includes/header.php'); ?>
<body >
<br><br>
<h1 class='titlee'> Sign up</h1>
<hr>
<style>
    .error{
        display: none;
        font-style: italic;
        margin-left: 10px;
    }
    .checkemail, .checkuser, .checkphone, .length, .sender{
        display: none;
        font-style: italic;
        margin-left: 10px;
        color: #EB078C;
    }

    .error1{
        display: block;
        font-style: italic;
        margin-left: 10px;
        color: #EB078C;
    }

    .error_show{
        color: #EB078C;
        margin-left: 10px;
    }
    .invalid{
        border: 2px solid red;
    }

   .valid{
        border: 2px solid green;
    }
</style>
<script src="./js/signup.js" type="text/javascript">

</script>

<div class="container-fluid" >

    <form  method="post" id="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col col-sm-3">
                <label >
                    Full Name
                </label>
                <input type="text" name="fullname" class="form-control" id="fullname" >
                <span class="error">This field is required</span>
            </div>
            <div class="col col-sm-3">
                <label >
                    User Name
                </label>
                <input type="text" name="username" class="form-control" id="username" >
                <span class="error">This field is required</span>
                <span class="checkuser">Username already exists..</span>
            </div>
            <div class="col col-sm-3">
                <label >
                   Email
                </label>
                <input type="email" name="email" class="form-control" id="email" >
                <span class="error">This field is required</span>
                <span class="checkemail">Email already exists..</span>
            </div>
            <div class="col col-sm-3">
                <label >
                  Password
                </label>
                <input type="text" name="password" class="form-control" id="password" >
                <span class="error">This field is required</span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col col-sm-3">
                <div class="row">
                    <div class="col col-sm-6">
                        <label >
                            Phone <i><small>(without 964)</small></i>
                        </label>
                        <input type="number" name="phone" class="form-control" id="phone" min="10" max="10" placeholder="eg: 7807807807" >
                        <span class="error">This field is required</span>
                        <span class="checkphone">Phone already exists..</span>
                        <span class="length">Phone should be 10 numbers..</span>

                    </div>
                    <div class="col col-sm-6">
                        <label >
                            Confirm Phone
                        </label>
                        <input type="number" name="phone1" class="form-control" id="phone1" min="10" max="10" placeholder="eg: 7807807807" >
                        <span id="msg"></span>
                    </div>
                </div>
            </div>
            <div class="col col-sm-3">
                <label >
                    Company
                </label>
                <input type="text" name="company" class="form-control" id="company" >
                <span class="error">This field is required</span>
            </div>
            <div class="col col-sm-3">
                <label >
                    Address
                </label>
                <input type="text" name="address" class="form-control" id="address" >
                <span class="error">This field is required</span>
            </div>
            <div class="col col-sm-3">
                <label >
                    Sender ID <i><small>No special character allowed (only _)</small></i>
                </label>
                <input type="text" name="sender" class="form-control" id="sender"  maxlength="11" >
                <span class="error">This field is required</span>
                <span class="sender">Sender contain special characters..</span>
            </div>

        </div>
        <hr style="border-bottom: 2px solid black">
    <center>
    <div class="row" style="background-color: white; padding: 15px;">

        <div class="col col-sm-6">Company committee registration
        <br>
            (محضر اجتماع)
        </div>
        <span class="error" id="error1">This field is required</span>
        <div class="col col-sm-6"> <br>
            <input class="form-control" type="file" name="file1[]" multiple="multiple" id="file1" onchange="fileValidation('file1')" accept="application/pdf, image/*" />
            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>
        </div>
    </div>
     <hr style="border-bottom: 1px solid black">
    <div class="row" style="background-color: white; padding: 15px;">
        <div class="col col-sm-6">Establishment contract and establishment certificate <br>
            (عقد تأسيس و شهادة تأسيس)
        </div>

        <span class="error" id="error2">This field is required</span>
        <div class="col col-sm-6"><br>
            <input class="form-control" type="file" name="file2[]" multiple="multiple" id="file2" onchange="fileValidation('file2')" accept="application/pdf, image/*" />
            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>

        </div>
    </div>
    <hr style="border-bottom: 1px solid black">
    <div class="row" style="background-color: white; padding: 15px;">
        <div class="col col-sm-6">Lease or mention the legal address in official request
        <br>
             (عقد ايجار او ذكر العنوان في الطلب الرسمي)
        </div>
        <span class="error" id="error3">This field is required</span>
        <div class="col col-sm-6"><br>
            <input class="form-control" type="file" name="file3[]" multiple="multiple" id="file3" onchange="fileValidation('file3')"  accept="application/pdf, image/*" />
            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>
        </div>
    </div>
    <hr style="border-bottom: 1px solid black">
    <div class="row" style="background-color: white; padding: 15px;">
        <div class="col col-sm-6">Official request mentioning the authorized person/ the company <br>official address signed by the company’s manager
        <br>
             (طلب رسمي "يحمل موقع الشركة", مختوم و موقع من مدير الشركة يخول فيه الشخص المذكور)
        </div>
        <span class="error" id="error4">This field is required</span>
        <div class="col col-sm-6"><br>
            <input class="form-control" type="file" name="file4[]" multiple="multiple" id="file4" onchange="fileValidation('file4')" accept="application/pdf, image/*" />
            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>
        </div>
    </div>
     <hr style="border-bottom: 1px solid black">
    <div class="row" style="background-color: white; padding: 15px;">
        <div class="col col-sm-6">Colored copy of company’s manager ID
        <br>
             (هوية الأحوال المدنية و بطاقة السكن و تكون ملونة)
        </div>
        <span class="error" id="error5">This field is required</span>
        <div class="col col-sm-6"><br>
            <input class="form-control" type="file" name="file5[]" multiple="multiple" id="file5" onchange="fileValidation('file5')" accept="application/pdf, image/*" />

            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>
        </div>
    </div>
    <hr style="border-bottom: 1px solid black">
    <div class="row" style="background-color: white; padding: 15px;">
        <div class="col col-sm-6">Colored copy of all documents for the authorized person
        <br>
            (هوية الأحوال المدنية و بطاقة السكن و تكون ملونة)
        </div>
        <span class="error" id="error6">This field is required</span>
        <div class="col col-sm-6"><br>
            <input class="form-control" type="file" name="file6[]" multiple="multiple" id="file6" onchange="fileValidation('file6')" accept="application/pdf, image/*" />
            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>
        </div>
    </div>
    <hr style="border-bottom: 1px solid black">
    <div class="row" style="background-color: white; padding: 15px;">
        <div class="col col-sm-6">Extra files</div>
        <div class="col col-sm-6">
            <input class="form-control" type="file" name="file7[]" multiple="multiple" id="file7" onchange="fileValidation('file7')" accept="application/pdf, image/*" />
            <i style="font-size: smaller !important; color: #38B9C2;">accept only Images and PDF (less than 1 MB).</i>
        </div>
    </div>
    <hr><br>
    <div class="row">
        <span class="error1" id="allerror" style="display: none;">Some fields are required, check above please</span>
        <input class="form-control btn btn-primary" type="button" value="Submit" name="submit" id="submit">
    </div>
    </form>
    </center>
</div>

</body>

