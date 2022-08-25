<?php include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $returnData = [];

  $data = json_decode(file_get_contents("php://input"), true);

  if (
    !isset($data["prefered_language"]) || 
    !isset($data["date"]) || 
    !isset($data["telecom_company_name"]) || 
    !isset($data["representative"]) || 
    !isset($data["first_name"]) || 
    !isset($data["last_name"]) || 
    !isset($data["father_name"]) || 
    !isset($data["grand_father_name"]) || 
    !isset($data["gender"]) || 
    !isset($data["date_of_birth"]) || 
    !isset($data["attach_doc"]) || 
    !isset($data["profile"]) || 
    !isset($data["permanent_province"]) || 
    !isset($data["permanent_district"]) || 
    !isset($data["permanent_village"]) || 
    !isset($data["permanent_street_no"]) || 
    !isset($data["current_province"]) || 
    !isset($data["current_district"]) || 
    !isset($data["current_village"]) || 
    !isset($data["current_street_no"]) || 
    !isset($data["sim_card_serial_number"]) || 
    !isset($data["relevant_sim"]) || 
    !isset($data["operator"]) || 
    !isset($data["status"])){
    $returnData = msg(false, 'All field are required');
    }
     else {


    $query = "SELECT * From simcustomerdata WHERE sim_card_serial_number = $data[sim_card_serial_number]";
    $result = mysqli_query($conn, $query) or die('Query Failed');
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      $returnData = msg(false, 'Sim Number Already Exist');
    } else {
      //profile image path
      $base64 = $data['profile'];
      $image_parts = explode(";base64,", $base64);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1]; //image extension
      $image_base64 = base64_decode($image_parts[1]);
      $file = $data["sim_card_serial_number"].'.' . $image_type;
      $uploadFile = file_put_contents("profile/$file", $image_base64);
      $profilePath = 'profile/'.$file;
      
      //card
      if (isset($data["attach_doc"])) {
        if(isset($data["national_id_number"])){
          $dir = "id_card";
          $file = $data["attach_doc"];
          $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

          $oldName = $dir . "/" . $file;
          $newName = $dir . "/" . $data["national_id_number"] . "." . $fileExtension;
        }
        else{
          return  json_encode(msg(false, 'National ID Number is required to store data'));
        }

      }



      try {
        $query = "INSERT INTO
        simcustomerdata(
          `prefered_language`,
          `date`,
          `telecom_company_name`,
          `representative`,
          `first_name`,
          `last_name`,
          `father_name`,
          `grand_father_name`,
          `gender`,
          `date_of_birth`,
          `passport_no`,
          `afg_visa_no`,
          `citizenship`,
          `soko_no`,
          `volume_no`,
          `page_no`,
          `national_id_number`,
          `attach_doc`,
          `profile`,
          `permanent_province`,
          `permanent_district`,
          `permanent_village`,
          `permanent_street_no`,
          `current_province`,
          `current_district`,
          `current_village`,
          `current_street_no`,
          `afg_visa_exp_date`,
          `sim_card_serial_number`,
          `relevant_sim`,
          `operator`,
          `status`
        )
      VALUES
        (
          '$data[prefered_language]',
          '$data[date]',
          '$data[telecom_company_name]',
          '$data[representative]',
          '$data[first_name]',
          '$data[last_name]',
          '$data[father_name]',
          '$data[grand_father_name]',
          '$data[gender]',
          '$data[date_of_birth]',
          '$data[passport_no]',
          '$data[afg_visa_no]',
          '$data[citizenship]',
          '$data[soko_no]',
          '$data[volume_no]',
          '$data[page_no]',
          '$data[national_id_number]',
          '$newName',
          '$profilePath',
          '$data[permanent_province]',
          '$data[permanent_district]',
          '$data[permanent_village]',
          '$data[permanent_street_no]',
          '$data[current_province]',
          '$data[current_district]',
          '$data[current_village]',
          '$data[current_street_no]',
          '$data[afg_visa_exp_date]',
          '$data[sim_card_serial_number]',
          '$data[relevant_sim]',
          '$data[operator]',
          '$data[status]'
        )
      ";
        if (mysqli_query($conn, $query) or die("insert  Query failed")) {
          $id = mysqli_insert_id($conn);
          $response =array(
              "id" => $id,
              );
          $returnData = msg(true, 'Data successfully Added' , $response);
        }
      } catch (PDOException $e) {
        $returnData = msg(false, 'Failed to Add' , $response);
      }
    }
  }
} else {
  $returnData = msg(false, 'Page not found');
}


echo json_encode($returnData);

if(isset($oldName)){
  rename( $oldName , $newName);
}


