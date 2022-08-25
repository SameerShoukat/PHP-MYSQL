<?php include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $returnData = [];
    $allReponse = array();

    $data = json_decode(file_get_contents("php://input"), true);
    if ( !isset($data["month"]) || empty(trim($data["month"])) ||  !isset($data["year"]) || empty(trim($data["year"]))){
        $returnData = msg(false, 'All field are required');
    } else {
        try {
            $outArray = [];
            $month = trim($data["month"]);
            $year = trim($data["year"]);

            //for month name
            $monthNum  = $month;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('M');

            //getting month data
            $query = "SELECT  simcustomerdata.*, users.username, users.designation FROM simcustomerdata LEFT JOIN users ON simcustomerdata.operator = users.id WHERE MONTH(simcustomerdata.time) = '$month' AND YEAR(simcustomerdata.time) = '$year' ORDER BY time DESC";
            $result = mysqli_query($conn, $query ) or die('Query Failed');
            $count = mysqli_num_rows($result) ;
            if($count > 0){
                while ($row = mysqli_fetch_assoc($result)) $outArray[] = $row ;
                $allReponse["data"] = $outArray;
                $allReponse["date"] = $monthName . ", " . $year;
                //response
                $returnData = msg(true, 'Data successfuly retrived ' , $allReponse);
            }
            else{
                $allReponse["data"] = $outArray;
                $allReponse["date"] = $monthName . ", " . $year;
                $returnData = msg(false, 'No data exist',$allReponse);
            }
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }
    }
} else {
    $returnData = msg(false, 'Page not found');
}


echo json_encode($returnData);
