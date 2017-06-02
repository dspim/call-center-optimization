<?php

include "conn.php";
//上傳檔案類型清單
$uptypes=array(
'text/csv'
);
$max_file_size=2000000; //上傳檔案大小限制, 單位BYTE
$destination_folder="~/Downloads/"; //上傳檔路徑
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<head>
<title>檔案上傳程式</title>
<style type="text/css">
	body {
		background-color: #fff; border-top: solid 10px #000;
        color: #333; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
	}
	.warning {
		color: red;
	}
	table, th {
		text-align: center;
	}
	h1 {
        margin-bottom: 30px; 
    }
    .mato {
    	margin-top: 30px;
    }
</style>
</head>


<body>
<h1>上傳頁面</h1>
csv 格式範例參考: <a href="https://goo.gl/Vud2hg">前往下載 EXCEL 空白格式</a>
<br><br>
<table class='table table-bordered table-striped'>
    <tr><th class="ww">小站</th><th class="w">日期</th><th class="ww">按摩師傅</th>
        <th class="w">指定節數</th><th class="w">未指定節數</th><th class="w">來客數</th>
        <th class="ww">管理員</th></tr>
    
    <tr>
		<td>3 雙連</td><td>2015-04-01</td><td>1 王依</td><td>	3</td><td>6</td><td>6</td><td>2 王武</td>
    </tr>
</table>

<div class="mato">
<form class="form-inline" enctype="multipart/form-data" method="post" name="upform">
上傳檔案:
<input class="form-control" id="focusedInput" name="upfile" type="file">
<input class="btn btn-default" type="submit" name="submit" value="上傳">
<input class="btn btn-default" type="button" onclick="location='/'" value="回首頁" /><br>
允許上傳的檔案類型為:<?php echo implode(',',$uptypes)?>
</form>

</div>

<?php
$gl = "";
if(isset($_POST['submit']))
// if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
	//是否存在檔案
	{
	echo "<p>您還沒有選擇檔!</p>";
	exit;
	}


	$file = $_FILES["upfile"];
	if($max_file_size < $file["size"])
	//檢查檔案大小
	{
	echo "<p>您選擇的檔太大了!</p>";
	exit;
	}

	if(!in_array($file["type"], $uptypes))
	//檢查檔案類型
	{
	echo "<p>檔案類型不符!</p>";
	exit;
	}


	$fileName = $_FILES["upfile"]['tmp_name'];
	$csvData = file_get_contents($fileName);
	$gl = $csvData;
	// echo $gl;
	$lines = explode(PHP_EOL, $csvData);
	
	$array = array();
	foreach ($lines as $line) {
	    $array[] = str_getcsv($line);
	    $m = count(str_getcsv($line));
	    $n = sizeof($lines)-1;
	}

	$ch = $array[0][0];	
	$da = $array[0][1];
	$ma = $array[0][2];
	$as = $array[0][3];
	$nas = $array[0][4];
	$gu = $array[0][5];
	$he = $array[0][6];
		if ($ch === "小站" || $da === "日期" || $ma === "師傅"|| $as === "指定節數"|| $nas === "未指定節數"|| $gu === "來客數" || $he === "管理員") {
			// echo "ok";

			print "<div class='warning'>請確認資訊如下：\n" . 
				"如有錯誤欄位請重新上傳，再點選「存入資料庫」。</div><br>" . 
				"<table class='table table-striped'>\n";
			echo "<tr>";
			echo "<th>小站</th>";
			echo "<th>日期</th>";
			echo "<th>師傅</th>";
			echo "<th>指定節數</th>";
			echo "<th>未指定節數</th>";
			echo "<th>來客數</th>";
			echo "<th>管理員</th></tr>";
			for($i=1;$i<=$n;$i++){            
			    echo "<tr>";
			    for($j=0;$j<$m;$j++){
			        echo "<td>".$array[$i][$j]."</td>";   
			    }
			    echo "</tr>\n"; 
			}
			print "</table>";


			
			echo "<form method='post'>
					<input name='gl' value='".$gl."' type='hidden'>
					<input class='btn btn-default' name='fn' type='submit' value='存入資料庫' />
					</form>";
		} else {
			echo "<div> CSV 錯誤格式</div>";
			exit;
		}
	
} if(isset($_POST['fn'])) {
	// echo 'isset '.$_POST['gl'];
	$gl = $_POST['gl'];
	try {	
		$lines = explode(PHP_EOL, $gl);
		$array = array();
		foreach ($lines as $line) {
		    $array[] = str_getcsv($line);
		    $n = sizeof($lines)-1;

		}


			for($i=1;$i<=$n;$i++){

			$sidd = $array[$i][0];
			$sspace = strpos($sidd, " ");
			$sid = substr($sidd, 0, $sspace);
			$log_date = $array[$i][1];
			$midd = $array[$i][2];
			$mspace = strpos($midd, " ");
			$mid = substr($midd, 0, $mspace);
			$assigned = $array[$i][3];
			$not_assigned = $array[$i][4];
			$guest_num = $array[$i][5];
			$hidd = $array[$i][6];
			$hspace = strpos($hidd, " ");
			$hid = substr($hidd, 0, $hspace);

			
			$sql_check = "INSERT INTO worklog (log_date, mid, assigned, not_assigned, hid, guest_num, sid) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE sid=?, hid=?, guest_num=?, assigned=?, not_assigned=?";
			$stmt = $conn->prepare($sql_check);
		        $stmt->bindValue(1, $log_date);
		        $stmt->bindValue(2, $mid);
		        $stmt->bindValue(3, $assigned);
		        $stmt->bindValue(4, $not_assigned);
		        $stmt->bindValue(5, $hid);
		        $stmt->bindValue(6, $guest_num);
		        $stmt->bindValue(7, $sid);
		        $stmt->bindValue(8, $sid);
		        $stmt->bindValue(9, $hid);
		        $stmt->bindValue(10, $guest_num);
		        $stmt->bindValue(11, $assigned);
		        $stmt->bindValue(12, $not_assigned);
		        $stmt->execute();

			// $sql_insert = "INSERT INTO worklog (log_date, mid, assigned, not_assigned, hid, guest_num, sid)
   //                 VALUES (?,?,?,?,?,?,?)";
  		
			}
			$sql_query = "SELECT * FROM worklog";
			$q = $conn->query($sql_query);
			$rows = $q->fetchAll();
			$show = count($rows);
			$new = ceil($show/30);
			echo "<script>location='index.php?page=".$new."';alert('新增成功!');</script>";
	}
    catch(Exception $e) {
        die(var_dump($e));
        echo "<script>location='upload.php';alert('CSV 格式有錯喔，請重新上傳!');</script>";
    }
		


}

?>


<script type="text/javascript">
	
$("a").click(function(event){
$("a").attr("target","_blank");});

</script>
</body>
</html>