<?php
	header("Content-type: text/json; charset=utf-8");
	echo json_encode($_GET, JSON_UNESCAPED_UNICODE);
	error_log(isset($_GET["hid"]) ? "TRUE" : "FALSE", 0);
?>
