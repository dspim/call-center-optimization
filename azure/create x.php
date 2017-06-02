<?php

include "conn.php";

?>

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
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> -->

<head>
<Title>新增頁面</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1 {
        margin-bottom: 30px; 
    }
    .right {
        float: right;
        margin-bottom: 30px; 
        margin-left: 10px;
    }
    .warning {
        color: red;
    }
    table, th, td {
        text-align: center;
    }
    .w {
        width: 150px;
    }
    .ww {
        width: 200px;
    }
    .td {
        text-align: center;
    }    

</style>

</head>
<body>


<h1>新增工作記錄
<input class="right btn btn-default" value="管理員列表" type="button" onclick="location='helper.php'" />
<input class="right btn btn-default" value="師傅列表" type="button" onclick="location='masseur.php'" />
<input class="right btn btn-default" value="上傳頁面" type="button" onclick="location='upload.php'" />
<input class="right btn btn-default" value="回首頁" type="button" onclick="location='/'" />
<input class='right btn btn-primary' type='button' name='add' id='add' value='新增一筆' />
</h1>

<!-- Insert registration info -->
<form method='post' action='create.php'>
記錄欄位格式參考<br><br>
<table class='table table-bordered table-striped'>
    <tr><th class="ww">小站</th><th class="w">日期</th><th class="ww">按摩師傅</th>
        <th class="w">指定節數</th><th class="w">未指定節數</th><th class="w">來客數</th>
        <th class="ww">管理員</th></tr>
    
    <tr>
        <td>雙連</td><td>2015-04-01</td><td>王依</td><td>3</td><td>6</td><td>6</td><td>王武</td>
    </tr>
</table>

<span class="warning">操作：請先按左上“新增一筆”資料，完成所有該欄位填寫再按出“預覽工作表”。</span><br>
<div id="wrongsign"></div>
<br><br>
<div id="showBlock"></div>
<button class='right btn btn-primary' type="submit" name="add">預覽工作表</button> 
</form>


<script>

$(function() {
    $("#log_date").datepicker();
    $("#log_date").datepicker( "option", "dateFormat", "yy-mm-dd");
});
  var txtId = 1;
  var php = '<?php include "div.php"; ?>';
  //add input block in showBlock
  $("#add").click(function () {
      $("#showBlock").append('<table class="table table-bordered table-striped" id="div' + txtId + '"><tr><td><span name="txtId">'+txtId+'</span></td>'+php+'<td><input class="btn btn-danger" type="button" value="x" onclick="deltxt('+txtId+')"></td></tr></table>');
      txtId++;
  });
  //remove div
  function deltxt(id) {
      $("#div"+id).remove();
  }

</script>
</body>
</html>
