<?php
include_once('config/database.php');
include ("includes/header.php");
?>
    <title>Take picture</title>
</head>
<body>
	<div class="header-page"></div>
	<div class="wrapper">
        <div class="sidebar">
            <div>
                <a href="index.php"><img class="logo" src="img/logo.png"></a>
                <a href="index.php">
	                <div class="button">
	                    Home
	                </div>
	            </a>
	            <a href="take_picture.php">
	                <div class="button">
	                    Take picture
	                </div>
	            </a>
	            <a href="profile.php">
	                <div class="button">
	                    My profile
	                </div>
	            </a>
	            <a href="logout.php">
	                <div class="button">
	                    Log out
	                </div>
	            </a>
            </div>
        </div>
        <div class="take-picture-layout">
            <div id="photo_div">
            	<canvas id="preview" width=500 height=350></canvas>
				<video id="player" autoplay><canvas id="canvas" width=500 height=350></canvas> </video>
			</div>
			<div id="image-options">
				<label for="alright">
					<img name="icons" class="icons" src="img/additions/alright.png">
				</label>
				<input type="radio" name="icon" id="alright" value="img/additions/alright.png" />

				<label for="jeff">
					<img name="icons" class="icons" src="img/additions/jeff.png">
				</label>
				<input type="radio" name="icon" id="jeff" value="img/additions/jeff.png" />

				<label for="camagru">
					<img name="icons" class="icons" src="img/additions/camagru.png">
				</label>
				<input type="radio" name="icon" id="camagru" value="img/additions/camagru.png" />

				<label for="sink">
					<img name="icons" class="icons" src="img/additions/sink.png">
				</label>
				<input type="radio" name="icon" id="sink" value="img/additions/sink.png" />

				<label for="maybe">
					<img name="icons" class="icons" src="img/additions/maybe.png">
				</label>
				<input type="radio" name="icon" id="maybe" value="img/additions/maybe.png" />

				<label for="pow">
					<img name="icons" class="icons" src="img/additions/pow.png">
				</label>
				<input type="radio" name="icon" id="pow" value="img/additions/pow.png" />

				<label for="bang">
					<img name="icons" class="icons" src="img/additions/bang.png">
				</label>
				<input type="radio" name="icon" id="bang" value="img/additions/bang.png" />
	    	</div>
				<button type="submit" id="capture" class="button" onclick="setTimeout(function() { makeRequest('thumbnails'); }, 800);" disabled>Take picture</button>
			<div>
		        <form method="post" accept-charset="utf-8" name="form1">
		            <input name="hidden_data" id='hidden_data' type="hidden"/>
		            <input name="selected_elem" id='selected_elem' type="hidden"/>
		        </form>
		    </div>
		    <div class="upload">
				<form method="post" enctype="multipart/form-data" id="upload-form">
				    Select image to upload:
				    <input type="file" name="fileToUpload" id="fileToUpload">
				    <button type="button" id="upload" class="button" onclick="setTimeout(function() { makeRequest('thumbnails'); }, 800);" disabled>Upload</button>
				</form>
			</div>
			<div id="thumbnails">
			</div>
		</div>
    </div>
    <?php include("includes/footer.php"); ?>
	
	<script type="text/javascript">
			const player = document.getElementById('player');
			const canvas = document.getElementById('canvas');
			const context = canvas.getContext('2d');
			const captureButton = document.getElementById('capture');
			const uploadButton = document.getElementById('upload');
			const icons = document.querySelectorAll('.icons');
			const images = document.querySelectorAll('#images img');

			icons.forEach(click_f);

			function click_f(icon) {
				icon.addEventListener('click', iconClick);
			}
			
			const constraints = {
				video: true,
			};

			captureButton.addEventListener('click', () => {
				var radios = document.getElementsByName('icon');

				for (var i = 0, length = radios.length; i < length; i++) {
					if (radios[i].checked) {
						var icon = radios[i].value;
						break;
					}
				}

				context.drawImage(player, 0, 0, canvas.width, canvas.height);
                var dataURL = canvas.toDataURL("image/jpeg");
                document.getElementById('hidden_data').value = dataURL;
                document.getElementById('selected_elem').value = icon;
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_data.php', true);
                xhr.send(fd);
			});

			uploadButton.addEventListener('click', () => {
				var radios = document.getElementsByName('icon');

				for (var i = 0, length = radios.length; i < length; i++) {
					if (radios[i].checked) {
						var icon = radios[i].value;
						break;
					}
				}

	            var files = document.getElementById('fileToUpload').files;
				var reader = new FileReader();
				reader.readAsDataURL(files[0]);
				reader.onload = function () {
				   	var dataURL = reader.result;
				   	document.getElementById('hidden_data').value = dataURL;
				   	document.getElementById('selected_elem').value = icon;
		            var fd = new FormData(document.forms["form1"]);
		            var xhr = new XMLHttpRequest();
		            xhr.open('POST', 'upload_data.php', true);
		            xhr.send(fd);
				}
			});

			navigator.mediaDevices.getUserMedia(constraints)
				.then((stream) => {
			    	player.srcObject = stream;
				});

			function makeRequest(divID) { 
				if (window.XMLHttpRequest)
			    	httpRequest = new XMLHttpRequest();
				if (!httpRequest) {
				    alert('Giving up :( Cannot create an XMLHTTP instance');
				    return false;
				}
				httpRequest.onreadystatechange = function() { 
					alertContents(httpRequest, divID);
				};
				httpRequest.open('GET', 'thumbnails.php', true);
				httpRequest.send('');
			}

			function alertContents(httpRequest, divID) {
			    if (httpRequest.readyState == 4) {
			        if (httpRequest.status == 200) {
						document.getElementById(divID).innerHTML += httpRequest.responseText;
			        } else {
			            alert('There was a problem with the request. '+ httpRequest.status);

			        }
			    }
			}

			function iconClick() {
				document.getElementById("capture").disabled = false;
				document.getElementById("upload").disabled = false;
			    var images = document.querySelectorAll('.icons');
			    var c = document.getElementById("preview");
			    var ctx = c.getContext("2d");

			    var radios = document.getElementsByName('icon');
				for (var i = 0, length = radios.length; i < length; i++) {
				    if (radios[i].checked) {
					    var icon = radios[i].value;
					    break;
					}
				}

				for (var j = 0, length = images.length; j < length; j++) {
					var x = images[j].src.indexOf('img');
				    var proper = images[j].src.substr(x);
				    if (icon == proper) {
					    var final = images[j];
					    ctx.clearRect(0, 0, canvas.width, canvas.height);
					    ctx.drawImage(final, 300, 40, 160, 130); 
					    break;
				    }
				}
			}
        </script>
</body>
</html>