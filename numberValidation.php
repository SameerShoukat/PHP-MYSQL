<?php include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';


if (isset($_GET["phone"])) {
    $returnData = [];

        try {
            $phone = $_GET["phone"];
            $query = "SELECT * FROM simcustomerdata WHERE sim_card_serial_number LIKE '$phone'";
            $result = mysqli_query($conn, $query ) or die('Query Failed');
            $count = mysqli_num_rows($result) ;
            if($count > 0){
                $returnData = msg(false, 'Number is already in use');
            }
            else{
                $returnData = msg(true, 'Number is ok');
            }
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }
} else {
    $returnData = msg(false, 'Page not found');
}


echo json_encode($returnData);
