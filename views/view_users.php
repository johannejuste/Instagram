<?php
// ######### TOP
require_once(__DIR__.'/view_top_profile.php');



// ################ VALIDATION ##################
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_admin'] ) ){
  header('Location: /profile');
  exit();  
}

if( $_SESSION['user_admin'] != 1 ){
  header('Location: /profile');
  exit();  
}





// ############### SHOW USERS ############
require_once(__DIR__.'/../db/db_assoc.php');

try{
  $q = $db->prepare('SELECT * FROM users WHERE user_status = 1');
  $q->execute();
  $users = $q->fetchAll();
  
  ?>
  <div class="users_container">
    <h1>Active users</h1>
    <?php
  foreach($users as $user){
    unset($user['user_password']);
  ?>
    <div class="users">
      <div class="user_info">
      <img class="instapost_profile_img" src="<?= $user['user_profile_picture']?>" alt="profile_picture">
      </div>

      <div class="user_info">
      <div> <?= $user['user_name'] ?>  <?= $user['user_last_name'] ?></div>
      <div><?= $user['user_email'] ?></div>
      <div><?= $user['user_phone'] ?></div>
      </div>

      <div class="user_info">
      <div class="pointer" onclick="delete_user('<?= $user['user_uuid']?>')">
      🗑️
  </div>
  </div>
    </div>
    <?php
  }
  ?>
  </div>
  <?php

}catch(PDOException $ex){
  echo 'Oops, something went wrong'; 
}

try{
  $q = $db->prepare('SELECT * FROM users WHERE user_status = 0');
  $q->execute();
  $users = $q->fetchAll();
  
  ?>
  <div class="users_container">
    <h1>Unactive users</h1>
    <?php
  foreach($users as $user){
    unset($user['user_password']);
  ?>
    <div class="users">
      <div class="user_info">
      <img class="instapost_profile_img" src="<?= $user['user_profile_picture']?>" alt="profile_picture">
      </div>

      <div class="user_info">
      <div> <?= $user['user_name'] ?>  <?= $user['user_last_name'] ?></div>
      <div><?= $user['user_email'] ?></div>
      <div><?= $user['user_phone'] ?></div>
      </div>
    </div>
    <?php
  }
  ?>
  </div>
  <?php

}catch(PDOException $ex){
  echo 'Oops, something went wrong'; 
}


?>


<!-- ######## SCRIPT delete users ############ -->
<script>

async function delete_user(user_id, user_name){
  let div_user = event.target.parentNode.parentNode
  let conn = await fetch(`/users/delete/${user_id}`, {
    "method" : "POST"
  })
  if( ! conn.ok ){ alert("upps..."); return }
  let data = await conn.text()
  console.log(data)
  div_user.remove()
  location.reload();
}
</script>


<?php
// ######### BOTTOM
require_once(__DIR__.'/view_bottom.php');