

$.urlParam = function(name){
    var results = new RegExp("[\?&]" + name + "=([^&#]*)").exec(window.location.href);
    if (results==null) {
        return null;
    }
    return decodeURI(results[1]) || 0;
}


var getIPAddress = function() {
    var tokenid= $('#tokenid').val();
    var p= location.pathname.split("/").slice(-1)[0];
    var page= p.split(".");
    var pagename=page[0];
    $.getJSON("https://jsonip.com?callback=?", function(data) {
        data.ip;
        var formData =  {
            "ipaddress": data.ip,
            "pagename": pagename,
            "tokenid": tokenid
        };
        $.ajax({
            url: "./insertip.php",
            method: "POST",
            data: formData,
            success: function(data){
                console.log(data)
            }
        })
    });
};

$(document).ready(function (e) {
    //alert($('#tokenid').val());
    //click to call button event
    $('#clicktocall').on('click', function(event){
        // event.preventDefault();
        var filename= $("#filename").val();
        var tokenid= $('#tokenid').val();
        var clicktocallData =  {
            "filename": filename,
            "tokenid": tokenid
        };
        $.ajax({
            url: 'clicktocallevent.php',
            method: 'POST',
            data:clicktocallData,
            success: function(data){
                console.log(data);
            }
        })
    });
    // facebook click event

    $('#facebookclick').on('click', function(event){
        // event.preventDefault();
        var filename= $("#filename").val();
        var tokenid= $('#tokenid').val();
        var clicktocallData =  {
            "filename": filename,
            "social": "facebook",
            "tokenid": tokenid
        };
        $.ajax({
            url: 'socialevent.php',
            method: 'POST',
            data:clicktocallData,
            success: function(data){
                console.log(data);
            }
        })
    });



    // twitter button click

    $('#twitterclick').on('click', function(event){
        // event.preventDefault();
        var filename= $("#filename").val();
        var tokenid= $('#tokenid').val();
        var clicktocallData =  {
            "filename": filename,
            "social": "twitter",
            "tokenid": tokenid
        };
        $.ajax({
            url: 'socialevent.php',
            method: 'POST',
            data:clicktocallData,
            success: function(data){
                console.log(data);
            }
        })
    });

    $('#instaclick').on('click', function(event){
        // event.preventDefault();
        var filename= $("#filename").val();
        var tokenid= $('#tokenid').val();
        var clicktocallData =  {
            "filename": filename,
            "social": "insta",
            "tokenid": tokenid
        };
        $.ajax({
            url: 'socialevent.php',
            method: 'POST',
            data:clicktocallData,
            success: function(data){
                console.log(data);
            }
        })
    });

    $('#linkedinclick').on('click', function(event){
        // event.preventDefault();
        var filename= $("#filename").val();
        var tokenid= $('#tokenid').val();
        var clicktocallData =  {
            "filename": filename,
            "social": "linkedin",
            "tokenid": tokenid
        };
        $.ajax({
            url: 'socialevent.php',
            method: 'POST',
            data:clicktocallData,
            success: function(data){
                console.log(data);
            }
        })
    });

    if($('.embed-responsive-item').length){
        $('.embed-responsive-item').attr('id', 'youtubev'); // check if there is youtube in the page
    }
    if($.urlParam("iframe")==null)
        getIPAddress();
    $("form").submit(function(e){
        var inputs = "";
        e.preventDefault();
        $("input, textarea").each(function(){
            $element = $(this);
            var $label = $("label[for='"+$element.attr('id')+"']").html();
            if($element.attr("type")=="hidden"){
            }
            else if ($element.attr("type")=="submit") {
            }
            else {
                inputs += $label + ":"+ $(this).val()+"&";
            }
        });
        inputs=inputs.slice(0,-1);
        var campid1= $("#campid").val();
        var tokenid= $('#tokenid').val();
        var shortlink1= $("#filename").val();
        var formData1 =  {
            "inputs_": inputs,
            "campid_": campid1,
            "shortlink_": shortlink1,
            "tokenid": tokenid
        };
        $.ajax({
            url: "formsubmit.php",
            method: "POST",
            data: formData1,
            success: function(data){
                console.log(data);
                $('#submit').val('Submited');
                $('#submit').attr('disabled', 'disabled');
            }
        })
    });
});

