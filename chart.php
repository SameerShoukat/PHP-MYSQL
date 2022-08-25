
<?php

include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';

$returnData = [];
if(isset($_GET["chart"])){
  //sales array
  $query = "SELECT DATE_FORMAT(time, '%M-%Y') as month, COUNT(*) count FROM simcustomerdata WHERE YEAR(time) = YEAR(CURRENT_DATE()) GROUP BY MONTH(time) ";
//   $query = "SELECT COUNT(*) , DATE_FORMAT(time, '%M-%Y') as month  FROM simcustomerdata WHERE status='approved' GROUP BY DATE_FORMAT(time, '%M-%Y') LIMIT 6";
  $result = mysqli_query($conn, $query ) or die('Query Failed');
  if($result){
      while ($row = mysqli_fetch_assoc($result)) $salesArray[] = $row ;
      $returnData = msg(true, 'Data successfuly retrived ', $salesArray);
  }
   else{
       $returnData = msg(false, 'No data to preview');
   }
}

echo json_encode($returnData);