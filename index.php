<?php
session_start();
include_once('config/setup.php');
include ("includes/header.php");
?>
    <title>Camagru</title>
</head>
<body>
	<h1 class="header">Hello</h1>
</body>
</html>
<?php
    var_dump($_SESSION);
?>