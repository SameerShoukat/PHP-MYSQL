<?php include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';


if (isset($_GET["sim_candidate_id"])) {
    $returnData = [];

        try {
            $sim_candidate_id = $_GET["sim_candidate_id"];
            $query = "SELECT  simcustomerdata.*, users.username, users.designation FROM simcustomerdata LEFT JOIN users ON simcustomerdata.operator = users.id WHERE simcustomerdata.id = '$sim_candidate_id'";
            $result = mysqli_query($conn, $query ) or die('Query Failed');
            $count = mysqli_num_rows($result) ;
            if($count > 0){
                $data = mysqli_fetch_assoc($result);
                $returnData = msg(true, 'Order successfully retrived' , $data);
            }
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }
} else {
    $returnData = msg(false, 'Page not found');
}


echo json_encode($returnData);
