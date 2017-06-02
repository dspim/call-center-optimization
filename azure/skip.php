        <form method="post" action="index.php">
        <table class='table table-bordered table-striped'>
            <tr><th class="ww">小站</th><th class="w">日期</th><th class="ww">按摩師傅</th>
                <th class="w">指定節數</th><th class="w">未指定節數</th><th class="w">來客數</th>
                <th class="ww">管理員</th><th>新增</th></tr>
            
            <tr>
                <td>
                <?php
                        $sql = "SELECT * FROM shop";
                        $st_shop = $conn->query($sql);
                        $registrants_s = $st_shop->fetchAll();
                        if(count($registrants_s) > 0) {
                            echo "<select  class='form-control' name='shopid'>";
                            echo "<option value=0>小站名</option>";
                            foreach($registrants_s as $registrant_s) {
                                echo "<option value=" . $registrant_s['sid'] . ">" . $registrant_s['sname'] . "</option>";
                            }
                            echo "</select>";
                        } else echo "0 shop result!"; 
                ?></td>
                <td><input class='d form-control' type="text" name='log_date' placeholder='2016-01-01' id='log_date' /></td>
                <td>
                    <!-- <input class='form-control' type='text' name='mid' placeholder='mid' /> -->
                    <?php
                        $sql = "SELECT * FROM masseur";
                        $st_shop = $conn->query($sql);
                        $registrants_m = $st_shop->fetchAll();
                        if(count($registrants_m) > 0) {
                            echo "<select class='form-control' name='masseurid'>";
                            foreach($registrants_m as $registrant_m) {
                                echo "<option value=" . $registrant_m['mid'] . ">" . $registrant_m['mname'] . "</option>";
                            }
                            echo "</select>";
                        } else echo "0 shop result!"; 
                    ?>
                </td>
                <td><input class='w form-control' type='text' placeholder='限數字輸入 ex: 1' name='assigned' /></td>
                <td><input class='w form-control' type='text' placeholder='限數字輸入 ，ex: 1' name='not_assigned' /></td>
                <td><input class='w form-control' type='text' placeholder='限數字輸入 ，ex: 1' name='guest_num' /></td>
                <td>
                    <!-- <input class='form-control' type='text' name='hid' placeholder='hname' /> -->
                    <?php
                        $sql = "SELECT * FROM helper";
                        $st_shop = $conn->query($sql);
                        $registrants_h = $st_shop->fetchAll();
                        if(count($registrants_h) > 0) {
                            echo "<select class='form-control' name='helpid'>";
                            foreach($registrants_h as $registrant_h) {
                                echo "<option value=" . $registrant_h['hid'] . ">" . $registrant_h['hname'] . "</option>";
                            }
                            echo "</select>";
                        } else echo "0 shop result!"; 
                    ?>
                </td>
                <td><input class='btn btn-primary' type='submit' name='submit' value='+' /></td>
            </tr>
    
        </table>
        </form>