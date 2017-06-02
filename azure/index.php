<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/> -->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<head>
<Title>Registration Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h3 {
        margin-bottom: 30px; 
    }
    h3 {
        margin-top: 30px;
        text-align: center;
    }
    .right {
        float: right;
        margin-bottom: 30px; 
        margin-left: 10px;
    }
    table, th {
        text-align: center;
    }
    .w {
        width: 150px;
    }
    .ww {
        width: 200px;
    }
    .mato {
        margin-top: 100px;
    }
</style>
</head>
<body>
<!-- filter page -->
<?php  
$conn = mysql_connect('ap-cdbr-azure-east-c.cloudapp.net','b4aa79b2c77ddc','23d314ad') or trigger_error("SQL", E_USER_ERROR);
$db = mysql_select_db('D4SG_VIM',$conn) or trigger_error("SQL", E_USER_ERROR);

//預設每頁筆數
$pageRow_records = 30;
$num_pages = 1;

if (isset($_GET['page'])) {
$num_pages = $_GET['page'];
}
$startRow_records = ($num_pages -1) * $pageRow_records;
$sql_query = "SELECT w.*, h.hname, m.mname, s.sname
                FROM worklog as w
                    LEFT JOIN helper as h ON w.hid = h.hid
                        LEFT JOIN masseur as m ON w.mid = m.mid
                            LEFT JOIN shop as s ON w.sid = s.sid";

// filter pages    
$rows=mysql_query($sql_query);
$total=mysql_num_rows($rows);
$show=ceil($total/30);

$sql_query_limit = $sql_query." LIMIT ".$startRow_records.", ".$pageRow_records;
$result = mysql_query($sql_query_limit);
$all_result = mysql_query($sql_query);
$total_records = mysql_num_rows($all_result);
$total_pages = ceil($total_records/$pageRow_records);
?>

<h1>工作列表
<input class="right btn btn-default" value="管理員列表" type="button" onclick="location='helper.php'" />
<input class="right btn btn-default" value="師傅列表" type="button" onclick="location='masseur.php'" />
<input class="right btn btn-default" value="新增工作記錄" type="button" onclick="location='create_view.php'" />
<input class="right btn btn-default" value="上傳頁面" type="button" onclick="location='upload.php'" />
<!-- <form method="post" name="frm">
    <Button class="right btn btn-danger" onClick="delete_record();">刪除</Button>
</form> -->
</h1> 
<!-- Insert registration info -->
<!-- <p>Fill in all cases everyday, then click <strong>Submit</strong> to record.</p>
<form method="post" action="create_view.php" enctype="multipart/form-data" >
      小站  <input type="text" name="sid" id="sid"/></br>
      日期  <input type="text" name="log_date" id="log_date"/></br>
      師傅編號 <input type="text" name="mid" id="mid"/></br>
      接待員編號 <input type="text" name="hid" id="hid"/></br>
      指定節數 <input type="text" name="assigned" id="assigned"/></br>
      未指定節數 <input type="text" name="not_assigned" id="not_assigned"/></br>
      來客數 <input type="text" name="guest_num" id="guest_num"/></br>
      <input type="submit" name="submit" value="Submit" />
</form> -->
<?php
    $host = "ap-cdbr-azure-east-c.cloudapp.net"; 
    $user = "b4aa79b2c77ddc";
    $pwd = "23d314ad";
    $db = "D4SG_VIM";
    // Connect to database.
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        // echo "connect";
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Insert registration info
    if(!empty($_POST)) {
        try {
        	$sid = $_POST['shopid'];
            $log_date = $_POST['log_date'];
            $mid = $_POST['masseurid'];
            $assigned = $_POST['assigned'];
            $not_assigned = $_POST['not_assigned'];
            $hid = $_POST['helpid'];
            $guest_num = $_POST['guest_num'];

            if($sid == 0 || $mid == 0 || $hid == 0 ) {
                echo "<script>alert('有欄位是空白'); window.location.href = '/';</script>";
                exit;
            }

        // Insert data
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
             // echo "<script>alert('no execute'); window.location.href = '/';</script>";

        }
        catch(Exception $e) {
            // die(var_dump($e));
            echo "<script>alert('記錄中有欄位格式錯誤喔'); window.location.href = '/';</script>";
        }

            $sql_index = "SELECT * FROM worklog";
            $q = $conn->query($sql_index);
            $rows = $q->fetchAll();
            $show = count($rows);
            $new = ceil($show/30);
            echo "<script>location='index.php?page=".$new."';alert('新增成功!');</script>";
    }

    // Retrieve data
    $sql_select = "SELECT w.*, h.hname, m.mname, s.sname
    				FROM worklog as w
    					LEFT JOIN helper as h ON w.hid = h.hid
    						LEFT JOIN masseur as m ON w.mid = m.mid
    							LEFT JOIN shop as s ON w.sid = s.sid
                                    LIMIT ".$startRow_records.", ".$pageRow_records;
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll();
    if(count($registrants) > 0) {
        ?>
<!-- here to skip -->


<!-- <h3>詳細資訊</h3> -->
<?php
        echo "<form method='post' name='frm'><table class='table table-striped'>";
        echo "<tr><th><Button class='btn btn-danger' onClick='delete_record();'>刪除</Button></th>";
        // echo "<th>編號</th>";
        echo "<th>小站</th>";
        echo "<th>日期</th>";
        echo "<th>師傅</th>";
        echo "<th>指定節數</th>";
        echo "<th>未指定節數</th>";
        echo "<th>來客數</th>";
        echo "<th>師傅薪水</th>";
        echo "<th>管理員</th>";
        echo "</tr>";
        // echo "<th>接待員薪水</th></tr>";


        foreach($registrants as $registrant) {
            echo "<tr><td><input class='chkbox' type='checkbox' value='".$registrant['wid']."' name='chk[]'></td>";
            // echo "<td>".$registrant['wid']."</td>";
            echo "<td>".$registrant['sid']." ".$registrant['sname']."</td>";
            echo "<td>".$registrant['log_date']."</td>";
            echo "<td>".$registrant['mid']." ".$registrant['mname']."</td>";
            echo "<td>".$registrant['assigned']."</td>";
            echo "<td>".$registrant['not_assigned']."</td>";
            echo "<td>".$registrant['guest_num']."</td>";
            echo "<td>".($registrant['assigned']*100 + $registrant['not_assigned']*100)."</td>";
            echo "<td>".$registrant['hid']." ".$registrant['hname']."</td>";
            echo "</tr>";
            echo "</form>";
            // echo "<td>".(($registrant['assigned']*100 + $registrant['not_assigned']*100)*1)."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No case is created.</h3>";
    }

?>

<!-- show page -->
<table border="0" class="mato" align="center">
<tr>
<td>共 <?php echo $total ?> 筆資料</td>
<td>
<?php
$range = $total_pages; 
if ($num_pages > 1) {
    echo " <a href={$_SERVER['PHP_SELF']}?page=1><<</a> ";
    $prevpage = $num_pages - 1;
    echo " <a href={$_SERVER['PHP_SELF']}?page=".$prevpage."><</a> ";
} 
// 顯示當前分頁鄰近的分頁頁數
for ($x = (($num_pages - $range) - 1); $x < (($num_pages + $range) + 1); $x++) {
    if (($x > 0) && ($x <= $total_pages)) {
        if ($x == $num_pages) {
            echo " [<b>".$x."</b>] ";
        } else {
            echo " <a href=index.php?page=".$x.">".$x."</a> ";
        } 
    } 
}  
// 如果不是最後一頁, 顯示跳往下一頁及最後一頁的連結
if ($num_pages != $total_pages) {
    $nextpage = $num_pages + 1;
    echo " <a href={$_SERVER['PHP_SELF']}?page=".$nextpage.">></a> ";
    echo " <a href={$_SERVER['PHP_SELF']}?page=".$total_pages.">>></a> ";
} 
?>
</td>
</tr>
</table>
<script type="text/javascript">
$('document').ready(function() {
    $('.chkbox').attr('checked', this.checked)
});

function delete_record()
{
document.frm.action = "delete.php?ch=1";
document.frm.submit();
}

$(function() {
    $( "#log_date" ).datepicker();
    $( "#log_date" ).datepicker( "option", "dateFormat", "yy-mm-dd");
});
</script>

</body>
</html>
