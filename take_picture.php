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
		<script>
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
		    //convertCanvasToImage(canvas);
		  });

		  // Attach the video stream to the video element and autoplay.
		  navigator.mediaDevices.getUserMedia(constraints)
		    .then((stream) => {
		      player.srcObject = stream;
		    });
		    // Converts canvas to an image
			// function convertCanvasToImage(canvas) {
				image = canvas.toDataURL("image/png");
				var ajax = new XMLHttpRequest();
				ajax.open("POST",'testSave.php',false);
				ajax.setRequestHeader('Content-Type', 'application/upload');
				ajax.send(image);
			//}
			// function printing(canvas) {
			// 	my_window = window.open('', 'mywindow', 'status=1,width=350,height=150');
			// 	var image = new Image();
			// 	image.src = canvas.toDataURL("image/png");
			// 	my_window.document.write(image);
			// }
			setTimeout("location.href = 'testSave.php';", 6000);
		</script>
	<input type="file" accept="image/*">
</body>
</html>