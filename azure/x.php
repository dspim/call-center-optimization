<?php
error_reporting(0);
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

</head>
<body>
    <?php   

    for($i=1; $i<=2; $i++) 
    {


        $sql = "SELECT DISTINCT SUBSTRING(mname, 1, 1) AS la FROM masseur";
        $st_shop = $conn->query($sql);
        $registrants = $st_shop->fetchAll();
        if(count($registrants) > 0) {
            // echo "<form method='get' action='xx.php'>";
            echo "<select id='selela".$i."' class='form-control' name='mla$i'>";
            echo "<option value=0>請選擇</option>";
            foreach($registrants as $registrant) {
                $la = $registrant['la'];
                echo "<option>" . $la . "</option>";
            }
            echo "</select>";

        } else echo "0 shop result!"; 

        echo "<select id='sele". $i . "' class='form-control' name='masseurid".$i."'></select>";
      // echo "<select id='selela2' class='form-control' name='masseurid".$i."'><option></option></select>";
          // $sql_l = "SELECT * FROM masseur WHERE SUBSTRING(mname, 1, 1)='".$la."'";
          // $sql_l = "SELECT * FROM masseur";
          // $st_s = $conn->query($sql_l);
          // $regs = $st_s->fetchAll();
          // if(count($regs) > 0) {
          //     echo "<select class='form-control' name='masseurid".$i."'>";
          //     echo "<option value=0>請選擇按摩師傅</option>";
          //     foreach($regs as $reg) {
          //         echo "<option value=" . $reg['mid'] . ">" . $reg['mname'] . "</option>";
          //     }
          //     echo "</select>";
          // } else echo "0 shop result!"; 

    }
    ?>


<script>
<?php
    $n = 2;
    for($i=1; $i<=$n; $i++) {
?>

$(document).on("change", "#selela<?=$i?>", function() {
    $la = $(this).find("option:selected").text();
    
    $.get(
    'x.php',
     $la,
     function(){
      // this.form.submit();
      // window.open( $la, '_self');
      
          
       window.open("xx.php?data="+$la+"",'_self');
     }
    );
    
    <?php
        error_reporting(0);
        $la = $_GET['data'];
        $sql_l = "SELECT * FROM masseur WHERE SUBSTRING(mname, 1, 1)='".$la."'";
        $st_s = $conn->query($sql_l);
        $regs = $st_s->fetchAll();
        if(count($regs) > 0) {
          foreach($regs as $reg) {
    ?>
            // $('#sele<?=$i?>').append('<option value="<?=$i?>">'+'<?=$la?>'+'</option>');
            $('#sele<?=$i?>').empty().append('<option value="<?=$reg['mid']?>"'+'<?=$reg['mname']?>'+'</option>');
    <?php
          }
        }
    ?>

   
    
});
<?php
}
?>


</script>
</body>
</html>
