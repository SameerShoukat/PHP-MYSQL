<?php 
 include $_SERVER['DOCUMENT_ROOT'] . '/portal/server/config.php';
$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

$fileName  =  $_FILES['sendFile']['name'];
$tempPath  =  $_FILES['sendFile']['tmp_name'];
$fileSize  =  $_FILES['sendFile']['size'];

		
if(empty($fileName))
{
	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
	echo $errorMSG;
}
else
{
	$upload_path = 'id_card/'; // set upload folder path 
	
	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
	$t=time();
	$fileName = $t . str_replace(" ", "", $fileName);
    						
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $fileName))
		{
			// check file size '5MB'
			if($fileSize < 5000000){
				move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
			}
			else{		
				$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, image with same name already exists", "status" => false));	
			echo $errorMSG;
		}
	}
		
// if no error caused, continue ....
if(!isset($errorMSG))
{
	$path = $fileName ;
			
	echo json_encode(array("message" => "File Succesfuly Uploaded Successfully", "status" => true, "path"=> $path));	
}
?>