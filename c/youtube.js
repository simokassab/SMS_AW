var eventid = '';

var tag = document.createElement('script');
tag.id = 'iframe-demo';
tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
    player = new YT.Player('youtubev', {
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}
var done = false;
function onPlayerStateChange(event) {
    var tokenid=  document.getElementById('tokenid').value;
   // alert(tokenid);
    if (event.data == YT.PlayerState.PLAYING  && !done ) {
        var filename= $("#filename").val();
        var formData2 =  {
            "filename": filename,
            "tokenid": tokenid
        };
        $.ajax({
            url: "ytevent.php",
            method: "POST",
            data: formData2,
            success: function(data){
                eventid=data;
                done = true;
                // console.log(data);
            }
        })
    }
    if (event.data == YT.PlayerState.ENDED ) {
        console.log(eventid);
        var formData3 =  {
            "eventid": eventid,
            "ended" : 1
        };
        $.ajax({
            url: "ytevent.php",
            method: "POST",
            data: formData3,
            success: function(data){
                console.log(data +"-"+eventid+" ended");
            }
        })
    }
}