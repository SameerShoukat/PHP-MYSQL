 
//rename file name in directory


$new_name = "1234" 

//directory
$dir = "directory"; 

//new filename
$file = $new_name; 

//getting file extension
$fileExtension = pathinfo($file, PATHINFO_EXTENSION);

//old filename with directory
$oldName = $dir . "/" . $file;

//new filename
$newName = $dir . "/" . $new_name . "." . $fileExtension;


//rename file name
rename( $oldName , $newName);
