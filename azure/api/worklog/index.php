<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
	header("Content-type: text/json; charset=utf-8");

    $host = "ap-cdbr-azure-east-c.cloudapp.net";
    $user = "b4aa79b2c77ddc";
    $pwd = "23d314ad";
    $db = "D4SG_VIM";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db;charset=utf8", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $sql_select = "SELECT w.*, h.hname, m.mname, s.sname
                    FROM worklog as w
                        LEFT JOIN helper as h ON w.hid = h.hid
                            LEFT JOIN masseur as m ON w.mid = m.mid
                                LEFT JOIN shop as s ON w.sid = s.sid";

            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll();


            $output = array();
            // array_push($output, $_GET);

            if(count($registrants) > 0) {
                foreach($registrants as $registrant) {
                    $obj = array('wid' => intval($registrant['wid']), 'sname' => $registrant['sname'], 'log_date' => $registrant['log_date'], 'sid' => $registrant['sid'],
                                 'mid' => intval($registrant['mid']), 'mname' => $registrant['mname'], 'assigned' => intval($registrant['assigned']),
                                 'not_assigned' => intval($registrant['not_assigned']), 'guest_num' => intval($registrant['guest_num']),
                                 'hid' => intval($registrant['hid']), 'hname' => $registrant['hname']);
                    array_push($output, $obj);
                }
            }
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
            break;

        case 'POST':
            if(!empty($_POST)) {
                try {
                    $sid = $_POST['sid'];
                    $log_date = $_POST['log_date'];
                    $mid = $_POST['mid'];
                    $assigned = $_POST['assigned'];
                    $not_assigned = $_POST['not_assigned'];
                    $hid = $_POST['hid'];
                    $guest_num = $_POST['guest_num'];
                    // $date = date("Y-m-d");
                    // Insert data
                    $sql_insert = "INSERT INTO worklog (log_date, mid, assigned, not_assigned, hid, guest_num, sid)
                               VALUES (?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql_insert);
                    $stmt->bindValue(1, $log_date);
                    $stmt->bindValue(2, $mid);
                    $stmt->bindValue(3, $assigned);
                    $stmt->bindValue(4, $not_assigned);
                    $stmt->bindValue(5, $hid);
                    $stmt->bindValue(6, $guest_num);
                    $stmt->bindValue(7, $sid);
                    // $stmt->bindValue(3, $date);
                    $stmt->execute();
                }
                catch(Exception $e) {
                    die(var_dump($e));
                }

                echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
            }
            break;

        default:
            echo "{\"Result\":\"ERROR\"}";
            break;
    }

 ?>
