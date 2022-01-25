<?php

// ########### VALIDATION ############################################

if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}

if( empty( $_POST['new_post_text'] ) ){
  http_response_code(400);
  echo 'Please add text to your post';
  exit();
}

$image_type = mime_content_type($_FILES['fileToUpload']['tmp_name']); // image/png
$extension = strrchr( $image_type , '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif', 'zip', 'pdf'];

if( ! in_array($extension, $valid_extensions) ){
  http_response_code(400);
  echo 'Please add a picture to your post';
  exit();
}



// #######################################################
// #######################################################
// #######################################################



// ################### INSERT post #######################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_obj.php');

try{
$tz = 'Europe/London';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
$currentDate = $dt->format('F j Y, H:i');

  $post_image = bin2hex(random_bytes(16)).".$extension";
  move_uploaded_file($_FILES['fileToUpload']['tmp_name'], "images/posts/$post_image");
    
  $post_id = bin2hex(random_bytes(16)); // 32 alphanumeric 

    $q = $db->prepare("INSERT INTO posts (post_uuid, user_uuid, post_image, post_text, post_date_time) VALUES ( :post_uuid, :user_uuid, :post_image, :post_text, :post_date_time)");
    $q->bindValue(':post_uuid', $post_id); 
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']); 
    $q->bindValue(':post_text', $_POST['new_post_text']);
    $q->bindValue(':post_image', "images/posts/$post_image");
    $q->bindValue(':post_date_time', $currentDate);
    $q->execute();
 
    // gets post content from db
    $q2 = $db->prepare("SELECT * FROM posts AS po JOIN users AS us
    ON po.user_uuid = us.user_uuid WHERE post_uuid = :post_uuid ORDER BY po.post_date_time DESC");
    $q2->bindValue(':post_uuid', $post_id); 
    $q2->execute();
    $post = $q2->fetch();

    $JSON = json_encode($post, true); // Returns JSON format of $post
    echo $JSON;
    http_response_code(200);
    exit();
      
    }catch(PDOException $ex){
      echo $ex;
    };


  