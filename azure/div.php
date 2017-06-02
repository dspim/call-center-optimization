<?php 
    
	echo '<td>';
		$sql = "SELECT * FROM shop";
        $st_shop = $conn->query($sql);
        $registrants = $st_shop->fetchAll();
        if(count($registrants) > 0) {
            echo '<select  class="form-control" name="shopid">';
            echo "<option value=0>請選擇小站名</option>";
            foreach($registrants as $registrant) {
                echo "<option value=" . $registrant['sid'] . ">" . $registrant['sname'] . "</option>";
            }
            echo '</select>';
        } else echo "0 shop result!"; 
	echo '</td><td><input class="form-control" type="text" name="log_date" placeholder="2016-01-01" id="log_date"></td>';

        
    echo '<td>';
    	$sql = "SELECT * FROM masseur";
        $st_mass = $conn->query($sql);
        $reg = $st_mass->fetchAll();
        if(count($reg) > 0) {
            echo '<select class="form-control" name="masseurid">';
            echo "<option value=0>請選擇按摩師</option>";
            foreach($reg as $re) {
                echo "<option value=" . $re['mid'] . ">" . $re['mname'] . "</option>";
            }
            echo "</select>";
        } else echo "0 shop result!"; 
    echo '</td>' .
         '<td><input class="form-control" type="text" placeholder="指定節數 [限數字輸入]" name="assigned"></td>' .
         '<td><input class="form-control" type="text" placeholder="未指定節數 [限數字輸入]" name="not_assigned"></td>' .
         '<td><input class="form-control" type="text" placeholder="來客數 [限數字輸入]" name="guest_num"></td>' .
         '<td>';
         $sql = "SELECT * FROM helper";
                $st_help = $conn->query($sql);
                $reghelp = $st_help->fetchAll();
                if(count($reghelp) > 0) {
                    echo '<select class="form-control" name="helpid">';
                    echo "<option value=0>請選擇管理員</option>";
                    foreach($reghelp as $regh) {
                        echo "<option value=" . $regh['hid'] . ">" . $regh['hname'] . "</option>";
                    }
                    echo "</select>";
                } else echo "0 shop result!"; 
    echo '</td>' ;
	
	


?>