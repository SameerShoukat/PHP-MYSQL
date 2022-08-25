<?php include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php' ;

$returnData = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["delete"])){
        $delete_id = $_GET["delete"];
        $query = "DELETE FROM simcustomerdata WHERE id='$delete_id'";
        if(mysqli_query($conn, $query) or die("Delete Query Failed")){
            $returnData = msg(true, 'data has been deleted');
        }
        else{
           $returnData = msg(false, 'Failed'.mysqli_error($conn));
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"),true);

if(!isset($data["status"]) || !isset($data["id"]) || empty(trim($data["status"])) || empty(trim($data["id"])) ){
    $returnData = msg(false,'All fields are required');
}

else{
    $status = $data["status"];
    $id = $data["id"];
    $query = "UPDATE simcustomerdata SET status ='$status' WHERE id='$id'";
    if(mysqli_query($conn, $query) or die("Update query failed")){
        $returnData = msg(true, 'Status has been updated succesfuly');
    }
    else{
        $returnData = msg(true, 'Failed to update Status');
    }
}
}
echo json_encode($returnData)
?>