<?php

 include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';

 $returnData = [];
 if(isset($_GET["latest"])){
    $outArray = array();
    $query = "SELECT * FROM simcustomerdata WHERE MONTH(time) = MONTH(CURRENT_DATE()) AND YEAR(time) = YEAR(CURRENT_DATE()) ORDER BY time DESC LIMIT 6";
    $result = mysqli_query($conn, $query ) or die('Query Failed');
    if($result){
        while ($row = mysqli_fetch_assoc($result)) $outArray[] = $row ;
        $returnData = msg(true, 'Data successfuly retrived ' , $outArray);
    }
    else{
        $returnData = msg(false, 'No data to preview');
    }
}
else{
    $allReponse = array();
    try {
        $outArray = array();
        $query = "SELECT  simcustomerdata.*, users.username, users.designation FROM simcustomerdata LEFT JOIN users ON simcustomerdata.operator = users.id WHERE MONTH(simcustomerdata.time) = MONTH(CURRENT_DATE()) AND YEAR(simcustomerdata.time) = YEAR(CURRENT_DATE())  ORDER BY time DESC";
        $result = mysqli_query($conn, $query ) or die('Query Failed');
        if($result){
            while ($row = mysqli_fetch_assoc($result)) $outArray[] = $row ;
        
            $allReponse["data"] = $outArray;
            $allReponse["date"] = date('M').", ".date('Y');
            $allReponse["totalEntries"] = count($outArray);
            $returnData = msg(true, 'Data successfuly retrived ' , $allReponse);
        }
       
        else{
            $returnData = msg(false, 'No data to preview');
        }
    } catch (PDOException $e) {
        $returnData = msg(0, 500, $e->getMessage());
    }
}


echo json_encode($returnData);
