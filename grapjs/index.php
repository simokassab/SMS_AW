<?php
ob_start();
session_start();
require_once ('../includes/constants.php');
include_once('../classes/links.php');
include_once('../classes/campaigns.php');
include_once('../classes/templates.php');
$links = new links();
$temp = new templates();
$camp = new campaigns();

if( (isset($_GET['p'])) && (isset($_GET['p']))){
    $t=$temp->getRowByID($_GET['p']);
    $shortlink=$_GET['r'];
    $parameters= $links->parByShortLink($shortlink);
    $par = explode("&", $parameters);
    $par1=explode("=", $par[0]);
    $campid=$par1[1]; //camp id
    $campaign = $camp->getRowByID($campid);
    $camptype= $campaign[2];
}
?>
<html >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../img/homelogo_L54_icon.ico" />
    <link rel="stylesheet" href="../css/all.css" >
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="dist/css/grapes.min.css">
    <script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
    <script src="dist/grapes.js"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic@0.1.7/dist/grapesjs-blocks-basic.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</head>
  <body>
  <input type="hidden" name="shortlink" id="shortlink" value="<?php echo $shortlink;?>">
  <input type="hidden" name="camptype" id="camptype" value="<?php echo $camptype;?>">
    <div id="gjs" style="height:0px; overflow:hidden;">
            <?php echo $t[2]; ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            function msieversion() {

                var ua = window.navigator.userAgent;
                var msie = ua.indexOf("MSIE ");

                if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
                {
                   return true;
                }
                else  // If another browser, return 0
                {
                   return false;
                }
            }

            function msieversion1()
            {
                var ua = window.navigator.userAgent;
                var msie = ua.indexOf("MSIE ");

                if (msie > 0) // If Internet Explorer, return version number
                {
                    return true;
                }
                else  // If another browser, return 0
                {
                  return false;
                }

              //  return false;
            }

           if((msieversion()) || (msieversion1())) {
               $("#gjs-sm-dimension").addClass("gjs-sm-open");
               $(".gjs-sm-properties").removeAttr('style');
           }
        });
        var shortlink_=$('#shortlink').val();
       // alert(shortlink_);
            var camptype=$('#camptype').val();

      var editor = grapesjs.init({

        showOffsets: 1,
        noticeOnUnload: 1,

        container: '#gjs',
        height: '100%',
        fromElement: true,
          storageManager: {
              autosave: false,
              setStepsBeforeSave: 1,
              type: 'remote',
              params: {
                  shortlink: shortlink_,
              },
              urlStore: '<?php echo LINK;?>/landing_page/index.php',

          },
        styleManager : {
          sectors: [{
              name: 'General',
              open: false,
              buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
            },{
              name: 'Dimension',
              open: false,
              buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
            },{
              name: 'Typography',
              open: false,
              buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-shadow'],
            },{
              name: 'Decorations',
              open: false,
              buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background'],
            },{
              name: 'Extra',
              open: false,
              buildProps: ['transition', 'perspective', 'transform'],
            }
          ],
        },
          assetManager: {
              storageType  	: 'remote',
              storeOnChange  : true,
              storeAfterUpload  : true,
              upload: '<?php echo LINK; ?>/grapjs/assets/upload',        //for temporary storage
              assets    	: [ {
                  // You can pass any custom property you want
                  category: 'c1',
                  src: 'http://placehold.it/350x250/78c5d6/fff/image1.jpg',
              }, {
                  category: 'c1',
                  src: 'http://placehold.it/350x250/459ba8/fff/image2.jpg',
              }, {
                  category: 'c2',
                  src: 'http://placehold.it/350x250/79c267/fff/image3.jpg',
              }],
              uploadFile: function(e) {
                  var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
                  var formData = new FormData();
                  for(var i in files){
                      formData.append('file-'+i, files[i]) //containing all the selected images from local
                  }
                  $.ajax({
                      url: '<?php echo LINK ?>/grapjs/assets/upload_image.php',
                      type: 'POST',
                      data: formData,
                      contentType:false,
                      crossDomain: true,
                      dataType: 'json',
                      mimeType: "multipart/form-data",
                      processData:false,
                      success: function(result){

                          var myJSON = [];
                          $.each( result['data'], function( key, value ) {
                              myJSON[key] = value;
                          });
                          var images = myJSON;
                          editor.AssetManager.add(images); //adding images to asset       manager of GrapesJS
                      }
                  });
              },
          },
      });
      editor.setDevice('Mobile landscape');
      const blockManager = editor.BlockManager;
      blockManager.add('Container', {
          label: '<i style="font-size: 42px;" class="far fa-window-maximize"></i> <br/><p class="type">1 Column</p> ',
          content: '<div class="row"><div class="cell" ></div></div>',
          attributes: {
              title: ''
          }
      })
      blockManager.add('2 Columns', {
          label: '<i style="font-size: 42px;" class="fas fa-columns"></i> <br/><p class="type">2 Columns</p> ',
          content: '<div class="row" id="i0rehp"><div class="cell" style="flex-basis: 0!important;" id="ic2c9d"></div>' +
          '<div class="cell" style="flex-basis: 0!important;"></div></div>',
          attributes: {
              title: ''
          }
      })
      blockManager.add('spacer', {
          label: '<i  style="font-size: 42px;" class="fas fa-equals"></i><br/><p class="type">Spacer</p> ',
          content: '<div class="mt-6 col-md-12" style="margin-top: 20px!important;"></div>',

      })
      blockManager.add('text', {
          label: '<i  style="font-size: 42px;" class="fas fa-text-height"></i><br/><p class="type">Text</p> ',
          content: '<div style="padding: 10px;">Insert your text here</div>',
          attributes: {
              title: 'Insert your text here..'
          }
      })
      blockManager.add('h1-block', {
          label: '<i style="font-size: 42px;" class="fas fa-heading"></i><br><p class="type">Heading</p> ',
          content: '<h1 class="big-title">Put your title here</h1>',
          attributes: {
              title: 'Insert h1 block'
          }
      })
      blockManager.add('jumbotron', {
          label: '<i style="font-size: 42px;" class="fas fa-money-check"></i><br><p class="type">Jumbotron</p> ',
          content: '<div class="jumbotron">    ' +
          '<h1 class="display-4">Hello, world!</h1>    ' +
          '<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>    ' +
          '<hr class="my-4">    ' +
          '<p>It uses utility classes for typography and spacing to space content out within the larger container.</p>    ' +
          '<p class="lead"></div>'
      })
      blockManager.add('call', {
          label: '<i style="font-size: 42px;" class="fas fa-phone"></i><br><p class="type">Click to Call</p> ',
          content: '<div class="text-center"><a href="tel:" class="btn btn-success" id="clicktocall" style="width: 100px;margin: 0 auto;">Click to Call</a></div> '
      })

        blockManager.add('Quote', {
            label: '<i style="font-size: 42px;" class="fas fa-quote-right"></i><br><p class="type">Quote</p> ',
            content: '<blockquote class="quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit</blockquote>'
        })
        blockManager.add('form', {
            label: '<i style="font-size: 42px;" class="fas fa-clipboard-list"></i><br> <p class="type">Form</p> ',
            content: '<form class="form-group" method="post" style="padding:10px;">' +
            '<div class="form-group">'+
            '<label id="lbl1" for="txt1">Text 1</label><input type="text" id="txt1" name="txt1" required class="form-control"/>'+
            '<label id="lbl2" name="lbl2" for="txt2">Text 2</label><input type="text" id="txt2" name="txt2" required class="form-control"/>'+
            '<label id="lbl3" for="txt3">Text 3</label><input type="text" id="txt3" name="txt3" required class="form-control"/>'+
            '<label id="lbl4" for="txt4">Text 4</label><input type="text" id="txt4" name="txt4" required class="form-control"/>'+
            '<input type="hidden" id="campid" name="campid" value="<?php echo $campid; ?>" class="form-control">'+
            '<input type="hidden" id="filename" name="filename" value="<?php echo $shortlink; ?>" class="form-control">'+
            '<label id="lbl5" for="txtarea1">Text 5</label><textarea id="txtarea1" name="txtarea1" required class="form-control"></textarea>'+
            '<input type="submit" value="Submit" id="submit" name="submit" class="btn btn-success" style="width: 100px;margin-left:40%;"/>'+
            '</div></div></form>'
        })
      blockManager.add('image', {
          label: '<i style="font-size: 42px;" class="far fa-image"></i><br> <p class="type">Image</p> ',
          content: '<div class="row"><div class="col-xs-12 co"><img style="padding: 2%!important; max-width: 97% !important;min-width: 77% !important; margin-left: 1%; min-height: 10%!important;" /></div></div>'
      })
      blockManager.add('video', {
          label: '<i style="font-size: 42px;"class="fas fa-video"></i><br><p class="type">Video</p> ',
          content: '' +
                        '<video class="embed-responsive-item" style="max-height: 400px !important; padding: 1%!important; width: 98% !important; margin-left: 1%;"  controls="controls"></video>',
          removable: false
      })
      blockManager.add('map', {
          label: '<i style="font-size: 42px;" class="fas fa-map-marker-alt"></i><br><p class="type">Map</p> ',
          content: '<iframe frameborder="0" style="padding: 1%!important; width: 98% !important; margin-left: 1%;" id="iub7ap" src="https://maps.google.com/maps?&z=1&t=q&output=embed"></iframe><br><br>'
      })
      blockManager.add('social', {
          label: '<div class="row">' +
          '<div class="col col-xs-3"></div>' +
          '</div> <i style="font-size: 42px;"  class="fab fa-facebook-square"></i><br><p class="type">Social</p> ',
          content: '<div class="row" style="margin-left:2%!important;">' +
          '<div class="col col-xs-2" style="flex-grow: .2; padding: 0!important;"><a href="" target="_blank" class="fcbk" id="facebookclick" ></a></div>' +
          '<div class="col col-xs-2" style="flex-grow: .2; padding: 0!important;"><a href="" class="twitter"  id="twitterclick" ></a></div>' +
          '<div class="col col-xs-2" style="flex-grow: .2; padding: 0!important;"><a href="" class="insta"  id="instaclick" ></a></div>' +
          '<div class="col col-xs-2" style="flex-grow: .2; padding: 0!important;"><a href="" class="linkedin"  id="linkedinclick" ></a></div>' +
          '</div>'

      })

        editor.Panels.addButton
        ('options',
            [{
                id: 'save-db',
                className: 'fa fa-floppy-o',
                command: 'save-db',
                attributes: {title: 'Save Template'}
            }]
        );
        // Add the command
        editor.Commands.add
        ('save-db',
            {
                run: function (editor, sender) {
                    sender && sender.set('active'); // turn off the button
                    editor.store();
                    editor.on('storage:end', function (e) {

                        if(confirm("Are you sure you want to save and continue ?")){
                            if(camptype=='social'){
                                window.location.href = '../campaigns.php?s='+shortlink_+"#step-3";
                            }
                            else {
                                window.location.href = '../campaigns.php?l='+shortlink_+"#step-3";
                            }
                        }
                        else {
                            return false;
                        }
                    });
                }
            });

    </script>
  </body>
<style>



    .gjs-field {

        border: 1px solid black;
    }


    #gjs-am-uploadFile {
        cursor: pointer !important;
    }
    .gjs-block {
        height: 120px !important;
        max-height: 120px !important;
    }

    .gjs-frame {
        border:2px solid #38B9C2;
        height: 100%;

    }
    .gjs-cv-canvas {
        background-image: url("../img/background.png");
    }
    .gjs-one-bg {
        background-color: #F4F4F4;
    }

    .fa,.fab,.fas, .far {
        color: #38B9C2 !important;
    }

    .type {
        color: #38B9C2 !important;
        font-size: 12px;
    }

    .gjs-devices-c {
        color: #38B9C2 !important;
    }
    .gjs-toolbar {
        background-color: #E5E5E5 !important;
    }

    .gjs-layer-title {
        color: black;
    }
    .gjs-two-color {
        color: black !important;
    }

    .gjs-color-warn{
        color: red;
        fill: red;
    }
</style>
</html>


