<?php

// echo print_r($_FILES['fileToUpload']);
// echo "<div>{$_FILES['fileToUpload']['name']}</div>"; // coderspage.png
// echo "<div>{$_FILES['fileToUpload']['type']}</div>"; // image/png
// echo "<div>{$_FILES['fileToUpload']['tmp_name']}</div>"; // C:\xampp\tmp\php8B68.tmp
// echo "<div>{$_FILES['fileToUpload']['size']}</div>"; //14657
// $image_file_type = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));



$image_type = mime_content_type($_FILES['fileToUpload']['tmp_name']); // image/png
$extension = strrchr( $image_type , '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif', 'zip', 'pdf'];

if( ! in_array($extension, $valid_extensions) ){
  http_response_code(400);
  exit();
}

session_start();

foreach ($valid_extensions as $key => $value) {
  
  $user_id_image_name = $_SESSION['user_uuid'].".".$value;
  $images_location = "images/profiles/".$user_id_image_name;
  if(file_exists($images_location)){
    chmod($images_location,0755); //change the file permission if allowed
    unlink($images_location); // remove the file
  }
};


$user_id_image_name = $_SESSION['user_uuid'].".".$extension;
if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], "images/profiles/$user_id_image_name")){

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_obj.php');
  
  try{
      $q = $db->prepare("UPDATE users SET user_profile_picture = :user_profile_picture WHERE user_uuid = :user_uuid");
      $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
      $q->bindValue(':user_profile_picture', "/images/profiles/$user_id_image_name");
      if($q->execute()){  
        echo "/images/profiles/$user_id_image_name"; // response 200
        return;
      }else{
        http_response_code(400);
        exit();
    };
    }catch(PDOException $ex){
      echo 'Oops, something went wrong';
    };
}




