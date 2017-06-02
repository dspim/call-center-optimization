<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
	header("Content-Type: text/plain");

	if(isset($_GET['arg'])) {
		$arg = $_GET["arg"];
	} else {
<<<<<<< HEAD
<<<<<<< HEAD
		$arg = "--compare assigned --between masseur --from 2015-04-1 --to 2015-04-30";	
=======
		$arg = "-h";	
>>>>>>> 48c3d1d188b4f275f6d8911eb5766d371854a9ff
=======
		$arg = "-h";
>>>>>>> 359edd2bcf5c0c311730628254fc716b47225830
	}

	system("python ../../python/analyze.py $arg");
?>
