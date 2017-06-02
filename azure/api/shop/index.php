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
            $sql_select = "SELECT * FROM shop";

            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll();


            $output = array();
            // array_push($output, $_GET);

            if(count($registrants) > 0) {
                foreach($registrants as $registrant) {
                    $obj = array('sname' => $registrant['sname']);
                    array_push($output, $obj);
                }
            }
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
            break;

        case 'POST':
            if(!empty($_POST)) {
                try {
                    $sid = $_POST['sid'];
                    $sname = $_POST['sname'];
                    $sql_insert = "INSERT INTO shop (sid, sname) VALUES (?,?)";
                    $stmt = $conn->prepare($sql_insert);
                    $stmt->bindValue(1, $sid);
                    $stmt->bindValue(2, $sname);
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
