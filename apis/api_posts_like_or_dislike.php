<?php

if( ! isset($post_id) ){
  http_response_code(400);
  echo 'Invalid id';
  exit(); // die()
}

if( $like_or_dislike != 0 && $like_or_dislike != 1 ){
  http_response_code(400);
  echo 'Invalid like or dislike';
  exit();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_obj.php');

if( $like_or_dislike == 1){
  
  try{
      $q = $db->prepare("UPDATE posts SET post_likes = post_likes +1 WHERE post_uuid = '$post_id'");
      $q->execute();

      echo "liked";
    }catch(PDOException $ex){
      echo $ex;
    };
}

if( $like_or_dislike == 0){
  
  try{
      $q = $db->prepare("UPDATE posts SET post_likes = post_likes -1 WHERE post_uuid = '$post_id'");
      $q->execute();

      echo "Disliked";
    }catch(PDOException $ex){
      echo $ex;
    };
}

