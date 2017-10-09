<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Responsive Sketchpad</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!-- <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css"> -->

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="assets/normalize.css" />
  <link rel="stylesheet" href="assets/skeleton.css" />
  <link rel="stylesheet" href="assets/custom.css" />

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png" />

  <!-- Google Analytics
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<style type="text/css">
		
		.sketchpad{
			background: url('images/bg.jpg');
			max-height: 400px;
			max-width: 700px;
			margin: 0 auto;
		}
		
		.sketchpad canvas{
			max-height: 400px;
		}
		
		.scanvas{
			position: absolute;
		}
		
		@media (max-width: 700px) {
			.colorpicker{
				left: 0 !important;
			}
		}
		
	</style>
	
	<link rel="stylesheet" href="libs/colorpicker/css/colorpicker.css" type="text/css" />
    <!-- <link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" /> -->
	
	<script type="text/javascript" src="js/jquery-3.1.1.js"></script> 
	
	 <script type="text/javascript" src="responsive-sketchpad.js"></script>
	  <script type="text/javascript" src="js/html2canvas.js"></script>
	<script type="text/javascript" src="js/canvas2image.js"></script>
	
	<script type="text/javascript" src="libs/colorpicker/js/jquery.js"></script>
	<script type="text/javascript" src="js/form.js"></script>
	<script type="text/javascript" src="libs/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="libs/colorpicker/js/eye.js"></script>
    <script type="text/javascript" src="libs/colorpicker/js/utils.js"></script>
    <script type="text/javascript" src="libs/colorpicker/js/layout.js?ver=1.0.2"></script>
  
</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    
    
      <div class="row">
        <div class="column">
            <div class="sketchpad" id="sketchpad">				
			</div>
			
        </div>
	  </div>
		
		<!-- <div class="row">
          <div class="column">	
			<form name="photo" action="ajax_php_file.php" method="post" id="imageUploadForm" enctype="multipart/form-data" >
				<label for="line-color-input">Set Background</label>
				<input type="file" name="image" id="image" value="" required />	
			</form>
		  </div>
		 </div> -->
		
		<div class="row">
          <div class="one-half column">	
            <label for="line-color-input">Set Line Color</label>
            <input class="u-full-width" type="text" value="#000000" id="line-color-input">
		  </div>
          <div class="one-half column">
			<label for="line-size-input">Set Line Size</label>
			<input class="u-full-width" type="number" value="5" id="line-size-input">
		   </div>
		 </div> 
		 
		  <div class="row">
            <div class="one-half column">
              <button class="u-full-width" id="undo">Undo</button>
            </div>
            <div class="one-half column">
              <button class="u-full-width" id="redo">Redo</button>
            </div>
			</div>
			<div class="row">
			<div class="one-half column">
				<button class="u-full-width" id="clear">Clear</button>
			</div>
			<div class="one-half column">
				<button class="u-full-width" onclick="saveImg()">Save</button>	
			</div>
          </div>
        
  </div>

  <!-- Scripts
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

  <script>
    var el = document.getElementById('sketchpad');
    var pad = new Sketchpad(el);

    // setLineColor
    function setLineColor(e) {
        var color = e.target.value;
        if (!color.startsWith('#')) {
            color = '#' + color;
        }
        pad.setLineColor(color);
    }
    
	document.getElementById('line-color-input').oninput = setLineColor;
	
    // setLineSize
    function setLineSize(e) {
        var size = e.target.value;
        pad.setLineSize(size);
    }
    document.getElementById('line-size-input').oninput = setLineSize;

    // undo
    function undo() {
        pad.undo();
    }
    document.getElementById('undo').onclick = undo;

    // redo
    function redo() {
        pad.redo();
    }
    document.getElementById('redo').onclick = redo;

    // clear
    function clear() {
        pad.clear();
    }
    document.getElementById('clear').onclick = clear;

    // resize
    window.onresize = function (e) {
      pad.resize(el.offsetWidth);
    }
	
	function saveImg()
	{
		
		html2canvas($("#sketchpad"), {
			onrendered: function(canvas) {
				//theCanvas = canvas;
				//document.body.appendChild(canvas);

				// Convert and download as image 
				Canvas2Image.saveAsPNG(canvas); 
				/*var image = Canvas2Image.convertToPNG(canvas);
				var image_data = $(image).attr('src');
				
				$("#img-out").append(canvas);*/
				
			}
		});
	}
	
	
	
	$(function(){
		
		//$('#sketchpad canvas').attr('id','scanvas');
		
		$('#line-color-input').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val('#' + hex);
				$(el).ColorPickerHide();
				pad.setLineColor('#' + hex);
				//alert(hex);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	
		
		 $('#image').change(function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
			
               $('#sketchpad').css('background-image', 'url("' + reader.result + '")');
			   $('#sketchpad').css('background-size', '100%');
			   $('#sketchpad').css('background-repeat', 'no-repeat');
			   
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
            }
        });
		
		/*$('#image').change(function () {
			
			
			$("#imageUploadForm").ajaxSubmit({
				url: "ajax_php_file.php", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				success: function(filename)   // A function to be called if request succeeds
				{
					$('#sketchpad').css('background-image', 'url("uploads/' + filename + '")');
				    $('#sketchpad').css('background-size', '100%');
				    $('#sketchpad').css('background-repeat', 'no-repeat');
				}
			});	
        });*/
		
		
	});	
	
	
  </script>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
