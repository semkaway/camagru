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
		<button id="capture" class="button">Capture</button>
		<canvas id="canvas" width=320 height=240></canvas> 
        <form method="post" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
        </form>
	<input type="file" accept="image/*">
	<script type="text/javascript">
			const player = document.getElementById('player');
			const canvas = document.getElementById('canvas');
			const context = canvas.getContext('2d');
			const captureButton = document.getElementById('capture');
			
			const constraints = {
				video: true,
			};

			captureButton.addEventListener('click', () => {
			    // Draw the video frame to the canvas.
				context.drawImage(player, 0, 0, canvas.width, canvas.height);
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_data.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Succesfully uploaded');
                    }
                };
 
                xhr.onload = function() {
 
                };
                xhr.send(fd);
			});

			  // Attach the video stream to the video element and autoplay.
			navigator.mediaDevices.getUserMedia(constraints)
				.then((stream) => {
			    	player.srcObject = stream;
				});
        </script>
</body>
</html>