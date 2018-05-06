<?php
include_once('config/database.php');
include ("includes/header.php");
?>
    <title>Take picture</title>
</head>
<body>
	<h1 class="header">Hello</h1>
	<div id="photo_div">
		<video id="player" autoplay></video>
		</div>
		<button type="button" id="capture" class="button">Capture</button>
		<canvas id="canvas" width=500 height=400></canvas> 
        <form method="post" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
            <input name="selected_elem" id='selected_elem' type="hidden"/>
        </form>
        <div id="image-options">
	    	<input type="radio" name="icon" value="img/additions/sunrise.png" />
				<img class="icons" src="img/additions/sunrise.png">
	    	<input type="radio" name="icon" value="img/additions/sausage.png" />
				<img class="icons" src="img/additions/sausage.png">
    	</div>
	<form method="post" enctype="multipart/form-data">
		    Select image to upload:
		    <input type="file" name="fileToUpload" id="fileToUpload">
		    <button type="button" id="upload" class="button">Upload</button>
		</form>
	<script type="text/javascript">
			const player = document.getElementById('player');
			const canvas = document.getElementById('canvas');
			const context = canvas.getContext('2d');
			const captureButton = document.getElementById('capture');
			const uploadButton = document.getElementById('upload');
			
			const constraints = {
				video: true,
			};

			captureButton.addEventListener('click', () => {
			    // Draw the video frame to the canvas.
				var radios = document.getElementsByName('icon');

				for (var i = 0, length = radios.length; i < length; i++) {
					if (radios[i].checked) {
						var sosiska = radios[i].value;
						break;
					}
				}

				context.drawImage(player, 0, 0, canvas.width, canvas.height);
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
                document.getElementById('selected_elem').value = sosiska;
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_data.php', true);
                xhr.send(fd);
				window.location.href = 'take_picture.php';
			});

			uploadButton.addEventListener('click', () => {
				var radios = document.getElementsByName('icon');

				for (var i = 0, length = radios.length; i < length; i++) {
					if (radios[i].checked) {
						var sosiska = radios[i].value;
						break;
					}
				}

	            var files = document.getElementById('fileToUpload').files;
				var reader = new FileReader();
				reader.readAsDataURL(files[0]);
				reader.onload = function () {
				   	var dataURL = reader.result;
				   	document.getElementById('hidden_data').value = dataURL;
				   	document.getElementById('selected_elem').value = sosiska;
		            var fd = new FormData(document.forms["form1"]);
		            var xhr = new XMLHttpRequest();
		            xhr.open('POST', 'upload_data.php', true);
		            xhr.send(fd);
				}
				setTimeout("location.href = 'take_picture.php';", 2)
			});

			  // Attach the video stream to the video element and autoplay.
			navigator.mediaDevices.getUserMedia(constraints)
				.then((stream) => {
			    	player.srcObject = stream;
				});
        </script>
</body>
</html>